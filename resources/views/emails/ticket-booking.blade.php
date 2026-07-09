<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ticket Order Confirmation</title>
</head>

<body>
@php
    $b        = $booking;
    $event    = $b['event'] ?? [];
    $group    = $b['group'] ?? [];
    $venue    = $event['venue'] ?? [];
    $currency = $b['currency'] ?? 'USD';
    $qty      = (int) ($b['quantity'] ?? 1);
    $total    = (float) ($b['total'] ?? 0);
    $when     = !empty($event['date']) ? date('l, M j, Y g:i A', strtotime($event['date'])) : 'TBA';
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
                                            Hello {{ $buyerName }}
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
                                            New Ticket Order has been Placed
                                        @else
                                            Your Ticket Order is Confirmed
                                        @endif
                                    </h2>

                                    <p style="margin-bottom: 20px;">
                                        @if($isAdmin)
                                            A new ticket order was just placed on Nomaly Travel by <strong>{{ $buyerName }}</strong> ({{ $b['email'] ?? '' }}, {{ $b['phone'] ?? '' }}).
                                        @else
                                            Thank you for ordering with Nomaly Travel. Your tickets are confirmed. Please keep this email for your records.
                                        @endif
                                    </p>

                                    @if(!empty($b['order_id']))
                                    <p><strong>Order Reference:</strong> {{ $b['order_id'] }}</p>
                                    @endif

                                    <p style="margin-top: 20px;"><strong>Event Details:</strong></p>
                                    <p style="margin: 0 0 4px;"><strong>Event:</strong> {{ $event['name'] ?? 'N/A' }}</p>
                                    <p style="margin: 0 0 4px;"><strong>Venue:</strong> {{ trim(($venue['name'] ?? '') . ', ' . ($venue['city'] ?? ''), ', ') ?: 'N/A' }}</p>
                                    <p style="margin: 0 0 16px;"><strong>Date:</strong> {{ $when }}</p>

                                    <p><strong>Ticket Details:</strong></p>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="4" style="font-size: 14px; color: #333;">
                                        <tr>
                                            <td>Section / Row</td>
                                            <td align="right">{{ $group['section'] ?? 'N/A' }}{{ !empty($group['row']) ? ' / Row '.$group['row'] : '' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Quantity</td>
                                            <td align="right">{{ $qty }}</td>
                                        </tr>
                                        <tr>
                                            <td>Price per ticket</td>
                                            <td align="right">{{ $currency }} {{ number_format($qty ? $total / $qty : 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery</td>
                                            <td align="right">{{ implode(', ', $group['delivery_methods'] ?? []) ?: 'E-Ticket' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border-top: 1px solid #ddd;"><strong>Total charged</strong></td>
                                            <td align="right" style="border-top: 1px solid #ddd;"><strong>{{ $currency }} {{ number_format($total, 2) }}</strong></td>
                                        </tr>
                                    </table>

                                    <p style="margin-top: 20px;"><strong>Delivery:</strong>
                                        Your tickets will be delivered to {{ $b['email'] ?? 'your email address' }}.
                                        E-Tickets typically arrive before the event date set by the seller.
                                    </p>

                                    @unless($isAdmin)
                                    <p style="margin-top: 24px;">If you have any questions about your order, just reply to this email and our team will help you out.</p>
                                    <p style="margin-top: 8px;">Enjoy the event,<br>The Nomaly Travel Team</p>
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
