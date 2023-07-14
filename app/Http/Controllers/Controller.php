<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function editName(string $correo, Request $request){
        $registro = User::where('email', $correo)->first();
        $registro->name = $request->input('name');
        $registro->save();
        return redirect()->back();
    }

    public function editPassword(string $correo, Request $request){
        $registro = User::where('email', $correo)->first();
        $registro->password = Hash::make($request->input('password'));
        $registro->save();
        return redirect()->back();
    }

}
