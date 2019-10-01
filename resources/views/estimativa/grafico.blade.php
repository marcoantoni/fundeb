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
    <div class="input-field col s12 m4">
      <select id="modalidade" name="modalidade">
        <option value="" disabled selected>Escolha a modalidade</option>
        @foreach($modalidades AS $modalidade)
          <option value="{{$modalidade->id}}">{{$modalidade->nome}}</option>
        @endforeach
      </select>
      <label>Modalidade</label>
    </div>
    <div class="input-field col s12 m4">
      <select id="ano" name="ano">
          <option value="0">Todos</option>
        @foreach($anos AS $ano)
          <option value="{{$ano->ano}}">{{$ano->ano}}</option>
        @endforeach
      </select>
      <label>Ano</label>
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
      title: {
        text: 'Valor gasto por aluno de acordo com a modalidade educacional'
      },

      yAxis: {
        title: {
          text: 'Valor investido - R$'
        }
      },
      xAxis: {
        title: {
          text: 'Segmento da Educação'
        }
      },
      legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
      },

      responsive: {
        rules: [{
          condition: {
              maxWidth: 500
            },
            chartOptions: {
              legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
              }
            }
          }
        ]
      }
    });

    // url para buscar os dados
    // ano 0 selecionado significa "todos os anos"
    var url = '';
    if ($('select[name=ano]').val() == 0){  
      url = '{{ url("/estimativas") }}/graficos/' + id_estado + '/'+id_modalidade;
     
      // adiciona as series existentes
      graficos.addSeries({
          name: 2015, 
      }); 
      
      graficos.addSeries({
          name: 2016, 
      }); 

      graficos.addSeries({
          name: 2017, 
      }); 

      graficos.addSeries({
        name: 2018, 
      }); 

      graficos.addSeries({
          name: 2019, 
      }); 
    } else {
      url = '{{ url("/estimativas") }}/graficos/' + id_estado + '/'+id_modalidade + '/' + ano;
      graficos.addSeries({
          name: $('select[name=ano]').val(), 
      }); 
    }  

    var categories = [];  
    var anos = [];  
    
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
        
        if (!anos.includes(value.ano) )
          anos.push(value.ano);
        
        if ($('select[name=ano]').val() == 0 ){
          if (value.ano == 2015)
            graficos.series[0].addPoint({y: parseFloat(value.valor), name: label});
          if (value.ano == 2016)
            graficos.series[1].addPoint({y: parseFloat(value.valor), name: label});
          if (value.ano == 2017)
            graficos.series[2].addPoint({y: parseFloat(value.valor), name: label});
          if (value.ano == 2018)
            graficos.series[3].addPoint({y: parseFloat(value.valor), name: label});
          if (value.ano == 2019)
            graficos.series[4].addPoint({y: parseFloat(value.valor), name: label});
        } else {
          graficos.series[0].addPoint({y: parseFloat(value.valor), name: label});
        }

        if (!categories.includes(label) )
          categories.push(label);

      });
    });
    console.log(anos);
    console.log(categories);
      
  }

  $(document).ready(function(){
    $('select').formSelect();
    $('#estimativa').addClass('active');
    $('graficos').hide();
  });
</script>
@endsection