<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Reservacion;
use App\Models\User;

$res = Reservacion::orderBy('id','desc')->take(10)->get();
if ($res->isEmpty()) {
    echo "No hay reservaciones\n";
    exit(0);
}
foreach ($res as $r) {
    $u = User::find($r->user_id);
    echo "id={$r->id} mesa={$r->mesa_id} user_id={$r->user_id} user_email=" . ($u? $u->email : 'n/a') . " fecha={$r->fecha_hora} personas={$r->numero_personas}\n";
}
