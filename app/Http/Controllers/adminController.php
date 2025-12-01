<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Platillo;
use App\Models\Mesa;
use App\Models\Reservacion;
use App\Models\User;
class adminController extends Controller
{
    public function platillos() {
        $platillos =  Platillo::all();
        return view('platillos', compact('platillos'));
    }

    public function mesas() {
        $mesas =  Mesa::all();
        return view('mesas', compact('mesas'));
    }

    public function reservaciones() {
        $reservaciones =  Reservacion::all();
        $users = User::all();
        $mesas = Mesa::all();
        return view('reservaciones', compact('reservaciones', 'users', 'mesas'));
    }

    public function platilloSave(REQUEST $request) {
        $platillo = new Platillo();
        $platillo->nombre = $request->nombre;
        $platillo->descripcion = $request->descripcion;
        $platillo->precio = $request->precio;
        $platillo->categoria = $request->categoria;
        $platillo->imagen = $request->imagen;
        $platillo->save();
        return redirect()->back();
    }

    public function mesaSave(REQUEST $request) {
        $mesa = new Mesa();
        $mesa->capacidad = $request->capacidad;
        $mesa->ubicacion = $request->ubicacion;
        $mesa->estado = $request->estado;
        $mesa->save();
        return redirect()->back();
    }

    public function reservacionSave(REQUEST $request) {
        $reservacion = new Reservacion();
        $reservacion->mesa_id = $request->mesa_id;
        $reservacion->user_id = $request->user_id;
        $reservacion->fecha_hora = $request->fecha_hora;
        $reservacion->numero_personas = $request->numero_personas;
        $reservacion->save();
        return redirect()->back();
    }

    public function platilloDelete($id) {
        $platillo = Platillo::find($id);
        $platillo->delete();
        return redirect()->back();
    }

    public function mesaDelete($id) {
        $mesa = Mesa::find($id);
        $mesa->delete();
        return redirect()->back();
    }

    public function reservacionDelete($id) {
        $reservacion = Reservacion::find($id);
        $reservacion->delete();
        return redirect()->back();
    }

    public function platilloShow($id) {
        $platillo = Platillo::find($id);
        return view('platillos-modifica', compact('platillo'));
    }

    public function mesaShow($id) {
        $mesa = Mesa::find($id);
        return view('mesas-modifica', compact('mesa'));
    }

    public function reservacionShow($id) {
        $reservacion = Reservacion::find($id);
        $users = User::all();
        $mesas = Mesa::all();
        return view('reservaciones-modifica', compact('reservacion', 'users', 'mesas'));
    }

    public function platilloUpdate(REQUEST $request, $id) {
        $platillo = Platillo::find($id);
        $platillo->nombre = $request->nombre;
        $platillo->descripcion = $request->descripcion;
        $platillo->precio = $request->precio;
        $platillo->categoria = $request->categoria;
        $platillo->imagen = $request->imagen;
        $platillo->save();
        return redirect()->route('platillos.index');
    }

    public function mesaUpdate(REQUEST $request, $id) {
        $mesa = Mesa::find($id);
        $mesa->capacidad = $request->capacidad;
        $mesa->ubicacion = $request->ubicacion;
        $mesa->estado = $request->estado;
        $mesa->save();
        return redirect()->route('mesas.index');
    }

    public function reservacionUpdate(REQUEST $request, $id) {
        $reservacion = Reservacion::find($id);
        $reservacion->mesa_id = $request->mesa_id;
        $reservacion->user_id = $request->user_id;
        $reservacion->fecha_hora = $request->fecha_hora;
        $reservacion->numero_personas = $request->numero_personas;
        $reservacion->save();
        return redirect()->route('reservaciones.index');
    }
}
