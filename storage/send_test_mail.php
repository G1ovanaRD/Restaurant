<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// bootstrap the framework
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Reservacion;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

$id = $argv[1] ?? 6;
$res = Reservacion::find($id);
if (!$res) {
    echo "Reservacion $id no encontrada\n";
    exit(1);
}
$cliente = User::find($res->user_id);
if (!$cliente) {
    echo "Cliente no encontrado para la reservacion\n";
    exit(1);
}

try {
    Mail::to($cliente->email)->send(new App\Mail\Reservacion($res, $cliente));
    echo "Intento de envío realizado, revisa logs para detalles.\n";
} catch (Exception $e) {
    echo "Excepción al enviar: " . $e->getMessage() . "\n";
}

return 0;
