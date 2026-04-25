<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Airport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FlightController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\AirportController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CmsController;
use App\Http\Controllers\Api\WidgetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (no authentication required)
Route::prefix('v1')->group(function () {
    
    // Authentication routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    
    // Email verification routes (public)
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('api.verification.verify');
    Route::post('/email/send-verification', [AuthController::class, 'sendVerificationEmailForUser']); // For testing
    
    // Home Page Data
    Route::get('/topdestinations', [HomeController::class, 'destinations']);
    Route::get('/topairlines', [HomeController::class, 'airlines']);
    Route::get('/hotelbycities', [HomeController::class, 'hotelbycity']);
    Route::get('/hotelbycountry', [HomeController::class, 'hotelbycountry']);
    
    // Public data routes
    Route::get('/airports', [AirportController::class, 'search']);
    Route::get('/countries', [LocationController::class, 'getCountries']);
    Route::get('/blogs', [BlogController::class, 'index']);
    
    // Location data routes (Enhanced Location Controller with translations)
    Route::get('/countries/{id}', [LocationController::class, 'getCountry']);
    Route::get('/states/by-country/{countryId}', [LocationController::class, 'getStatesByCountry']);
    Route::get('/states/{id}', [LocationController::class, 'getState']);
    Route::get('/cities/by-state/{stateId}', [LocationController::class, 'getCitiesByState']);
    Route::get('/cities/by-country/{countryId}', [LocationController::class, 'getCitiesByCountry']);
    Route::get('/cities/{id}', [LocationController::class, 'getCity']);
    
    // Location data routes (User Controller with phone codes - legacy)
    Route::get('/user/states/by-country/{countryId}', [UserController::class, 'getStatesByCountry']);
    Route::get('/user/cities/by-state/{stateId}', [UserController::class, 'getCitiesByState']);
    Route::get('/user/cities/by-country/{countryId}', [UserController::class, 'getCitiesByCountry']);
    Route::get('/blogs/{blog}', [BlogController::class, 'show']);
    Route::post('/contact', [ContactController::class, 'store']);
    
    // Flight search (public)
    Route::get('/flights/search', [FlightController::class, 'search']);
    Route::get('/flights/offers', [FlightController::class, 'getOffers']);
    
    // Hotel search (public)
    Route::get('/hotels', [HotelController::class, 'indexApi']);
    Route::get('/hotels/search', [HotelController::class, 'search']);
    Route::get('/hotels/{hotel}', [HotelController::class, 'show']);
    Route::get('/hotel-types', [HotelController::class, 'getHotelTypes']);
    Route::get('/hotel-services', [HotelController::class, 'getHotelServices']);
    Route::get('/hotel-cuisines', [HotelController::class, 'getHotelCuisines']);
    Route::get('/hotel-locations', [HotelController::class, 'getHotelLocations']);
    
    // Tours API (public)
    Route::get('/tours', [TourController::class, 'index']);
    Route::get('/tours/search', [TourController::class, 'search']);
    Route::get('/tours/featured', [TourController::class, 'getFeatured']);
    Route::get('/tours/{tour}', [TourController::class, 'show']);
    Route::get('/tours/slug/{slug}', [TourController::class, 'showBySlug']);
    Route::get('/trip-types', [TourController::class, 'getTripTypes']);
    Route::get('/transport-types', [TourController::class, 'getTransportTypes']);
    
    // Services API (public)
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/search', [ServiceController::class, 'search']);
    Route::get('/services/featured', [ServiceController::class, 'getFeatured']);
    Route::get('/services/{service}', [ServiceController::class, 'show']);
    Route::get('/services/slug/{slug}', [ServiceController::class, 'showBySlug']);
    Route::get('/service-categories', [ServiceController::class, 'getCategories']);
    
    // CMS Pages API (public)
    Route::get('/cms-pages', [CmsController::class, 'index']);
    Route::get('/cms-pages/{page}', [CmsController::class, 'show']);
    Route::get('/cms-pages/slug/{slug}', [CmsController::class, 'showBySlug']);
    Route::get('/cms-pages/type/{type}', [CmsController::class, 'getByType']);
    Route::get('/about-us', [CmsController::class, 'getAboutUs']);
    Route::get('/terms-conditions', [CmsController::class, 'getTermsAndConditions']);
    Route::get('/privacy-policy', [CmsController::class, 'getPrivacyPolicy']);
    Route::get('/faq', [CmsController::class, 'getFaq']);
    Route::get('/contact-info', [CmsController::class, 'getContactInfo']);
    Route::get('/help', [CmsController::class, 'getHelp']);
    
    // Widgets API (public)
    Route::get('/widgets', [WidgetController::class, 'index']);
    Route::get('/widgets/{widget}', [WidgetController::class, 'show']);
    Route::get('/widgets/type/{type}', [WidgetController::class, 'getByType']);
    Route::get('/widgets/position/{position}', [WidgetController::class, 'getByPosition']);
    Route::get('/widgets/{widgetId}/data', [WidgetController::class, 'getWidgetData']);
    Route::get('/home-widgets', [WidgetController::class, 'getHomePageWidgets']);
    Route::get('/sidebar-widgets', [WidgetController::class, 'getSidebarWidgets']);
    Route::get('/footer-widgets', [WidgetController::class, 'getFooterWidgets']);


    // Reviews (public)
    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::get('/reviews/{review}', [ReviewController::class, 'show']);
    Route::get('/hotels/{id}/reviews', [ReviewController::class, 'showHotelReviews']);

    
    // Latest/Featured data (public)
    Route::get('/featured/hotels', [HotelController::class, 'getFeaturedHotels']);
    Route::get('/featured/airlines', [FlightController::class, 'getFeaturedAirlines']);
    
    // Payment credentials (public - for app configuration)
    Route::get('/payment/credentials', [PaymentController::class, 'getCredentials']);
    
});

