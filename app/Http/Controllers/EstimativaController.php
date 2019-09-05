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

    /**
    * Retorna o valor estimado por aluno de um estado
    *
    * @param integer $id_estado - primary key da tabela estados
    * @param integer $ano - ano no qual busca-se as informações
    * @return json
    */
    public function show($id_estado, $ano){
     	return $estimativas = Estimativa::getEstimativas($id_estado, $ano); 
    }
}