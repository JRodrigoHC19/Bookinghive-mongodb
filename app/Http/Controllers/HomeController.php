<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

use App\Models\Persona;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Visita;
use App\Models\Resena;
use App\Models\Habitacion;
use App\Models\Reservacion;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    
     public function index()
     {   
         $hoteles_full = Hotel::get();
 
        //  // SE OBTIENEN LOS REGISTROS DEL USUARIO TRAS INGRESAR POR DIFERENTES HOTELES - REGISTROS ÚNICOS
        //      $data =  Visita::where('user_id',$id )->get();
 
 
        //  // LINK PARA CONECTARME CON EL API FLASK
        //      $url = 'http://192.168.1.7:8000/ruta_flask/';
 
 
        //  // ENVIO UNA SOLICITUD A FLASK - PARA OBTENER LOS 2 TIPOS DE HOTES MÁS VITADOS POR EL USUARIO
        //      $solicitud_1 = Http::get($url,['data' => json_encode($data), 'pasos' => 1]);
         
 
        //  // LA RESPUESTA SE CONVIERTE A UN --ARRAY SIMPLE--> [tipo1 , tipo2]
        //      $respuesta_1 = $solicitud_1->collect();
 
 
        //  // REALIZO UNA CONSULTA A LA BASE DE DATOS - OBTENIENDO TODOS LOS HOTES QUE SEA DEL TIPO --[EL ARRAY ES SU ARGUMENTO]--
        //      $hoteles_recomendados_desorden = Hotel::whereRaw("SUBSTRING(tipo, $respuesta_1[0], 1) = '1' AND SUBSTRING(tipo, $respuesta_1[1], 1) = '1'")->get();
        //      // return dd($hoteles_recomendados_desorden->all());
         
 
 
 
        //  // SE OBTIENEN LOS REGISTROS DEL USUARIO TRAS INGRESAR POR DIFERENTES HOTELES - REGISTROS ÚNICOS
        //      $valoreaciones_hoteles = Resena::get();
 
 
        //  // EL VALOR DE LA CLAVE RUC_HOTEL PASA A EMAIL DEL HOTEL DE ELEMENTO [... 'ruc_hotel' => 'email_hotel'  ...]
        //      foreach ($valoreaciones_hoteles as $valoracion) {
        //          $valoracion['ruc_hotel'] = Hotel::getEmail($valoracion['ruc_hotel']);
        //      }
 
        //  // ENVIO UNA SOLICITUD A FLASK  - PARA ESTABLECER EL RAITING DE CADA HOTEL RECOMENDADO
        //      $solicitud_2 = Http::get($url,['data' => json_encode($valoreaciones_hoteles), 'pasos' => 2]);
         
         
        //  // LA RESPUESTA SE CONVIERTE A UN --DICCIONARIO--> [EMAIL , RAITING]
        //      $respuesta_2 = $solicitud_2->collect();
        //      // return dd($respuesta_2->all());
 
 
        //  // SE AÑADE LA CLAVE Y VALOR [VALORACION : PUNTAJE]
        //      foreach ($hoteles_recomendados_desorden as $valoracion_unica) {
        //          if (  in_array($valoracion_unica['email'], array_keys( $respuesta_2->all() )  )  ) {
        //              $valoracion_unica['valoracion'] = $respuesta_2[$valoracion_unica['email']];
        //          } else {
        //              $valoracion_unica['valoracion'] = 0.0;
        //          }
                 
        //      }
        //      // return dd($hoteles_recomendados_desorden);
 
 
        //  // ENVIO OTRA SOLUCITUD A FLASK - PARA OBTENER LOS HOTELES RECOMENDADOS PARA EL USARIO - SE APLICA EL ALGORITMO DE RECOMENDACIONES EN FLASK
        //      $solicitud_3 = Http::get($url,['data' => json_encode($hoteles_recomendados_desorden), 'pasos' => 3]);
 
 
        //  // SE ALMACENA LA RESPUESTA EN UN --DICCIONARIO--> [correo : raiting]
        //      $respuesta_3 = $solicitud_3->collect();
        //      // return dd($respuesta_3->all());
        // return view('home',compact('hoteles_full', 'respuesta_3'));
        return view('home',compact('hoteles_full'));
     }
 
     public function cuentas()
     {
         $hoteles_full = Hotel::get();
         $usuarios = User::where('rol','R')->get();
         $hoteles = User::where('rol','M')->get();
         return view('admin.usuarios', compact('hoteles', 'usuarios', 'hoteles_full'));
     }
     
     
     public function perfil($id)
     {
         $hoteles_full = Hotel::get();
         $usuarito =  Persona::getFullCorreo(User::find($id)->email);
         $hotelito =  Hotel::getFullCorreo(User::find($id)->email);
         return view('configuration.perfil',compact('usuarito', 'hotelito','hoteles_full'));
     }
 
     public function graficas()
     {
         $hoteles_full = Hotel::get();
         return view('hotel.graphics.graficas', compact('hoteles_full'));
     }
 
     public function ventas($usuario_id)
     {
         $hoteles_full = Hotel::get();
 
         $habitaciones_hotel = Habitacion::where('id_hotel', Hotel::getRuc(User::find($usuario_id)->email))->get();
 
         $reservaciones_usuario_P = Reservacion::where('email_cli',User::find($usuario_id)->email)->where('estado','P')->get();
         $reservaciones_usuario_V = Reservacion::where('email_cli',User::find($usuario_id)->email)->where('estado','V')->get();
         $reservaciones_usuario_C = Reservacion::where('email_cli',User::find($usuario_id)->email)->where('estado','C')->get();
         $reservaciones_usuario_A = Reservacion::where('email_cli',User::find($usuario_id)->email)->where('estado','A')->get();
 
         $reservaciones_hotel_P = Reservacion::where('id_hotel',Hotel::getRuc(User::find($usuario_id)->email))->where('estado','P')->get();
         $reservaciones_hotel_V = Reservacion::where('id_hotel',Hotel::getRuc(User::find($usuario_id)->email))->where('estado','V')->get();
         $reservaciones_hotel_C = Reservacion::where('id_hotel',Hotel::getRuc(User::find($usuario_id)->email))->where('estado','C')->get();
         $reservaciones_hotel_A = Reservacion::where('id_hotel',Hotel::getRuc(User::find($usuario_id)->email))->where('estado','A')->get();
         return view('hotel.ventas.recibos',compact('hoteles_full', 'habitaciones_hotel', 'reservaciones_usuario_P', 'reservaciones_usuario_V','reservaciones_usuario_C', 'reservaciones_usuario_A', 'reservaciones_hotel_P', 'reservaciones_hotel_V', 'reservaciones_hotel_C', 'reservaciones_hotel_A'));
     }

}
