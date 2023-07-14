<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Hotel;
use App\Models\Reservacion;
use Illuminate\Support\Str;



class ReservacionController extends Controller
{
    
    public function store(Request $request)
    {
        $hoteles_full = Hotel::get();
        $codigo = strtoupper(Str::random(8));
        $reserva = new Reservacion();

        $reserva->id_hotel  = $request->input('ruc');
        $reserva->id_hab    = $request->input('hab');
        $reserva->email_cli = $request->input('cliente');
        $reserva->inicio    = date("Y/m/d", strtotime($request->input('inicio')));     
        $reserva->final     = date("Y/m/d", strtotime($request->input('final')));
        $reserva->estado    = 'P';
        $reserva->codigo    = $codigo;

        $reserva->save();

        return view('hotel.ventas.codigo',compact('codigo','hoteles_full'));
    }

}
