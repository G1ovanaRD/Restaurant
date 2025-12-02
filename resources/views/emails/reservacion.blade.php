<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body style="margin:0;padding:0;background-color:#f3f7f6;font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Liberation Sans', sans-serif;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:#f3f7f6;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="680" style="max-width:680px;width:100%;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e7e9e8;">

                    <tr>
                        <td style="padding:12px 0;background:#fff;text-align:center;" colspan="2"></td>
                    </tr>
                        <td style="padding:0 36px 20px 36px;">
                            <table role="presentation" width="100%" style="border-collapse:collapse;font-size:14px;color:#444;">
                                <tr>
                                    <td style="padding:8px 0;width:40%;color:#888;">Nombre</td>
                                    <td style="padding:8px 0;font-weight:700;">{{ $cliente?->name ?? 'Cliente' }}</td>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>

                  
                    <tr>
                        <td style="padding:0 36px 22px 36px;text-align:center;">
                            <div style="display:inline-block;background:#fff;border:1px solid #e6e8e7;border-radius:6px;padding:16px 20px;min-width:300px;">
                                <div style="font-size:13px;color:#555;">📍 San Luis Potosí, SLP</div>
                                <div style="margin-top:8px;"><a href="https://www.google.com/maps/search/?api=1&query=San+Luis+Potosi" style="color:#16a34a;text-decoration:none;font-weight:700;">Ver cómo llegar</a></div>
                            </div>
                        </td>
                    </tr>

                    <!-- Action buttons -->
                    <tr>
                        <td style="padding:0 36px 28px 36px;text-align:center;">
                            <a href="#" style="display:inline-block;padding:12px 22px;background:#16a34a;color:#fff;border-radius:8px;text-decoration:none;font-weight:700;margin-right:10px;">Modificar reservación</a>
                            <a href="#" style="display:inline-block;padding:12px 22px;background:transparent;color:#16a34a;border:2px solid #16a34a;border-radius:8px;text-decoration:none;font-weight:700;">Cancelar reservación</a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#fbfdfb;padding:18px 24px;border-top:1px solid #eef0ef;color:#777;font-size:13px;text-align:center;">
                            © {{ date('Y') }} Foody — San Luis Potosí, SLP · Tel: (444) 123-4567
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
