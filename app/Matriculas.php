<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Matriculas extends Model {
    protected $table = "matriculas";
    public $timestamps = false;

    public static function getMatriculas($id_municipio){
    	$sql = "SELECT modalidades.nome, segmentos.nome, matriculas.quantidade, matriculas.tipo, matriculas.educacao, modalidades.id AS id_modalidade FROM matriculas, segmentos, modalidades WHERE matriculas.id_municipio = $id_municipio AND matriculas.id_segmento = segmentos.id AND segmentos.id_modalidade = modalidades.id ORDER BY matriculas.id ASC";
    	return DB::select($sql);
    }

    public static function getMatriculasEstado($id_estado){
    	$sql = "SELECT SUM(quantidade) AS quantidade, modalidades.nome FROM matriculas, segmentos, modalidades WHERE matriculas.id_estado = $id_estado AND matriculas.id_segmento = segmentos.id AND segmentos.id_modalidade = modalidades.id GROUP BY modalidades.nome ORDER BY nome ASC";
    	return DB::select($sql);
    }
}
