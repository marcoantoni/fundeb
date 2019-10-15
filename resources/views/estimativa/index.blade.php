@extends('app')

@section('title', 'Estimativa de valor gasto por aluno')

@section('sidebar')
@parent
  <p>This is appended to the master sidebar.</p>
@endsection

@section('content')

<form action="#">
  <div class="row">
    <div class="input-field col s12 m4">
      <select id="estados" name="estados">
        <option value="" disabled selected>Escolha o estado</option>
        @foreach($estados AS $estado)
          <option value="{{ $estado->id }}">{{ $estado->nome }}</option>
        @endforeach
      </select>
      <label>Estado</label>
    </div>
    <div class="input-field col s12 m2">
      <select id="ano" name="ano">
        @foreach($anos AS $ano)
          <option value="{{$ano->ano}}">{{$ano->ano}}</option>
        @endforeach
      </select>
      <label>Ano</label>
    </div>
  	<div class="input-field col s12 m2">
  	  <label>
          <input type="checkbox" name="escolapublica" checked="checked" />
          <span>Escola pública</span>
        </label>
  	</div>
  	<div class="input-field col s12 m2">
  	  <label>
          <input type="checkbox" name="escolaconveniada" checked="checked" />
          <span>Escola conveniada</span>
        </label>
  	</div>
  	<div class="input-field col s12 m2">
  	  <label>
          <input type="checkbox" name="escolarural" checked="checked" />
          <span>Escola Rural</span>
        </label>
  	</div>
  </div>
</form>

<table id="table" class="row-border">
  <thead>
    <tr>
      <th>MODALIDADE</th>
      <th>SEGMENTO</th>
      <th>TIPO</th>
      <th>EDUCACAO</th>
      <th>VALOR ANUAL</th>
      <th>VALOR MENSAL</th>
    </tr>
  </thead>

  <tbody id="tbody"></tbody>
</table>
<script src="https://code.highcharts.com/highcharts.js"></script>
<div id="graficos"></div>
<script>
  // ao selecionar o estado
  // busca as cidades deste estado e adiciona ao select
  $( '#estados' ).change(function() {
    $('table').show();
    $('#tbody').empty();
    // busca os dados relativos ao estado
    buscarDados($('select[name=estados]').val(), $('select[name=ano]').val());

  });

  $( '#ano' ).change(function() {
    $('table').show();
    $('#tbody').empty();
    buscarDados($('select[name=estados]').val(), $('select[name=ano]').val());
  });

  /**
  * Description               Busca a estimativa de valor gasto por aluno e preenche a tabela html
  * @param {int} id_estado    id do estado
  * @param {int} ano          ano que esta se buscando as informações
  * @return {void}            
  */
  function buscarDados(id_estado, ano){
    
    var url = '{{ url("/estimativas") }}/' + id_estado + '/ano/' + ano;
    console.log(url);

    $.ajax({
      type: 'GET',
      url: url,
      contentType: 'application/json',
      dataType: 'json',
    })
    .done(function(data) {
      $.each( data, function( key, value ) {
        var linha = '<tr class="' + value.tipo + ' ' + value.educacao + '">';
        linha += '<td>' + value.modalidade + '</td>';
        linha += '<td>' + value.segmento + '</td><td>';

        if (value.tipo == 'P')
          linha += 'Pública';
        else if(value.tipo == 'C')
          linha += 'Conveniada';

        linha +=  '</td><td>';
        
        if (value.educacao == 'R')
          linha += 'Rural';
        else if(value.educacao == 'U')
          linha += 'Urbano';
        
        linha +=  '</td>';


        linha += '<td>' + value.valor + '</td>';
        var valorMes = value.valor / 12;
        
        linha += '<td>' + valorMes.toFixed(2); + '</td>';
        linha += '</tr>';

        $('#table tbody').append(linha);
      });
    });
  }
  
  // controle na exibição dos dados
  $('input[type="checkbox"][name="escolapublica"]').change(function() {
  	$('.P').hide();
  	
  	if(this.checked) {
  		$('.P').show();
    }
  });

  $('input[type="checkbox"][name="escolaconveniada"]').change(function() {
  	$('.C').hide();
  	
  	if(this.checked) {
  		$('.C').show();
    }
  });

  $('input[type="checkbox"][name="escolarural"]').change(function() {
  	$('.R').hide();
  	
  	if(this.checked) {
  		$('.R').show();
    }
  });

  $(document).ready(function(){
    $('select').formSelect();
    $('#estimativa').addClass('active');
    $('table').hide();
  });
</script>
@endsection