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

    // $id e referece ao municipio
    public function show($id){
     	return $matriculas = Matriculas::getMatriculas($id);
        return view("matricula/municipio")->with(['matriculas' => $matriculas]);
    }

    public function getIndicadores($id){
    	return Matriculas::getIndicadores($id);
    }

    public function getMatriculasEstado($id_estado){
    	return Matriculas::getMatriculasEstado($id_estado);
    }
}