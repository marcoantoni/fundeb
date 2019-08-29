<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Estimativa;

class EstimativaController extends Controller {
	public function index(){
		//return view("municipio/index");
	}

    // $id e o id_estado
    public function show($id){
     	$estimativas = Estimativa::getEstimativas($id); //Estimativa::where("id_estados", $id)->get();

        return view("estimativa/show")->with(['estimativas' => $estimativas]);
    }
}