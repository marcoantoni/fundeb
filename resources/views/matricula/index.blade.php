@extends('app')

@section('title', 'Relatório de matriculas do municipio')

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
      <select id="municipios" name="municipios" class="browser-default">
        <option value="" disabled selected>Escolha o municipio</option>
      </select>
      </div>
    </div>
</form>
<style>
  .card{height: 180px;}
</style>
<div id="cards" class="row">
    <div class="col s6 m2">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <p>Educação infantil</p>
          <h4 id="matriculasedinfantil"></h4>
          <p>Matrículas</p>
        </div>
      </div>
    </div>
    <div class="col s6 m2">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <p>Ensino fundamental</p>
          <h4 id="matriculasedfundamental"></h4>
          <p>Matrículas</p>
        </div>
      </div>
    </div>
    <div class="col s6 m2">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <p>EJA</p>
          <h4 id="matriculaseja"></h4>
          <p>Matrículas</p>
        </div>
      </div>
    </div>
        <div class="col s6 m2">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <p>AEE</p>
          <h4 id="matriculasaee"></h4>
          <p>Matrículas</p>
        </div>
      </div>
    </div>
    <div class="col s6 m2">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <p>Educação especial</p>
          <h4 id="matriculasedespecial"></h4>
          <p>Matrículas</p>
        </div>
      </div>
    </div>
    <div class="col s6 m2">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <p>Estimativa receitas</p>
          <h4 id="estimativareceitas"></h4>
          <p>reais</p>
        </div>
      </div>
    </div>
</div>

<table id="table" class="row-border">
  <thead>
    <tr>
      <th>TIPO</th>
      <th>MATRICULAS</th>
      <th>ESCOLA</th>
      <th>EDUCACAO</th>
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
    buscarDados($('select[name=estados]').val(), 'E');

    $('#municipios').empty();
    $('#municipios').append('<option value="" disabled selected>Selecione</option>');
    var id_estado = $('select[name=estados]').val();
    var url = '{{ url("/municipios") }}/' + id_estado;
    $.ajax({
      type: 'GET',
      url: url,
      contentType: 'application/json',
      dataType: 'json',
    })
    .done(function(data) {
      $.each( data, function( key, value ) {
        $('#municipios').append('<option value="'+value.id+'">'+value.nome+'</option>');
      });
    });
  });

  // ao selecionar o municipio
  $( '#municipios' ).change(function() {
    $('table').show();
    $('#tbody').empty();
    // busca os dados relativos ao municipio selecionado
    buscarDados($('select[name=municipios]').val(), 'M');
  });

  /**
  * Description               Busca as matriculas e preenche a tabela html
  * @param {int} id           id do municipio ou estado
  * @param {char} cod         'E' refere-se a estado e 'M' municipio
  * @return {void}            
  */
  function buscarDados(id, cod){
    var url = '{{ url("/matricula") }}/' + id;;
    if (cod === 'E'){
      url += '/estado';
    }
    
    $.ajax({
      type: 'GET',
      url: url,
      contentType: 'application/json',
      dataType: 'json',
    })
    .done(function(data) {
      $.each( data, function( key, value ) {
        var linha = '<tr>';
        linha += '<td>' + value.nome + '</td>';
        linha += '<td>' + value.quantidade + '</td><td>';

        if (value.educacao == 'R')
          linha += 'Rural';
        else if(value.educacao == 'U')
          linha += 'Urbano';
        else
          linha += ''; 

          linha +=  '</td><td>';

        if (value.tipo == 'P')
          linha += 'Pública';
        else if(value.tipo == 'C')
          linha += 'Conveniada';
        else
          linha += ''; 

          linha += '</td></tr>';

        $('#table tbody').append(linha);
      });
      
      //preencher cards

      // limpando cards
      $('#matriculasaee').empty();
      $('#matriculasedespecial').empty();
      $('#matriculasedinfantil').empty();
      $('#matriculaseja').empty();
      $('#matriculasedfundamental').empty();
      $('#matriculasensmedio').empty();
      
      var url = '{{ url("/matricula/indicadores") }}/' + id;
      if (cod === 'E')
        url += '/estado';
      
      $.ajax({
          type: 'GET',
          url: url,
          contentType: 'application/json',
          dataType: 'json',
      })
      .done(function(data) {
        $('#cards').show();
        $('#matriculasaee').append(data[0].quantidade);
        $('#matriculasedespecial').append(data[1].quantidade);
        $('#matriculasedinfantil').append(data[3].quantidade);
        $('#matriculaseja').append(data[4].quantidade);
        $('#matriculasedfundamental').append(data[5].quantidade);
        $('#matriculasensmedio').append(data[6].quantidade);
      });
    });
  }
  $(document).ready(function(){
    $('table').hide();
    $('#cards').hide();
  });
</script>
@endsection