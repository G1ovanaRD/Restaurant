<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Platillo;
class adminController extends Controller
{
    public function platillos() {
        $platillos =  Platillo::all();
        return view('platillos', compact('platillos'));
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

    public function platilloDelete($id) {
        $platillo = Platillo::find($id);
        $platillo->delete();
        return redirect()->back();
    }

    public function platilloShow($id) {
        $platillo = Platillo::find($id);
        return view('platillos-modifica', compact('platillo'));
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
}
