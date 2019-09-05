<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// rota para obter os todos os municipios de um estado
Route::get('municipios/{id}', 'MunicipioController@show');

Route::resource('despesa', 'DespesaController');



// só usada para obter os estados
//Route::get('estados/{id}', 'EstadoController@show');

Route::get('estimativas/', 'EstimativaController@index'); 
Route::get('estimativas/{id_estado}/ano/{ano}', 'EstimativaController@show'); 


Route::get('despesa/relatorio/{id}', 'DespesaController@getRelatorio');

Route::get('matricula', 'MatriculaController@index');
Route::get('matricula/{id}', 'MatriculaController@getMatriculas');
Route::get('matricula/{id_estado}/estado', 'MatriculaController@getMatriculasEstados');
Route::get('matricula/indicadores/{id}', 'MatriculaController@getIndicadores');
Route::get('matricula/indicadores/{id}/estado', 'MatriculaController@getIndicadoresEstado');