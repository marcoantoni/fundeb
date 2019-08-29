<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Estimativa extends Model {
    protected $table = "VLestimadoAluno";
    public $timestamps = false;

    public static function getEstimativas($id_estado){
    	$sql = "SELECT VLestimadoAluno.valor, VLestimadoAluno.educacao, VLestimadoAluno.tipo, modalidades.nome AS modalidade, segmentos.nome AS segmento FROM VLestimadoAluno, segmentos, modalidades, estados WHERE VLestimadoAluno.id_estados = estados.id AND VLestimadoAluno.id_segmento = segmentos.id AND segmentos.id_modalidade = modalidades.id";
    	return DB::select($sql);
    }

}
