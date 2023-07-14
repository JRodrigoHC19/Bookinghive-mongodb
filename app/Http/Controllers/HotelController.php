<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Habitacion;
use App\Models\Visita;
use App\Models\Resena;
use App\Models\Foto;
use App\Models\Reservacion;



class HotelController extends Controller
{
    
    public function index($ruc_hotel ,$id_user, Request $request)
    {
        if ($ruc_hotel == 0){
            $titulo = $request->query('letrero');
            $ruc_hotel = Hotel::where('titulo', $titulo)->first()->_id;
        }

        $hoteles_full = Hotel::get();
        // OBTIENE LOS DATOS DEL HOTEL 
        $hotel = Hotel::where('_id', $ruc_hotel)->first();


        // VERIFICA SI EL USUARIO INGRESO AL HOTEL Y SI EL USUARIO NO ES DE TIPO [CUENTA HOTEL]
        if (Visita::where('user_id', $id_user)->where('ruc', $ruc_hotel)->doesntExist() && User::find($id_user)->rol != 'M')
        {
            $visita = new Visita();
            $visita->user_id = $id_user;
            $visita->ruc = $ruc_hotel;
            
            $visita->A = substr(Hotel::getTipoRuc($ruc_hotel), 0, 1);
            $visita->F = substr(Hotel::getTipoRuc($ruc_hotel), 1, 1);
            $visita->C = substr(Hotel::getTipoRuc($ruc_hotel), 2, 1);
            $visita->D = substr(Hotel::getTipoRuc($ruc_hotel), 3, 1);
            $visita->P = substr(Hotel::getTipoRuc($ruc_hotel), 4, 1);
            $visita->B = substr(Hotel::getTipoRuc($ruc_hotel), 5, 1);
            $visita->N = substr(Hotel::getTipoRuc($ruc_hotel), 6, 1);
            $visita->R = substr(Hotel::getTipoRuc($ruc_hotel), 7, 1);
            $visita->T = substr(Hotel::getTipoRuc($ruc_hotel), 8, 1);
            $visita->save();
        }



        // SE OBTIENE LAS HABITACIONES DEL HOTEL
        $habs_del_hotel = Habitacion::where('id_hotel', $ruc_hotel)->get();
        
        $tipos = ['Individual', 'Doble', 'Familiar', 'Matrimonial', 'King'];
        $hab_indi = []; $hab_dobl = []; $hab_fami = []; $hab_matr = []; $hab_king = [];

        // SE ALMACENAN LAS HABITACIONES SEGÚN SU TIPO
        foreach ($habs_del_hotel as $hab_tipo) {
            switch ($hab_tipo->tipo) {
                case 'I':
                    array_push($hab_indi, $hab_tipo);
                    break;
                case 'D':
                    array_push($hab_dobl, $hab_tipo);
                    break;
                case 'F':
                    array_push($hab_fami, $hab_tipo);
                    break;
                case 'M':
                    array_push($hab_matr, $hab_tipo);
                    break;
                case 'K':
                    array_push($hab_king, $hab_tipo);
                    break;
            }
        }


        // SE OBTIENEN LAS RESEÑAS DEL HOTEL
        $resenas = Resena::where('ruc_hotel', $hotel->_id )->get();
        
        // SE OBTIENE LAS FOTOS DEL HOTEL
        $fotos = Foto::where('email', $hotel->email)->get();


        return view('hotel.recepcion', compact('hab_indi', 'hab_dobl', 'hab_fami', 'hab_matr', 'hab_king','hotel','resenas','fotos','hoteles_full'));
        
    }

    public function registrar(Request $request){
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->rol = 'M';
        $user->save();
        
        $hotel = new Hotel();
        $hotel->_id = $request->input('id');
        $hotel->email = $request->input('email');
        $hotel->tipo = $request->input('A') . $request->input('F') . $request->input('C') . $request->input('D') . $request->input('P') . $request->input('B') . $request->input('N') . $request->input('R') . $request->input('T');
        $hotel->titulo = $request->input('name');
        $hotel->telefono1 = $request->input('telefono1');
        $hotel->pais = $request->input('pais');
        $hotel->ciudad = $request->input('ciudad');
        $hotel->direccion = $request->input('direccion');
        if ($request->input('telefono2') == null) {
            $hotel->telefono2 = 0;
        } else {
            $hotel->telefono2 = $request->input('telefono2');
        }
        $hotel->save();   

        return redirect()->route("cuentas");
    }

    public function editTitulo(string $correo, Request $request){
        $registro = Hotel::where('email', $correo)->first();
        $registro->titulo = $request->input('titulo');
        $registro->save();

        $usuario = User::where('email', $correo)->first();
        $usuario->name = $request->input('titulo');
        $usuario->save();
        return redirect()->back();
    }

    public function editLocation(string $correo, Request $request){
        $registro = Hotel::where('email', $correo)->first();
        $registro->pais = $request->input('pais');
        $registro->ciudad = $request->input('ciudad');
        $registro->direccion = $request->input('direccion');
        $registro->save();

        return redirect()->back();
    }

    public function editTelefono(string $correo, Request $request)
    {
        $registro = Hotel::where('email', $correo)->first();
        
        if ($request->tipo == 1){
            $registro->telefono1 = $request->input('telefono');
            $registro->save();
        } else {
            $registro->telefono2 = $request->input('telefono');
            $registro->save();
        }
        
        return redirect()->back();
    }

}
