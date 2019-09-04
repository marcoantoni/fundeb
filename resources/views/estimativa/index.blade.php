@extends('app')

@section('title', 'Estimativa de valor gasto por aluno')

@section('sidebar')
@parent
  <p>This is appended to the master sidebar.</p>
@endsection

@section('content')

<form action="#">
  <div class="row">
    <div class="input-field col s12 m6">
      <select id="estados" name="estados" class="browser-default">
        <option value="" disabled selected>Escolha o estado</option>
        @foreach($estados AS $estado)
          <option value="{{ $estado->id }}">{{ $estado->nome }}</option>
        @endforeach
      </select>
    </div>
    <div class="input-field col s12 m6">
      <select id="ano" name="ano" class="browser-default">
        @foreach($anos AS $ano)
          <option value="{{$ano->ano}}">{{$ano->ano}}</option>
        @endforeach
      </select>
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
    console.log('url: ' + url);
    $.ajax({
      type: 'GET',
      url: url,
      contentType: 'application/json',
      dataType: 'json',
    })
    .done(function(data) {
      console.log('ajax sucess');
      console.log('dados' + data);
      $.each( data, function( key, value ) {
        var linha = '<tr>';
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
  $(document).ready(function(){
    $('table').hide();
  });
</script>
@endsection