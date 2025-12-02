<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    /* Tipos y paleta */
    body{font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;color:#000;margin:0;padding:0;background:#fff}
    .page{padding:18px 28px}
    .container{max-width:820px;margin:0 auto;background:#fff}

    /* Layout: franja lateral y contenido */
    .layout{display:block;overflow:hidden}
    .rail{float:left;width:84px;background:#111;height:100%;display:flex;align-items:center;justify-content:center}
    .rail .photo{width:64px;height:64px}

    .content{margin-left:92px;padding:18px 12px}

    /* Header */
    .top{display:flex;justify-content:space-between;align-items:flex-start}
    .brand{font-size:12px;color:#16a34a;letter-spacing:2px}
    .brand small{display:block;color:#9b6b65;font-size:10px}
    .title{font-size:64px;letter-spacing:2px;font-weight:700;margin:0;color:#000}

    /* Columns for menu items (cards) */
    .menu-columns{column-count:2;column-gap:20px;margin-top:16px}
    .dish{display:block;break-inside:avoid;margin:0 0 12px;padding:10px;background:#ffffff;border:1px solid #efefef;border-radius:8px;box-shadow:0 0 0 rgba(0,0,0,0);}
    .dish .card-img{width:100%;height:100px;object-fit:cover;border-radius:6px;margin-bottom:8px;border:1px solid #eee}
    .dish .card-body{padding:0}
    /* Nombre en verde Foody y más prominente */
    .dish .name{font-weight:800;font-size:16px;color:#16a34a;margin:0}
    /* Descripción y precio en negro para contraste */
    .dish .desc{font-size:12px;color:#111;margin-top:6px}
    .dish .price{font-weight:700;color:#111;font-size:14px;margin-left:8px}
    /* Row entre nombre y precio */
    .dish .row{display:flex;justify-content:space-between;align-items:flex-start;gap:10px}

    .footer{margin-top:26px;font-size:11px;color:#888;text-align:center}

    /* Small screens fallback */
    @media print { .menu-columns{column-count:2} }
  </style>
</head>
<body>
  <div class="page">
    <div class="container">
      <div class="layout">
        <div class="rail">
          <!-- Barra lateral / puedes poner una imagen aquí si la incluyes con URL absoluta -->
          <div class="photo" style="background-image:url('');"></div>
        </div>

        <div class="content">
          <div class="top">
            <div style="display:flex;align-items:center;gap:10px">
              <div class="brand" style="display:flex;align-items:center;gap:8px">
                <div style="width:36px;height:36px;display:flex;align-items:center;justify-content:center">
                  <!-- Logo Foody (SVG) -->
                  <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3V2"/><path d="m15.4 17.4 3.2-2.8a2 2 0 1 1 2.8 2.9l-3.6 3.3c-.7.8-1.7 1.2-2.8 1.2h-4c-1.1 0-2.1-.4-2.8-1.2l-1.302-1.464A1 1 0 0 0 6.151 19H5"/><path d="M2 14h12a2 2 0 0 1 0 4h-2"/><path d="M4 10h16"/><path d="M5 10a7 7 0 0 1 14 0"/><path d="M5 14v6a1 1 0 0 1-1 1H2"/></svg>
                </div>
                <div style="font-weight:700;font-size:14px;color:#000">Foody</div>
              </div>
              <div><small style="color:#777">San Luis Potosí, SLP · Tel: (444) 123-4567</small></div>
            </div>
            <div style="text-align:right">
              <div class="title">MENÚ</div>
            </div>
          </div>

          @php
            // Banner superior: usa public/images/banner.jpg si existe
            $banner = null;
            if (file_exists(public_path('images/banner.jpg'))) {
                $banner = asset('images/banner.jpg');
                if (!preg_match('/^https?:\/\//i', $banner)) {
                    $banner = rtrim(config('app.url', ''), '/') . '/' . ltrim($banner, '/');
                }
            }
          @endphp

          @if($banner)
            <div style="margin:12px 0;text-align:center;">
              <img src="{{ $banner }}" alt="Banner" style="width:100%;height:120px;object-fit:cover;border-radius:8px;display:block;" />
            </div>
          @endif

          <div class="menu-columns">
            @foreach($platillos as $p)
              <div class="dish">
                <div class="card-body">
                  <div class="row">
                    <div class="name">{{ $p->nombre }}</div>
                    <div class="price">${{ number_format($p->precio,2) }}</div>
                  </div>
                  @if(!empty($p->descripcion))
                    <div class="desc">{{ $p->descripcion }}</div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>

          <div class="footer">Gracias por preferirnos — Foody</div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
