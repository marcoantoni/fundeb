<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Despesas;
use App\Estados;
use App\Municipios;

class MunicipioController extends Controller {
	public function index(){
        $estados = Estados::orderBy("nome", "ASC")->get();
		return view("municipio/index")->with(["estados" => $estados]);
	}

    public function getMunicipios($id) {
    	return Municipios::where("id_estado", $id)->get();
    }

    // $id e o cod_municipio_ibge
    public function getRelatorio($id){
    	return Despesas::where("co_municipio_ibge", $id)->where("NU_PERIODO", 6)->get();
    }
}