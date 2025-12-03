<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        /* Minimal responsive rules for email clients */
        @media only screen and (max-width:600px){
            .container { width:100% !important; border-radius:0 !important; }
            .stack { display:block !important; width:100% !important; }
            .btn { display:block !important; width:100% !important; box-sizing:border-box; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background-color:#f3f7f6;font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Liberation Sans', sans-serif;color:#223;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:#f3f7f6;padding:28px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="680" class="container" style="max-width:680px;width:100%;background:#ffffff;border-radius:10px;overflow:hidden;border:1px solid #e7e9e8;">

                    <!-- Header -->
                    <tr>
                        <td style="padding:20px 28px 10px 28px;background:linear-gradient(90deg,#16a34a20,#ffffff);text-align:left;">
                            <div style="font-size:18px;font-weight:800;color:#111;">Foody</div>
                            <div style="font-size:13px;color:#6b7280;margin-top:4px;">Confirmación de reservación</div>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:18px 28px 8px 28px;">
                            <p style="margin:0 0 12px 0;color:#374151;font-size:15px;">Hola <strong>{{ $cliente?->name ?? 'Cliente' }}</strong>,<br>Gracias por reservar con Foody. Aquí están los detalles de tu reservación:</p>

                            <table role="presentation" width="100%" style="border-collapse:separate;border-spacing:0 8px;font-size:14px;color:#374151;">
                                <tr>
                                    <td style="width:38%;padding:10px 12px;background:#f8faf8;border:1px solid #eef2e7;border-radius:8px;color:#6b7280;">Mesa</td>
                                    <td style="padding:10px 12px;background:#fbfffb;border:1px solid #eef2e7;border-radius:8px;font-weight:700;">{{ $reservacion?->mesa_id ?? ($mesa?->id ?? '—') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 12px;background:#f8faf8;border:1px solid #eef2e7;border-radius:8px;color:#6b7280;">Fecha y hora</td>
                                    <td style="padding:10px 12px;background:#fbfffb;border:1px solid #eef2e7;border-radius:8px;font-weight:700;">{{ isset($reservacion->fecha_hora) ? \Carbon\Carbon::parse($reservacion->fecha_hora)->format('d/m/Y H:i') : (isset($fecha_hora) ? $fecha_hora : '—') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 12px;background:#f8faf8;border:1px solid #eef2e7;border-radius:8px;color:#6b7280;">Personas</td>
                                    <td style="padding:10px 12px;background:#fbfffb;border:1px solid #eef2e7;border-radius:8px;font-weight:700;">{{ $reservacion?->numero_personas ?? ($numero_personas ?? '—') }} personas</td>
                                </tr>
                            </table>

                            <p style="margin:14px 0 0 0;color:#4b5563;font-size:13px;">Si necesitas modificar o cancelar tu reservación puedes usar los botones abajo o contactarnos por teléfono.</p>
                        </td>
                    </tr>

                    <!-- Map / Location -->
                    <tr>
                        <td style="padding:0 28px 18px 28px;text-align:center;">
                            <div style="display:inline-block;background:#fff;border:1px solid #e6e8e7;border-radius:8px;padding:14px 18px;min-width:260px;">
                                <div style="font-size:13px;color:#374151;">📍 Foody — San Luis Potosí, SLP</div>
                                <div style="margin-top:8px;"><a href="https://www.google.com/maps/search/?api=1&query=San+Luis+Potosi" style="color:#16a34a;text-decoration:none;font-weight:700;">Ver en Google Maps</a></div>
                            </div>
                        </td>
                    </tr>

                    <!-- Action buttons -->
                    <tr>
                        <td style="padding:0 20px 22px 20px;text-align:center;">
                            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                                <a href="#" class="btn" style="display:inline-block;padding:12px 18px;background:#16a34a;color:#fff;border-radius:8px;text-decoration:none;font-weight:700;">Modificar reservación</a>
                                <a href="#" class="btn" style="display:inline-block;padding:12px 18px;background:transparent;color:#16a34a;border:2px solid #16a34a;border-radius:8px;text-decoration:none;font-weight:700;">Cancelar reservación</a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#fbfdfb;padding:18px 24px;border-top:1px solid #eef0ef;color:#6b7280;font-size:13px;text-align:center;">
                            <div style="margin-bottom:6px;">© {{ date('Y') }} Foody</div>
                            <div style="font-size:12px;color:#9ca3af;">San Luis Potosí, SLP · Tel: (444) 123-4567</div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
