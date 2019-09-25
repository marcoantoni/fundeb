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
      <select id="estados" name="estados" class="browser-default">
        <option value="" disabled selected>Escolha o estado</option>
        @foreach($estados AS $estado)
          <option value="{{ $estado->id }}">{{ $estado->nome }}</option>
        @endforeach
      </select>
    </div>
    <div class="input-field col s12 m4">
      <select id="modalidade" name="modalidade" class="browser-default">
        <option value="" disabled selected>Escolha a modalidade</option>
        @foreach($modalidades AS $modalidade)
          <option value="{{$modalidade->id}}">{{$modalidade->nome}}</option>
        @endforeach
      </select>
    </div>
    <div class="input-field col s12 m4">
      <select id="ano" name="ano" class="browser-default">
        @foreach($anos AS $ano)
          <option value="{{$ano->ano}}">{{$ano->ano}}</option>
        @endforeach
      </select>
      </div>
    </div>
</form>

<script src="https://code.highcharts.com/highcharts.js"></script>
<div id="graficos"></div>
<script>
  // ao selecionar o estado
  // busca as cidades deste estado e adiciona ao select
  $( '#estados' ).change(function() {
    // busca os dados relativos ao estado
    buscarDados($('select[name=estados]').val(), $('select[name=modalidade]').val(), $('select[name=ano]').val());

  });

  $( '#modalidade' ).change(function() {
    buscarDados($('select[name=estados]').val(), $('select[name=modalidade]').val(), $('select[name=ano]').val());
  });

  $( '#ano' ).change(function() {
    buscarDados($('select[name=estados]').val(), $('select[name=modalidade]').val(), $('select[name=ano]').val());
  });

  /**
  * Description               Busca a estimativa de valor gasto por aluno e preenche a tabela html
  * @param {int} id_estado    id do estado
  * @param {int} ano          ano que esta se buscando as informações
  * @return {void}            
  */
  function buscarDados(id_estado, id_modalidade, ano){
    var graficos = Highcharts.chart('graficos', {
      chart: {
          type: 'bar'
      },
      title: {
          text: 'Comparação do investimento estimado por estudante'
      },
      yAxis: {
          title: {
              text: 'R$'
          }
      },
      xAxis: {
          title: {
              text: 'Segmento'
          }
      },
      series: [
          { name: $('select[name=ano]').val() }
          /*{ name: 'VL_RECEITA_REALIZADA' },
          { name: 'VL_RECEITA_ORCADA'},
          { name: 'VL_DESPESA_EMPENHADA'},
          { name: 'VL_DESPESA_PAGA'},
          { name: 'VL_DESPESA_LIQUIDADA_EDUCACAO'}*/
      ]
    });


      var seriesLength = graficos.series.length;
      for(var i = seriesLength -1; i > -1; i--) {
          graficos.series[i].remove();
      }
      
      graficos.addSeries({
          name: $('select[name=ano]').val() 
      });
  

    // url para buscar os dados
    var url = '{{ url("/estimativas") }}/graficos/' + id_estado + '/'+id_modalidade + '/' + ano;
    
    $.ajax({
      type: 'GET',
      url: url,
      contentType: 'application/json',
      dataType: 'json',
    })
    .done(function(data) {
      $.each( data, function( key, value ) {
        var label = value.segmento + ' / Educação '; 
        
        if (value.educacao == 'U')
          label += 'Urbana';
        else if (value.educacao == 'R')
          label += 'Rural';

        label += ' / Escola ';

        if (value.tipo == 'P')
          label += 'Pública';
        else if (value.tipo == 'C')
          label += 'Conveniada';
        
        graficos.series[0].addPoint({y: parseFloat(value.valor), name: label});
      });
    });
  }

  $(document).ready(function(){
    $('#estimativa').addClass('active');
    $('graficos').hide();
  });
</script>
@endsection