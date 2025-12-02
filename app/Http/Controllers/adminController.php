<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Platillo;
use App\Models\Mesa;
use App\Models\Reservacion;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlatillosExport;
use App\Imports\PlatillosImport;
class adminController extends Controller
{

    private $categorias = [
        "Comida rápida" => "Comida rápida",
        "Comida italiana" => "Comida italiana",
        "Comida mexicana" => "Comida mexicana",
        "Comida japonesa" => "Comida japonesa",
        "Comida china" => "Comida china",
        "Comida francesa" => "Comida francesa",
        "Comida mediterránea" => "Comida mediterránea",
        "Comida española" => "Comida española",
        "Comida americana" => "Comida americana",
        "Comida india" => "Comida india",
        "Comida tailandesa" => "Comida tailandesa",
        "Comida árabe" => "Comida árabe",
        "Comida griega" => "Comida griega",
        "Comida vegetariana" => "Comida vegetariana",
        "Comida vegana" => "Comida vegana",
        "Comida saludable" => "Comida saludable",
        "Comida gourmet" => "Comida gourmet",
        "Comida casera" => "Comida casera",
        "Comida coreana" => "Comida coreana",
        "Comida peruana" => "Comida peruana",
        "Comida colombiana" => "Comida colombiana",
        "Comida argentina" => "Comida argentina",
        "Mariscos" => "Mariscos",
        "Parrilladas / BBQ" => "Parrilladas / BBQ",
        "Postres" => "Postres",
        "Panadería / Repostería" => "Panadería / Repostería",
        "Cafetería / Coffee shop" => "Cafetería / Coffee shop",
        "Sushi" => "Sushi",
        "Pizzería" => "Pizzería",
        "Hamburguesas" => "Hamburguesas",
        "Tacos" => "Tacos",
        "Antojitos mexicanos" => "Antojitos mexicanos",
    ];

    public function platillos() {
        $platillos =  Platillo::all();
        $categorias = $this->categorias;
        return view('platillos', compact('platillos', 'categorias'));
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

    public function reservacionesCliente($id) {
        $reservaciones = Reservacion::where('user_id', $id)->get();
        $mesas = Mesa::all();
        return view('reservaciones-cliente', compact('reservaciones', 'mesas'));
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

    
    public function platillosExport()
    {
        $fileName = 'platillos_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new PlatillosExport(), $fileName);
    }

    public function platillosImportar(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ], [
            'file.required' => 'Seleccione un archivo Excel para importar.',
            'file.mimes' => 'El archivo debe ser .xlsx, .xls o .csv.',
            'file.max' => 'El archivo es demasiado grande (máx 10MB).',
        ]);

        $import = new PlatillosImport();

        try {
            $import->import($request->file('file'));
        } catch (\Exception $e) {
            \Log::error('Error importando platillos', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error al importar el archivo: ' . $e->getMessage());
        }

        $creados = $import->creados ?? 0;
        $actualizados = $import->actualizados ?? 0;
        $fallos = $import->failures() ?? [];
        $nFallos = count($fallos);

        if ($nFallos) {
            foreach ($fallos as $f) {
                \Log::warning('Fila fallida al importar platillos', [
                    'row' => $f->row(),
                    'attribute' => $f->attribute(),
                    'errors' => $f->errors(),
                    'values' => $f->values(),
                ]);
            }
        }

        $msg = "Importación completada: creados={$creados}, actualizados={$actualizados}";
        if ($nFallos) $msg .= ", fallos={$nFallos} (revisar logs)";

        return redirect()->back()->with('status', $msg);
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
        $validated = $request->validate([
            'mesa_id' => 'required|exists:mesas,id',
            'user_id' => 'required|exists:users,id',
            'fecha_hora' => 'required|date',
            'numero_personas' => 'required|integer|min:1',
        ]);

        // se verifica que la mesa no esté ocupada
        $mesa = Mesa::find($validated['mesa_id']);
        if ($mesa && ($mesa->estado === 'ocupado' || strtolower($mesa->estado) === 'ocupado')) {
            return redirect()->back()->with('error', 'La mesa seleccionada ya está ocupada. Elige otra mesa.');
        }

        $reservacion = new Reservacion();
        $reservacion->mesa_id = $validated['mesa_id'];
        $reservacion->user_id = $validated['user_id'];
        $reservacion->fecha_hora = $validated['fecha_hora'];
        $reservacion->numero_personas = $validated['numero_personas'];
        $reservacion->save();

        // cambiar la mesa a ocupada
        $mesa = Mesa::find($validated['mesa_id']);
        if ($mesa) {
            $mesa->estado = 'ocupado';
            $mesa->save();
        }

        return redirect()->back()->with('status', 'Reservación creada correctamente');
    }

    public function reservacionClienteSave(REQUEST $request, $id) {
        $reservacion = new Reservacion();
        $reservacion->mesa_id = $request->mesa_id;
        $reservacion->user_id = $id;
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
        if ($reservacion) {
            // Liberar la mesa asociada
            $mesa = Mesa::find($reservacion->mesa_id);
            if ($mesa) {
                $mesa->estado = 'disponible';
                $mesa->save();
            }

            $reservacion->delete();
        }

        return redirect()->back();
    }

    public function platilloShow($id) {
        $platillo = Platillo::find($id);
        $categorias = $this->categorias;
        return view('platillos-modifica', compact('platillo', 'categorias'));
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

    public function reservacionClienteShow($id) {
        $reservacion = Reservacion::find($id);
        $mesas = Mesa::all();
        return view('reservacionesCliente-modifica', compact('reservacion', 'mesas'));
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

        if (!$reservacion) return redirect()->route('reservaciones.index');

        $oldMesaId = $reservacion->mesa_id;
        $newMesaId = $request->mesa_id;

        // verificar si la nueva mesa está ocupada
        if ($newMesaId && $oldMesaId != $newMesaId) {
            $newMesa = Mesa::find($newMesaId);
            if ($newMesa && ($newMesa->estado === 'ocupado' || strtolower($newMesa->estado) === 'ocupado')) {
                return redirect()->back()->with('error', 'La mesa seleccionada ya está ocupada. Elige otra mesa.');
            }
        }

        $reservacion->mesa_id = $newMesaId;
        $reservacion->user_id = $request->user_id;
        $reservacion->fecha_hora = $request->fecha_hora;
        $reservacion->numero_personas = $request->numero_personas;
        $reservacion->save();

        // actualizar estados de las mesas si se cambió la mesa
        if ($oldMesaId && $oldMesaId != $newMesaId) {
            $oldMesa = Mesa::find($oldMesaId);
            if ($oldMesa) {
                $oldMesa->estado = 'disponible';
                $oldMesa->save();
            }
        }

        if ($newMesaId) {
            $newMesa = Mesa::find($newMesaId);
            if ($newMesa) {
                $newMesa->estado = 'ocupado';
                $newMesa->save();
            }
        }

        return redirect()->route('reservaciones.index');
    }

    public function reservacionClienteUpdate(REQUEST $request, $id_user, $id) {
        $reservacion = Reservacion::find($id);
        $reservacion->mesa_id = $request->mesa_id;
        $reservacion->user_id = $id_user;
        $reservacion->fecha_hora = $request->fecha_hora;
        $reservacion->numero_personas = $request->numero_personas;
        $reservacion->save();
        return redirect()->route('reservacionesCliente.index', $id_user);
    }
}
