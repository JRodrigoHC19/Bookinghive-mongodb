<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Persona;



class PersonaController extends Controller
{
    
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->rol = 'R';
        $user->save();
        
        $person = new Persona();
        $person->email = $request->input('email');
        $person->nombre = $request->input('nombres');
        $person->apellido = $request->input('apellidos');
        $person->sexo = $request->input('sexo');
        $person->pais = $request->input('pais');
        $person->celular = $request->input('celular');
        $person->fecha_nac = $request->input('fecha');
        $person->save();   

        return redirect()->route("home");
    }


    public function editCelular(string $correo, Request $request)
    {
        $registro = Persona::where('email', $correo)->first();
        $registro->celular = $request->input('celular');
        $registro->save();
        return redirect()->back();
    }

    public function editDatosPersonales(string $correo, Request $request)
    {
        $person = Persona::where('email', $correo)->first();
        $person->nombre = $request->input('nombres');
        $person->apellido = $request->input('apellidos');
        $person->sexo = $request->input('sexo');
        $person->pais = $request->input('pais');
        $person->fecha_nac = $request->input('fecha');
        $person->save();   

        return redirect()->back();
    }

}
