<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Hotel Booking Confirmation</title>
</head>

<body>
@php
    $r        = $reservation;
    $acc      = $r['accommodation'] ?? [];
    $address  = $acc['location']['address'] ?? [];
    $currency = $r['total_currency'] ?? 'USD';
    $total    = (float) ($r['total_amount'] ?? 0);
    $tax      = (float) ($r['tax_amount'] ?? 0);
    $fees     = (float) ($r['fee_amount'] ?? 0);
@endphp
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#faf1ec">
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
                                    <img src="{{ asset('images/'.widget(1)->extra_image_1) }}" alt="Logo">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table align="center" width="650" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                        <tbody>
                            <tr>
                                <td align="center" bgcolor="#015b9c" style="padding: 20px 40px;">
                                    <h1 style="color: #ffffff; font-size: 30px; margin: 0; font-weight: bold;">
                                        @if($isAdmin)
                                            Hello Admin
                                        @else
                                            Hello {{ $guestName }}
                                        @endif
                                    </h1>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table align="center" width="650" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                        <tbody>
                            <tr>
                                <td style="padding: 30px 60px; color: #333; line-height: 26px; text-align: left;">
                                    <h2 style="font-size: 24px; color: #131224; font-weight:bold; margin-bottom: 15px;">
                                        @if($isAdmin)
                                            New Hotel Booking has been Made
                                        @else
                                            Your Hotel Booking is Confirmed
                                        @endif
                                    </h2>

                                    <p style="margin-bottom: 20px;">
                                        @if($isAdmin)
                                            A new hotel booking was just made on Nomaly Travel by <strong>{{ $guestName }}</strong>.
                                        @else
                                            Thank you for booking with Nomaly Travel. Your reservation is confirmed. Please keep this email for your records.
                                        @endif
                                    </p>

                                    <p><strong>Booking Reference:</strong> {{ $r['reference'] ?? $r['id'] ?? 'N/A' }}</p>

                                    <p style="margin-top: 20px;"><strong>Hotel Details:</strong></p>
                                    <p style="margin: 0 0 4px;"><strong>Hotel:</strong> {{ $acc['name'] ?? 'N/A' }}</p>
                                    <p style="margin: 0 0 4px;"><strong>Address:</strong> {{ trim(($address['line_one'] ?? '') . ', ' . ($address['city_name'] ?? ''), ', ') ?: 'N/A' }}</p>
                                    <p style="margin: 0 0 4px;"><strong>Check-in:</strong> {{ $r['check_in_date'] ?? 'N/A' }}</p>
                                    <p style="margin: 0 0 16px;"><strong>Check-out:</strong> {{ $r['check_out_date'] ?? 'N/A' }}</p>

                                    <p><strong>Payment Summary:</strong></p>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="4" style="font-size: 14px; color: #333;">
                                        <tr>
                                            <td>Base rate</td>
                                            <td align="right">{{ $currency }} {{ number_format($total - $tax - $fees, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tax</td>
                                            <td align="right">{{ $currency }} {{ number_format($tax, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Fees</td>
                                            <td align="right">{{ $currency }} {{ number_format($fees, 2) }}</td>
                                        </tr>
                                        @if(!empty($r['due_at_accommodation_amount']))
                                        <tr>
                                            <td style="color:#777;">Due at property</td>
                                            <td align="right" style="color:#777;">{{ $currency }} {{ number_format((float) $r['due_at_accommodation_amount'], 2) }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td style="border-top: 1px solid #ddd;"><strong>Total charged</strong></td>
                                            <td align="right" style="border-top: 1px solid #ddd;"><strong>{{ $currency }} {{ number_format($total, 2) }}</strong></td>
                                        </tr>
                                    </table>

                                    @if(!empty($r['room_name']))
                                    <p style="margin: 0 0 16px;"><strong>Room:</strong> {{ $r['room_name'] }}</p>
                                    @endif

                                    <p style="margin-top: 20px;"><strong>Cancellation Policy:</strong></p>
                                    @if(!empty($r['free_cancel_until']))
                                        <p style="margin: 0 0 4px;">
                                            <span style="color:#27ae60; font-weight:bold;">Free cancellation</span>
                                            before {{ date('M j, Y g:i A', strtotime($r['free_cancel_until'])) }}
                                        </p>
                                    @elseif(!empty($r['non_refundable']))
                                        <p style="margin: 0 0 4px;">
                                            <span style="color:#c0392b; font-weight:bold;">Non-refundable</span> — this rate cannot be cancelled or refunded.
                                        </p>
                                    @else
                                        <p style="margin: 0 0 4px;">Contact the property or Nomaly Travel for cancellation details.</p>
                                    @endif

                                    @unless($isAdmin)
                                    <p style="margin-top: 24px;">If you have any questions about your reservation, just reply to this email and our team will help you out.</p>
                                    <p style="margin-top: 8px;">Safe travels,<br>The Nomaly Travel Team</p>
                                    @endunless
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table align="center" width="650" border="0" cellspacing="0" cellpadding="0" bgcolor="#015b9c">
                        <tbody>
                            <tr>
                                <td align="center" style="padding: 15px; color: #ffffff; font-size: 12px;">
                                    &copy; {{ date('Y') }} Nomaly Travel. All rights reserved.
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
