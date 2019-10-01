<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Estimativa extends Model {
    protected $table = "VLestimadoAluno";
    public $timestamps = false;

    public static function getEstimativas($id_estado, $ano=NULL, $id_modalidade=NULL){
    	$sql = "SELECT VLestimadoAluno.valor, VLestimadoAluno.educacao, VLestimadoAluno.tipo, modalidades.nome AS modalidade, segmentos.nome AS segmento, ano FROM VLestimadoAluno, segmentos, modalidades WHERE VLestimadoAluno.id_estado = $id_estado AND VLestimadoAluno.id_segmento = segmentos.id AND segmentos.id_modalidade = modalidades.id ";
    	
        if (!is_null($ano)){
            $sql .= " AND VLestimadoAluno.ano = $ano";
        }

    	if (!is_null($id_modalidade) ){
    		$sql .= " AND segmentos.id_modalidade = $id_modalidade";
    	}
  		  
    	$sql .=  " ORDER BY VLestimadoAluno.id ASC ";
    	
    	return DB::select($sql);
    }

    public static function getEstimativasGeral($id_estado){
    	$sql = "SELECT segmentos.nome, modalidades.nome, valor, educacao, tipo, ano FROM VLestimadoAluno, segmentos, modalidades WHERE VLestimadoAluno.id_estado = $id_estado AND VLestimadoAluno.id_segmento = segmentos.id AND segmentos.id_modalidade = modalidades.id";
    	return DB::select($sql);
    }

}
