<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ano;
use App\Matriculas;
use App\Estados;

class MatriculaController extends Controller {
	
    public function index(){
		$estados = Estados::orderBy("nome", "ASC")->get();
        $anos = Ano::orderBy("ano", "DESC")->get();
		return view("matricula/index")->with(["estados" => $estados, "anos" => $anos]);
	}

    /**
    * Retorna todas as matriculas de um municipio do Brasil
    *
    * @param integer $id - primary key da tabela municipios
    * @return json
    */ 
    public function getMatriculas($id){
     	return $matriculas = Matriculas::getMatriculas($id);
        return view("matricula/municipio")->with(['matriculas' => $matriculas]);
    }

    /**
    * Retorna todas as matriculas de um estado do Brasil
    *
    * @param integer $id - primary key da tabela estados
    * @return json
    */
    public function getMatriculasEstados($id_estado){
    	return Matriculas::getMatriculasEstados($id_estado);
    }
    
    /**
    * Retorna todas a soma das matriculas de um municipio do Brasil
    *
    * @param integer $id - primary key da tabela municipios
    * @return json
    */
    public function getIndicadores($id, $ano){
    	return Matriculas::getIndicadores($id, $ano);
    }

    /**
    * Retorna a soma das matriculas de um estado do Brasil
    *
    * @param integer $id - primary key da tabela estados
    * @return json
    */
    public function getIndicadoresEstado($id, $ano){
        return Matriculas::getIndicadoresEstado($id, $ano);
    }

}