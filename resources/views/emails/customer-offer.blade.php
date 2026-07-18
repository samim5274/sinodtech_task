<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subjectText }}</title>
</head>

<body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;color:#334155;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f7fb;padding:40px 15px;">
<tr>
<td align="center">

<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:18px;overflow:hidden;border:1px solid #e5e7eb;">

    <!-- Header -->
    <tr>
        <td align="center" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);padding:45px 25px;">

            <div style="font-size:55px;margin-bottom:10px;">
                🎁
            </div>

            <h1 style="margin:0;color:#fff;font-size:30px;font-weight:bold;">
                Exclusive Offer
            </h1>

            <p style="margin-top:10px;color:#e0e7ff;font-size:15px;">
                Special rewards for our valued customers
            </p>

        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td style="padding:40px 35px;">

            <h2 style="margin-top:0;color:#111827;font-size:22px;">
                Hello,
            </h2>

            <p style="font-size:16px;color:#475569;line-height:28px;">
                We appreciate your continued support.
                To thank you, we've prepared something special just for you.
            </p>

            <!-- Offer Card -->
            <table width="100%" cellpadding="0" cellspacing="0"
                   style="margin:35px 0;background:#eef2ff;border:1px dashed #6366f1;border-radius:12px;">

                <tr>
                    <td align="center" style="padding:30px;">

                        <div style="font-size:46px;">
                            🎉
                        </div>

                        <h2 style="margin:15px 0 10px;color:#4338ca;">
                            Limited Time Offer
                        </h2>

                        <p style="margin:0;color:#475569;font-size:16px;">
                            Enjoy exclusive savings on your next purchase.
                        </p>

                    </td>
                </tr>

            </table>

            <!-- Dynamic Message -->
            <div style="font-size:15px;line-height:28px;color:#374151;white-space:pre-line;">
                {{ $bodyText }}
            </div>

            <!-- CTA -->
            <table align="center" cellpadding="0" cellspacing="0" style="margin:40px auto;">
                <tr>
                    <td align="center"
                        style="background:#4f46e5;border-radius:8px;">

                        <a href="https://yourwebsite.com"
                           style="display:inline-block;padding:15px 35px;color:#fff;text-decoration:none;font-size:16px;font-weight:bold;">
                            Shop Now →
                        </a>

                    </td>
                </tr>
            </table>

            <p style="margin-top:30px;font-size:14px;color:#64748b;">
                Don't miss out — this offer won't last forever.
            </p>

            <p style="margin-top:30px;font-size:15px;color:#334155;">
                Best Regards,<br>
                <strong>SAMIM-Hossen</strong>
            </p>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f8fafc;padding:30px;text-align:center;border-top:1px solid #e5e7eb;">

            <p style="margin:0;font-size:13px;color:#64748b;">
                © {{ date('Y') }} SAMIM-Hossen
            </p>

            <p style="margin:10px 0 0;color:#94a3b8;font-size:12px;">
                Thank you for choosing us.
            </p>

            <p style="margin:20px 0 0;font-size:11px;color:#94a3b8;">
                If you no longer wish to receive promotional emails,
                you can unsubscribe at any time.
            </p>

        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>