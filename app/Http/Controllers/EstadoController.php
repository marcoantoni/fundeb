<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Estados;

class EstadoController extends Controller {
	public function index(){
		return Estados::get();
	}


    public function getMunicipios($id) {
    	return Municipios::where('id_estado', $id)->get();
    }
}
