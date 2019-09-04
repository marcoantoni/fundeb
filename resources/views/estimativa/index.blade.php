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


<style>
  .modal {
    width: 100%;
    height: 100%;
  }
  iframe {
    border: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }
</style>

<script>
  // ao selecionar o estado
  $( '#estados' ).change(function() {
    $('table').show();
    $('#tbody').empty();
    buscarDados($('select[name=estados]').val(), $('select[name=ano]').val());

    /*$('#municipios').empty();
    $('#municipios').append('<option value="" disabled selected>Selecione</option>');
    var id_estado = $('select[name=estados]').val();
    $.ajax({
      type: "GET",
      url: "http://127.0.0.1:8000/municipios/"+id_estado,
      contentType: "application/json",
      dataType: "json",
    })
    .done(function(data) {
      $.each( data, function( key, value ) {
        $('#municipios').append('<option value="'+value.id+'">'+value.nome+'</option>');
      });
    });*/
  });

  $( '#ano' ).change(function() {
    $('table').show();
    $('#tbody').empty();
    buscarDados($('select[name=estados]').val(), $('select[name=ano]').val());
  });

  // gera a tabela e preenche os dados
  // id pode ser: id_municipio ou id_estado
  function buscarDados(id_estado, ano){
    
    var url = 'http://127.0.0.1:8000/estimativas/' + id_estado + '/ano/' + ano;    
    console.log('url: ' + url);
    $.ajax({
      type: "GET",
      url: url,
      contentType: "application/json",
      dataType: "json",
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