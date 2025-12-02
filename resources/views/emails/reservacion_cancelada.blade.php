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
            <td style="padding:12px 0;background:#fff;text-align:center;"></td>
          </tr>

         
          <tr>
            <td style="padding:22px 36px 8px 36px;text-align:center;">
              <h2 style="margin:0;font-size:20px;color:#111;font-weight:700;">Tu reservación fue cancelada</h2>
              <div style="margin-top:8px;color:#6b6f6d;font-size:13px;">Foody · San Luis Potosí</div>
            </td>
          </tr>

         
          <tr>
            <td style="padding:0 36px 18px 36px;text-align:center;">
              <div style="display:inline-block;background:#fff;border:1px solid #f3e6e6;border-radius:8px;padding:14px 18px;min-width:320px;">
                <div style="color:#555;font-size:14px;">Mesa para <strong>{{ $reservacion->numero_personas }}</strong></div>
                <div style="margin-top:6px;font-size:13px;color:#333;font-weight:600;">{{ \Carbon\Carbon::parse($reservacion->fecha_hora)->translatedFormat('l, d \de F \de Y \a \las H:i') ?? $reservacion->fecha_hora }}</div>
              </div>
            </td>
          </tr>

          <tr>
            <td style="padding:0 36px 18px 36px;">
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
              <div style="display:inline-block;background:#fff;border:1px solid #e6e8e7;border-radius:6px;padding:14px 18px;min-width:300px;">
                <div style="font-size:13px;color:#555;">San Luis Potosí, SLP</div>
                <div style="margin-top:8px;"><a href="https://www.google.com/maps/search/?api=1&query=San+Luis+Potosi" style="color:#16a34a;text-decoration:none;font-weight:700;">Ver cómo llegar</a></div>
              </div>
            </td>
          </tr>

          <tr>
            <td style="padding:0 36px 28px 36px;text-align:center;">
              <a href="#" style="display:inline-block;padding:12px 22px;background:#fff;border:2px solid #16a34a;color:#16a34a;border-radius:8px;text-decoration:none;font-weight:700;margin-right:10px;">Reprogramar</a>
              <a href="#" style="display:inline-block;padding:12px 22px;background:#f3f3f3;color:#b91c1c;border-radius:8px;text-decoration:none;font-weight:700;border:2px solid #f3f3f3;">Entendido</a>
            </td>
          </tr>

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
