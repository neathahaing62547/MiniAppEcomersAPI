<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f5f6f8; margin: 0; padding: 40px 20px; -webkit-text-size-adjust: 100%;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 560px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e5e8ec;">

        <!-- Header -->
        <tr>
            <td style="padding: 32px 40px 24px 40px; border-bottom: 1px solid #eef1f4;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="vertical-align: middle;">
                            <div style="width: 36px; height: 36px; background-color: #111827; border-radius: 8px; display: inline-block; text-align: center; line-height: 36px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg>
                            </div>
                        </td>
                        <td style="text-align: right; vertical-align: middle;">
                            <span style="font-size: 12px; font-weight: 600; letter-spacing: 0.4px; text-transform: uppercase; color: #9aa2ad;">Notification</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding: 36px 40px 8px 40px;">
                <h1 style="margin: 0 0 8px 0; font-size: 20px; font-weight: 700; color: #111827; line-height: 1.3;">
                    {{ $title }}
                </h1>
                <p style="margin: 0 0 24px 0; font-size: 14px; color: #6b7280; line-height: 1.5;">
                    Hi there — here's an update on your account.
                </p>

                <p style="margin: 0 0 32px 0; font-size: 15px; line-height: 1.65; color: #374151;">
                    {{ $bodyMessage }}
                </p>

                <!-- CTA Button -->
                <table role="presentation" cellpadding="0" cellspacing="0" style="margin: 0 0 8px 0;">
                    <tr>
                        <td style="border-radius: 6px; background-color: #111827;">
                            <a href="{{ url('/') }}" style="display: inline-block; padding: 12px 28px; font-size: 14px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 6px;">
                                View Details
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Divider -->
        <tr>
            <td style="padding: 8px 40px;">
                <div style="border-top: 1px solid #eef1f4;"></div>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="padding: 24px 40px 32px 40px;">
                <p style="margin: 0 0 4px 0; font-size: 12.5px; color: #9aa2ad; line-height: 1.5;">
                    This is an automated message — please don't reply directly to this email.
                </p>
                <p style="margin: 0; font-size: 12.5px; color: #9aa2ad;">
                    © {{ date('Y') }} Your Company. All rights reserved.
                </p>
            </td>
        </tr>

    </table>
</body>
</html>