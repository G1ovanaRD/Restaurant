<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family: Arial, Helvetica, sans-serif;color:#000;margin:0;padding:12px;background:#fff}
    /* alinear el ticket al margen izquierdo y texto a la izquierda */
    .ticket{width:100%;max-width:340px;padding:8px;margin-right:auto;text-align:left}
    .brand{font-size:18px;font-weight:800;color:#16a34a;text-align:left;margin-bottom:6px}
    .sub{font-size:12px;color:#555;text-align:left;margin-bottom:10px}
    .box{border-top:1px dashed #ddd;padding-top:10px;margin-top:6px}
    .row{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px}
    .row > div{min-width:40%;}
    .label{color:#666;font-size:12px;text-align:left}
    .value{font-weight:700;font-size:13px;text-align:left}
    .footer{margin-top:12px;text-align:left;font-size:11px;color:#777}
  </style>
</head>
<body>
  <div class="ticket">
    <div class="brand">Foody</div>
    <div class="sub">San Luis Potosí · Tel: (444) 123-4567</div>

    <div class="box">
      <div class="row">
        <div>
          <div class="label">Cliente</div>
          <div class="value">{{ $cliente?->name ?? 'Cliente' }}</div>
        </div>
        <div style="text-align:right;">
          <div class="label">Personas</div>
          <div class="value">{{ $reservacion->numero_personas }}</div>
        </div>
      </div>

      <div class="row">
        <div>
          <div class="label">Mesa</div>
          <div class="value">{{ $mesa?->id ?? $reservacion->mesa_id }}</div>
        </div>
        <div style="text-align:right;">
          <div class="label">Fecha</div>
          <div class="value">{{ \Carbon\Carbon::parse($reservacion->fecha_hora)->translatedFormat('d M Y') }}</div>
        </div>
      </div>

      <div style="margin-top:6px;">
        <div class="label">Hora</div>
        <div class="value">{{ \Carbon\Carbon::parse($reservacion->fecha_hora)->translatedFormat('H:i') }}</div>
      </div>

    </div>

    <div class="footer">Gracias por preferirnos — Foody</div>
  </div>
</body>
</html>
