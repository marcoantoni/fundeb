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
          <h3 id="matriculasedinfantil"></h3>
          <p>Matrículas</p>
        </div>
      </div>
    </div>
    <div class="col s6 m2">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <p>Ensino fundamental</p>
          <h3 id="matriculasedfundamental"></h3>
          <p>Matrículas</p>
        </div>
      </div>
    </div>
    <div class="col s6 m2">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <p>EJA</p>
          <h3 id="matriculaseja"></h3>
          <p>Matrículas</p>
        </div>
      </div>
    </div>
        <div class="col s6 m2">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <p>AEE</p>
          <h3 id="matriculasaee"></h3>
          <p>Matrículas</p>
        </div>
      </div>
    </div>
    <div class="col s6 m2">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <p>Educação especial</p>
          <h3 id="matriculasedespecial"></h3>
          <p>Matrículas</p>
        </div>
      </div>
    </div>
    <div class="col s6 m2">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <p>Estimativa receitas</p>
          <h3 id="estimativareceitas"></h3>
          <p>reais</p>
        </div>
      </div>
    </div>
</div>

<table id="table" class="highlight striped responsive-table">
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

    $('#municipios').empty();
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
    });
  });

  $( '#municipios' ).change(function() {
    $('table').show();
    $('#tbody').empty();
    buscarDados($('select[name=municipios]').val());
  });

  // gera a tabela e preenche os dados
  function buscarDados(id_municipio){
    var url = 'http://127.0.0.1:8000/matricula/' + id_municipio;
    $.ajax({
      type: "GET",
      url: url,
      contentType: "application/json",
      dataType: "json",
    })
    .done(function(data) {
      console.log('ajax sucess');
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
      var url = '{{ url("/matricula/indicadores") }}' + '/' + id_municipio;
      console.log("url cards " + url);
      // limpando cards
      $('#matriculasaee').empty();
      $('#matriculasedespecial').empty();
      $('#matriculasedinfantil').empty();
      $('#matriculaseja').empty();
      $('#matriculasedfundamental').empty();
      $('#matriculasensmedio').empty();
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