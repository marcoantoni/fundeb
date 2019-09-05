<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Despesas;
use App\Estados;
use App\Municipios;

class MunicipioController extends Controller {

    /**
    * Retorna todas as cidades de um estado do Brasil
    *
    * @param integer $id id_estado - primary key da tabela estados
    * @return json
    */ 
    public function show($id) {
    	return Municipios::where("id_estado", $id)->get();
    }

}