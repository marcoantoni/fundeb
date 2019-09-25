<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ano;
use App\Estimativa;
use App\Estados;
use App\Modalidade;

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
     	return $estimativas = Estimativa::getEstimativas($id_estado, $ano, NULL); 
    }

    public function graficos(){
        
        $id_estado = request()->segment(3);
        $id_modalidade = request()->segment(4);
        $ano = request()->segment(5);
        // se passou os tres parametros pela url, retorna o json para exibição via javascript
        if (isset($id_estado) && isset($id_modalidade) && isset($ano)) {
            return $estimativas = Estimativa::getEstimativas($id_estado, $ano, $id_modalidade); 
        } else {
            $estados = Estados::orderBy("nome", "ASC")->get();
            $anos = Ano::orderBy("ano", "ASC")->get();
            $modalidades = Modalidade::orderBy("nome", "ASC")->get();
            $estimativas = Estimativa::getEstimativas(24, 2019); 
            
            return view("estimativa/grafico")->with([
                "estimativas" => $estimativas, 
                "estados" => $estados,
                "modalidades" => $modalidades, 
                "anos" => $anos
            ]);
        }
    }

    public function graficoComparacaoAnual(){
        return $id_estado = request()->segment(3);
       // return Estimativa::getEstimativasGeral($id_estado);
    }
}