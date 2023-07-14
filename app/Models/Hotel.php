<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Model;

class Hotel extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'hotels';

    protected $fillable = [
        'titulo',
        '_id',
        'pais',
        'ciudad',
        'direccion',
        'email',
        // otros atributos permitidos
    ];

    public static function getEmail($ruc){
        $hotel = Hotel::where('id', $ruc)->first();
        
        if (isset($hotel)){
            return $hotel->email;
        } else {
            return null;
        }    
    }
    
    public static function getRuc($email){
        // $correo = $email;
        $hotel = Hotel::where('email', $email)->first();
        
        if (isset($hotel)){
            return $hotel->_id;
        } else {
            return 0;
        }    
    }

    public static function getPais($pais){
        $hotel = Hotel::where('email', $pais)->first();
        
        if (isset($hotel)){
            return $hotel->pais;
        } else {
            return null;
        }
    }

    public static function getCiudad($ciudad){
        $hotel = Hotel::where('email', $ciudad)->first();
        
        if (isset($hotel)){
            return $hotel->ciudad;
        } else {
            return null;
        }
    }

    public static function getDireccion($direcion){
        $hotel = Hotel::where('email', $direcion)->first();
        
        if (isset($hotel)){
            return $hotel->direccion;
        } else {
            return null;
        }
    }

    public static function getNombre($correo){
        $hotel = Hotel::where('email', $correo)->first();
        
        if (isset($hotel)){
            return $hotel->titulo;
        } else {
            return null;
        }
    }

    public static function getFull($name){
        $hotel = Hotel::where('titulo', $name)->get();

        if (isset($hotel)){
            return $hotel;
        } else {
            return null;
        }
    }

    public static function getFullCorreo($correo){
        $hotel = Hotel::where('email', $correo)->first();

        if (isset($hotel)){
            return $hotel;
        } else {
            return null;
        }
    }

    public static function getTipo($correo){
        $hotel = Hotel::where('email', $correo)->first();

        if (isset($hotel)){
            return $hotel->tipo;
        } else {
            return null;
        }
    }

    public static function getTipoRuc($ruc){
        $hotel = Hotel::where('id', $ruc)->first();

        if (isset($hotel)){
            return $hotel->tipo;
        } else {
            return null;
        }
    }

    public static function getTelef1($correo){
        $hotel = Hotel::where('email', $correo)->first();

        if (isset($hotel)){
            return $hotel->telefono1;
        } else {
            return null;
        }
    }

    public static function getTelef2($correo){
        $hotel = Hotel::where('email', $correo)->first();

        if (isset($hotel)){
            return $hotel->telefono2;
        } else {
            return null;
        }
    }
}
