<?php

namespace App\Http\Controllers;

use App\Comuna;
use App\Region;
use Illuminate\Http\Request;

class ComunaController extends Controller
{
    //
    public function index(){
        return ['comunas' => Comuna::orderBy('nombre', 'asc')->get()];
    }

    public function index_regiones(){
        return ['regiones' => Region::get()];
    }

}