// Protected routes (authentication required)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    
    // User profile management
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/update-profile', [UserController::class, 'updateProfile']);
    Route::post('/user/avatar', [UserController::class, 'updateAvatar']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    
    // Email verification (authenticated)
    Route::post('/email/resend-verification', [AuthController::class, 'resendVerificationEmail']);
    Route::get('/email/verification-status', [AuthController::class, 'checkEmailVerification']);
    Route::post('/email/test-verification', [AuthController::class, 'testEmailVerification']); // For debugging
    Route::post('/email/test-basic', [AuthController::class, 'testBasicEmail']); // For debugging
    
    // Flight bookings
    Route::get('/bookings/flights', [BookingController::class, 'flightBookings']);
    Route::post('/bookings/flights', [BookingController::class, 'storeFlightBooking']);
    Route::get('/bookings/flights/{booking}', [BookingController::class, 'showFlightBooking']);
    Route::put('/bookings/flights/{booking}/cancel', [BookingController::class, 'cancelFlightBooking']);
    Route::post('/bookings/{id}/mark-paid', [BookingController::class, 'markBookingPaid']);
    
    // Hotel bookings
    Route::get('/bookings/hotels', [BookingController::class, 'hotelBookings']);
    Route::post('/bookings/hotels', [BookingController::class, 'storeHotelBooking']);
    Route::get('/my-hotel-bookings', [BookingController::class, 'getUserHotelBookings']);
    Route::get('/bookings/hotels/{booking}', [BookingController::class, 'showHotelBooking']);
    Route::put('/bookings/hotels/{booking}/cancel', [BookingController::class, 'cancelHotelBooking']);
    
    // All bookings
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);
    
    // Reviews (authenticated users can create)
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
    
    // User's reviews
    Route::get('/user/reviews', [ReviewController::class, 'userReviews']);
    Route::get('/my-reviews', [UserController::class, 'myReviews']);
    
    // Payment history and methods
    Route::get('/payment-history', [UserController::class, 'paymentHistory']);
    Route::get('/payment-methods', [UserController::class, 'paymentMethods']);
    
    // Favorites/Wishlist
    Route::get('/favorites', [UserController::class, 'favorites']);
    Route::post('/favorites/flights/{flight}', [UserController::class, 'addFlightToFavorites']);
    Route::post('/favorites/hotels/{hotel}', [UserController::class, 'addHotelToFavorites']);
    Route::delete('/favorites/flights/{flight}', [UserController::class, 'removeFlightFromFavorites']);
    Route::delete('/favorites/hotels/{hotel}', [UserController::class, 'removeHotelFromFavorites']);
    
    // Payment APIs
    Route::post('/payments/stripe/create-intent', [PaymentController::class, 'createStripePaymentIntent']);
    Route::post('/payments/paypal/create-order', [PaymentController::class, 'createPayPalOrder']);
    Route::post('/payments/paystack/initialize', [PaymentController::class, 'initializePaystackTransaction']);
    Route::get('/payments/paystack/verify/{reference}', [PaymentController::class, 'verifyPaystackTransaction']);
    
    // Dashboard APIs
    Route::get('/dashboard/summary', [DashboardController::class, 'getSummary']);
    Route::get('/dashboard/recent-bookings', [DashboardController::class, 'getRecentBookings']);
    Route::get('/dashboard/upcoming-bookings', [DashboardController::class, 'getUpcomingBookings']);
    Route::get('/dashboard/booking-stats', [DashboardController::class, 'getBookingStats']);
});

// Admin routes (admin authentication required)
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('v1/admin')->group(function () {
    
    // User management
    Route::get('/users', [UserController::class, 'adminIndex']);
    Route::get('/users/{user}', [UserController::class, 'adminShow']);
    Route::put('/users/{user}', [UserController::class, 'adminUpdate']);
    Route::delete('/users/{user}', [UserController::class, 'adminDestroy']);
    
    // Booking management
    Route::get('/bookings', [BookingController::class, 'adminIndex']);
    Route::put('/bookings/{booking}/status', [BookingController::class, 'updateStatus']);
    
    // Content management
    Route::resource('/blogs', BlogController::class)->except(['index', 'show']);
    Route::resource('/reviews', ReviewController::class)->except(['index', 'show']);
});

// Legacy airport search route (keeping for backward compatibility)
Route::get('/airports', function (Request $request) {
    try {
        $term = $request->input('term');
        $type = $request->input('type', 'name');
        
        if (empty($term)) {
            return response()->json(['error' => 'Search term is required'], 400);
        }
        
        // Log the search parameters
        Log::info('Airport search:', ['term' => $term, 'type' => $type]);
        
        $query = Airport::query();
        
        if ($type === 'code') {
            $query->where('iata_code', 'LIKE', '%' . $term . '%');
        } else {
            $query->where(function($q) use ($term) {
                $q->where('name', 'LIKE', '%' . $term . '%')
                  ->orWhere('city', 'LIKE', '%' . $term . '%');
            });
        }
        
        $results = $query->select('id', 'name', 'city', 'iata_code')
                        ->limit(10)
                        ->get();
        
        // Log the results count
        Log::info('Search results count:', ['count' => $results->count()]);
        
        return response()->json($results);
    } catch (\Exception $e) {
        // Log the full error
        Log::error('Airport search error:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'error' => 'An error occurred while searching airports',
            'message' => $e->getMessage()
        ], 500);
    }
});
