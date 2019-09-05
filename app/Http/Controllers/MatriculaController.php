<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Matriculas;
use App\Estados;

class MatriculaController extends Controller {
	
    public function index(){
		$estados = Estados::orderBy("nome", "ASC")->get();
		return view("matricula/index")->with(["estados" => $estados]);
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
    public function getIndicadores($id){
    	return Matriculas::getIndicadores($id);
    }

    /**
    * Retorna a soma das matriculas de um estado do Brasil
    *
    * @param integer $id - primary key da tabela estados
    * @return json
    */
    public function getIndicadoresEstado($id){
        return Matriculas::getIndicadoresEstado($id);
    }

}