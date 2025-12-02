<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WeatherController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
    
    Route::get('platillos', [adminController::class, 'platillos'])->name('platillos.index');
    Route::post('platillos/save', [adminController::class, 'platilloSave'])->name('platillos.save');
    Route::get('platillos/export', [adminController::class, 'platillosExport'])->name('platillos.export');
    Route::post('platillos/importar', [adminController::class, 'platillosImportar'])->name('platillos.importar');
    Route::delete('platillos/delete/{id}', [adminController::class, 'platilloDelete'])->name('platillos.delete');
    Route::get('platillos/show/{id}', [adminController::class, 'platilloShow'])->name('platillos.show');
    Route::post('platillos/update/{id}', [adminController::class, 'platilloUPdate'])->name('platillos.update');
    Route::get('mesas', [adminController::class, 'mesas'])->name('mesas.index');
    Route::post('mesas/save', [adminController::class, 'mesaSave'])->name('mesas.save');
    Route::delete('mesas/delete/{id}', [adminController::class, 'mesaDelete'])->name('mesas.delete');
    Route::get('mesas/show/{id}', [adminController::class, 'mesaShow'])->name('mesas.show');
    Route::post('mesas/update/{id}', [adminController::class, 'mesaUpdate'])->name('mesas.update');
    Route::get('reservaciones', [adminController::class, 'reservaciones'])->name('reservaciones.index');
    Route::post('reservaciones/save', [adminController::class, 'reservacionSave'])->name('reservaciones.save');
    Route::delete('reservaciones/delete/{id}', [adminController::class, 'reservacionDelete'])->name('reservaciones.delete');
    Route::get('reservaciones/show/{id}', [adminController::class, 'reservacionShow'])->name('reservaciones.show');
    Route::post('reservaciones/update/{id}', [adminController::class, 'reservacionUpdate'])->name('reservaciones.update');
    Route::get('reservacionesCliente/{id}', [adminController::class, 'reservacionesCliente'])->name('reservacionesCliente.index');
    Route::get('reservacionesCliente/show/{id}', [adminController::class, 'reservacionClienteShow'])->name('reservacionesCliente.show');
    Route::post('reservacionesCliente/save/{id}', [adminController::class, 'reservacionClienteSave'])->name('reservacionesCliente.save');
    Route::post('reservacionesCliente/update/{id_user}/{id}', [adminController::class, 'reservacionClienteUpdate'])->name('reservacionesCliente.update');
    Route::get('users', [adminController::class, 'users'])->name('users.index');
    Route::post('users/save', [adminController::class, 'userSave'])->name('users.save');
    Route::delete('users/delete/{id}', [adminController::class, 'userDelete'])->name('users.delete');
    Route::get('users/show/{id}', [adminController::class, 'userShow'])->name('users.show');
    Route::post('users/update/{id}', [adminController::class, 'userUpdate'])->name('users.update');
});

Route::get('weather/{city?}', [WeatherController::class, 'current'])->name('weather.current');
