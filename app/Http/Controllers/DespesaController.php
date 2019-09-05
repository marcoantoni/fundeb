<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Despesas;
use App\Estados;
use App\Municipios;

class DespesaController extends Controller {
	public function index(){
        $estados = Estados::orderBy("nome", "ASC")->get();
		return view("despesa/index")->with(["estados" => $estados]);
	}

    /**
    * Retorna os gastos de um municipio do brasil
    *
    * @param integer $id - codigo do municipio segundo o IBGE
    * @return json
    */ 
    public function getRelatorio($id){
        /* NU_PERIODO - Período do ano base a que se refere a declaração (1,2,3,4,5,6). De 2008 a 2016, o período 1 refere-se à declaração anual. A partir de 2017, os dados passaram a ser bimestrais, sendo o período 6 a consolidação anual
        */
    	return Despesas::where("co_municipio_ibge", $id)->where("NU_PERIODO", 6)->get();
    }
}