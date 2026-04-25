<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRules;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', PasswordRules::defaults()],
            'mobile' => 'nullable|string|max:20',
            'country' => 'nullable|integer|exists:countries,id',
            'state' => 'nullable|integer|exists:states,id',
            'city' => 'nullable|integer|exists:cities,id',
            'country_code' => 'nullable|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'mobile' => $request->mobile,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'country_code' => $request->country_code,
            ]);

            // Generate and send verification code
            try {
                Log::info('Attempting to send verification code', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'user_created_at' => $user->created_at
                ]);

                // Generate and send verification code
                $verificationCode = $user->generateAndSendVerificationCode();
                
                Log::info('Verification code sent successfully', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'verification_sent_at' => now()
                ]);

                // Add verification info to response
                $verificationSent = true;
                $verificationMessage = 'Verification code sent successfully to your email';

            } catch (\Exception $e) {
                Log::error('Failed to send verification code', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Continue with registration even if verification fails
                $verificationSent = false;
                $verificationMessage = 'Registration successful but verification code failed to send';
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer',
                                    'verification' => [
                    'sent' => $verificationSent ?? false,
                    'message' => $verificationMessage ?? 'Verification status unknown',
                    'type' => 'code'
                ]
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', PasswordRules::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }

    /**
     * Send password reset link
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $email = $request->email;
            $user = User::where('email', $email)->first();

            if (!$user) {
                Log::info('Password reset requested for non-existent email', [
                    'email' => $email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'If a user with that email address exists, we will send a password reset link.'
                ]);
            }

            Log::info('Password reset requested', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Generate password reset token
            $token = Password::createToken($user);
            
            // Create reset URL
            $resetUrl = url('/reset-password', [
                'token' => $token,
                'email' => $user->email
            ]);

            // Send custom password reset email
            try {
                Mail::to($user->email)->send(new PasswordResetMail($user, $resetUrl));
                
                Log::info('Password reset email sent successfully', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'reset_url' => $resetUrl,
                    'sent_at' => now()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Password reset link sent to your email'
                ]);

            } catch (\Exception $e) {
                Log::error('Failed to send password reset email', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send password reset email. Please try again later.'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Password reset error', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request. Please try again later.'
            ], 500);
        }
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRules::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                Log::info('Password reset attempted for non-existent user', [
                    'email' => $request->email,
                    'ip' => $request->ip()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            Log::info('Password reset attempt', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    Log::info('Password reset successful', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'reset_at' => now()
                    ]);
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password reset successfully'
                ]);
            } else {
                Log::warning('Password reset failed', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'status' => $status,
                    'ip' => $request->ip()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired reset token. Please request a new password reset link.'
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Password reset error', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while resetting your password. Please try again later.'
            ], 500);
        }
    }

    /**
     * Resend email verification
     */
    public function resendVerificationEmail(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user->is_verified) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email is already verified'
                ], 400);
            }

            $user->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'message' => 'Verification email sent successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to resend verification email: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification email',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify email address
     */
    public function verifyEmail(Request $request)
    {
        try {
            Log::info('Email verification attempt', [
                'user_id' => $request->id,
                'hash' => $request->hash,
                'request_data' => $request->all()
            ]);

            $user = User::find($request->id);
            
            if (!$user) {
                Log::error('User not found for email verification', [
                    'user_id' => $request->id
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            Log::info('User found for email verification', [
                'user_id' => $user->id,
                'email' => $user->email,
                'email_verified' => $user->is_verified
            ]);

            if ($user->is_verified) {
                Log::info('Email already verified', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Email is already verified'
                ]);
            }

            // Verify the hash
            $hash = sha1($user->getEmailForVerification());
            Log::info('Hash verification', [
                'provided_hash' => $request->hash,
                'calculated_hash' => $hash,
                'hash_match' => hash_equals($hash, $request->hash)
            ]);

            if (!hash_equals($hash, $request->hash)) {
                Log::error('Invalid verification hash', [
                    'user_id' => $user->id,
                    'provided_hash' => $request->hash,
                    'calculated_hash' => $hash
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid verification link'
                ], 400);
            }

            $user->markEmailAsVerified();

            Log::info('Email verified successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'verified_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to verify email', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify email',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check email verification status
     */
    public function checkEmailVerification(Request $request)
    {
        try {
            $user = $request->user();
            
            return response()->json([
                'success' => true,
                'data' => [
                                    'email_verified' => $user->is_verified,
                'email_verified_at' => $user->email_verified_at
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check email verification status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test email verification (for debugging)
     */
    public function testEmailVerification(Request $request)
    {
        try {
            $user = $request->user();
            
            Log::info('Testing email verification', [
                'user_id' => $user->id,
                'email' => $user->email,
                'email_verified' => $user->is_verified
            ]);

            // Send verification email
            $user->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'message' => 'Test verification email sent',
                'data' => [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'email_verified' => $user->is_verified,
                    'test_sent_at' => now()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Test email verification failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Test email verification failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test basic email functionality (for debugging)
     */
    public function testBasicEmail(Request $request)
    {
        try {
            $user = $request->user();
            
            Log::info('Testing basic email functionality', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            // Send a simple test email
            Mail::raw('This is a test email from TravelIn API', function($message) use ($user) {
                $message->to($user->email)
                        ->subject('TravelIn API Email Test')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully',
                'data' => [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'test_sent_at' => now(),
                    'mail_config' => [
                        'from_address' => config('mail.from.address'),
                        'from_name' => config('mail.from.name'),
                        'mailer' => config('mail.default')
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Basic email test failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'mail_config' => [
                    'from_address' => config('mail.from.address'),
                    'from_name' => config('mail.from.name'),
                    'mailer' => config('mail.default')
                ]
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Basic email test failed',
                'error' => $e->getMessage(),
                'mail_config' => [
                    'from_address' => config('mail.from.address'),
                    'from_name' => config('mail.from.name'),
                    'mailer' => config('mail.default')
                ]
            ], 500);
        }
    }

    /**
     * Manually send verification email for testing
     */
    public function sendVerificationEmailForUser(Request $request)
    {
        try {
            $email = $request->email;
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            Log::info('Manually sending verification email', [
                'user_id' => $user->id,
                'email' => $user->email,
                'email_verified' => $user->is_verified
            ]);

            // Send verification email
            $user->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'message' => 'Verification email sent successfully',
                'data' => [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'email_verified' => $user->is_verified,
                    'sent_at' => now()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to manually send verification email', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification email',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 