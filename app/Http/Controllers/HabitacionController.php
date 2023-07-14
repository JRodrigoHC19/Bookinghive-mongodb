<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Habitacion;



class HabitacionController extends Controller
{
    
    public function store(Request $request)
    {
        $Habitacion = new Habitacion();
        $Habitacion->id_hab     = $request->input('id_hab');
        $Habitacion->id_hotel   = $request->input('hotel');
        $Habitacion->piso       = $request->input('piso');
        $Habitacion->precio     = $request->input('precio');
        $Habitacion->capacidad  = $request->input('capac');
        $Habitacion->tipo       = $request->input('tipo');
        $Habitacion->estado     = 'D';  
        $Habitacion->save();

        return redirect()->back();    
    }

}
