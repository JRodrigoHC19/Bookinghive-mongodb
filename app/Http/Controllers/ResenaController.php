<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\Resena;




class ResenaController extends Controller
{
    
    public function store(Request $request)
    {
        $resena = new Resena();

        $resena->ruc_hotel      = $request->input('ruc_hotel');
        $resena->email          = $request->input('user_email');
        $resena->cal_rep        = $request->input('cal_rep');
        $resena->cal_ins        = $request->input('cal_ins');
        $resena->cal_hab        = $request->input('cal_hab');
        $resena->limp           = $request->input('cal_limp');
        $resena->cal_pre        = $request->input('cal_pre');
        $resena->rcm_hot        = $request->input('cal_rcm');
        $resena->msg            = $request->input('msg');

        $resena->save();

        return redirect()->back();
    }

}
