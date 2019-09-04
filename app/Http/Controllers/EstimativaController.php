<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ano;
use App\Estimativa;
use App\Estados;

class EstimativaController extends Controller {
	public function index(){
		$estados = Estados::orderBy("nome", "ASC")->get();
		$anos = Ano::orderBy("ano", "ASC")->get();
		return view("estimativa/index")->with(["estados" => $estados, "anos" => $anos]);
	}

    // $id e o id_estado
    public function show($id_estado, $ano){
     	return $estimativas = Estimativa::getEstimativas($id_estado, $ano); 
    }
}