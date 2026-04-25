<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Password Reset</title>
</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#faf1ec" style="font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, 'sans-serif'">
  <tbody>
    <tr>
      <td height="50">&nbsp;</td>
    </tr>
    <tr>
      <td>
    <table width="650" border="0" align="center" cellpadding="10" cellspacing="0" bgcolor="#ffffff" style="border-top: 5px solid #015b9c;">
        <tbody>
        <tr>
            <td align="center" height="100">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                
            </td>
        </tr>
        </tbody>
    </table>
            
    <!-- hero_welcome -->
    <table align="center" width="650" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
        <tbody>
        <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td>
                        <table role="presentation" class="column" width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td align="center" bgcolor="#015b9c" style="padding: 20px 40px;">
                                    <h1 style="color: #ffffff; font-size: 30px; margin: 0; font-weight: bold;">Password Reset Request</h1>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table></td>
        </tr>
        </tbody>
    </table>
            
    
    <!-- content -->
    <table align="center" width="650" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
        <tbody>
            
            
        <tr>
            <td style="padding: 30px 60px; color: #333; line-height: 26px; text-align: left;">
                
        
            <h2 style="font-size: 30px; color: #131224; font-weight:bold; margin-bottom: 0;">Reset Your Password</h2>
            <p style="color: #777; margin-bottom: 30px;">
                
                Hello {{ $user->name }},<br><br>
                
                We received a request to reset your password for your TravelIn account. If you didn't make this request, you can safely ignore this email.
                <br><br>
                To reset your password, click the button below:
            </p>
            <a href="{{ $resetUrl }}" style="display: inline-block; background: #f8b93a; color: #000; font-size: 14px; font-weight: bold; text-align: center; text-decoration: none; padding: 10px 25px;">
                Reset Password
            </a>

            <p style="color: #777; margin-top: 30px;">
            This password reset link will expire in 60 minutes for security reasons.
            <br><br>
            If the button doesn't work, you can copy and paste this link into your browser:
            <br>
            <a href="{{ $resetUrl }}" style="color: #015b9c; word-break: break-all;">{{ $resetUrl }}</a>
            </p>

            <p style="color: #555; margin-top: 40px;">
            <strong> Warm Regards</strong><br>
                The TravelIn Team<br>
                <a href="{{url('/')}}" target="_blank" style="color: #015b9c;">{{url('/')}}</a>
            </p>
                
            </td>       
        </tr>
            
            
        </tbody>
    </table>
            
        </td>
        </tr>
        <tr>
        <td height="50">&nbsp;</td>
        </tr>
    </tbody>
</table>
	
	
</body>
</html> 