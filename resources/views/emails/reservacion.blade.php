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

                    <!-- Top logo -->
                    <tr>
                        <td style="padding:18px 0;background:#fff;text-align:center;">
                            <!-- small logo -->
                            <div style="display:inline-block;padding:6px 10px;border-radius:6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="110" height="28" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3V2"/><path d="m15.4 17.4 3.2-2.8a2 2 0 1 1 2.8 2.9l-3.6 3.3c-.7.8-1.7 1.2-2.8 1.2h-4c-1.1 0-2.1-.4-2.8-1.2l-1.302-1.464A1 1 0 0 0 6.151 19H5"/><path d="M2 14h12a2 2 0 0 1 0 4h-2"/><path d="M4 10h16"/><path d="M5 10a7 7 0 0 1 14 0"/><path d="M5 14v6a1 1 0 0 1-1 1H2"/></svg>
                            </div>
                        </td>
                                <!-- confirmation id removed as requested -->
                        <td style="background:#fff;padding:0;">
                            @php
                                // usar la imagen `public/images/hero-email.jpg` como hero en los correos
                                $hero = asset('images/hero-email.jpg');
                                if (!preg_match('/^https?:\/\//i', $hero)) {
                                    $hero = rtrim(config('app.url', ''), '/') . '/' . ltrim($hero, '/');
                                }
                            @endphp
                            <img src="{{ $hero }}" alt="Foody" style="width:100%;height:160px;object-fit:cover;display:block;" />
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td style="padding:28px 36px 8px 36px;text-align:center;">
                            <h2 style="margin:0;font-size:22px;color:#111;font-weight:700;">Tu reservación está confirmada</h2>
                            <div style="margin-top:8px;color:#6b6f6d;font-size:14px;">Foody · Restaurante en San Luis Potosí</div>
                        </td>
                    </tr>

                    <!-- Details -->
                    <tr>
                        <td style="padding:12px 36px 20px 36px;text-align:center;">
                            <div style="display:inline-block;background:#fafafa;border:1px solid #eef0ef;border-radius:8px;padding:16px 20px;text-align:center;min-width:320px;">
                                <div style="color:#555;font-size:14px;">Mesa para <strong>{{ $reservacion->numero_personas }}</strong></div>
                                <div style="margin-top:6px;font-size:13px;color:#333;font-weight:600;">{{ \Carbon\Carbon::parse($reservacion->fecha_hora)->translatedFormat('l, d \de F \de Y \a \las H:i') ?? $reservacion->fecha_hora }}</div>
                            </div>
                        </td>
                    </tr>

                    <!-- Info rows (Name / Confirmation) -->
                    <tr>
                        <td style="padding:0 36px 20px 36px;">
                            <table role="presentation" width="100%" style="border-collapse:collapse;font-size:14px;color:#444;">
                                <tr>
                                    <td style="padding:8px 0;width:40%;color:#888;">Nombre</td>
                                    <td style="padding:8px 0;font-weight:700;">{{ $cliente?->name ?? 'Cliente' }}</td>
                                </tr>
                                <!-- confirmation id removed as requested -->
                            </table>
                        </td>
                    </tr>

                    <!-- Address / Directions box -->
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
