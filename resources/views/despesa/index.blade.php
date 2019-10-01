@extends('app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
<form action="">
    <div class="row">
        <div class="input-field col s12 m6">
            <select id="estados" name="estados">
                <option value="" disabled selected>Escolha o estado</option>
                @foreach($estados AS $estado)
                    <option value="{{ $estado->id }}">{{ $estado->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-field col s12 m6">
            <select id="municipios" name="municipios">
              <option value="" disabled selected>Escolha o municipio</option>
            </select>
        </div>
    </div>
</form>

<script src="https://code.highcharts.com/highcharts.js"></script>
<div id="graficos"></div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    // ao selecionar o estado
    $( '#estados' ).change(function() {
        var id_estado = $('select[name=estados]').val();
        var url = '{{ url("/municipios") }}' + '/' + id_estado;
        $.ajax({
            type: "GET",
            url: url,
            contentType: "application/json",
            dataType: "json",
        })
        .done(function(data) {
        $('#municipios').empty();
            $.each( data, function( key, value ) {
                console.log("tesponde ");
                $('#municipios').append('<option value="' + value.codigo + '">' + value.nome + '</option>');
            });
            // reinicializando o select 
            $('#municipios').formSelect();
        });
    });
    // ao selecionar o municipio
    var municipios = [];
    $( '#municipios' ).change(function() {
        var co_municipio_ibge = $('select[name=municipios]').val();
        var municipio = $('#municipios option:selected').text();
        var url = '{{ url("despesa/relatorio/") }}' + '/' + co_municipio_ibge;
        console.log('url despesa' + url);
        $.ajax({
            type: 'GET',
            url: url,
            contentType: 'application/json',
            dataType: 'json',
        })
        .done(function(data) {
            var dados = [];
            municipios.push(municipio);
            $.each( data, function( key, value ) {
                // adicionando pontos no grafico
               graficos.series[0].addPoint({y: parseFloat(value['VL_RECEITA_PREVISAO_ATUALIZADA']), name: municipio} );
               graficos.series[1].addPoint({y: parseFloat(value['VL_RECEITA_REALIZADA']), name: municipio}, true);
               graficos.series[2].addPoint({y: parseFloat(value['VL_RECEITA_ORCADA']), name: municipio}, true);
               graficos.series[3].addPoint({y: parseFloat(value['VL_DESPESA_EMPENHADA']), name: municipio}, true);
               graficos.series[4].addPoint({y: parseFloat(value['VL_DESPESA_PAGA']), name: municipio}, true);
               graficos.series[5].addPoint({y: parseFloat(value['VL_DESPESA_LIQUIDADA_EDUCACAO']), name: municipio}, true);
            });
            $('#graficos').show();
            graficos.xAxis[0].update({categories: municipios}, true);
            console.log('municipios' + municipios);
        });
        
    });
    var graficos = Highcharts.chart('graficos', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Relatório dos recursos'
        },
        yAxis: {
            title: {
                text: 'R$'
            }
        },
        xAxis: {
            title: {
                text: 'Município'
            }
        },
        series: [
            { name: 'VL_RECEITA_PREVISAO_ATUALIZADA'},
            { name: 'VL_RECEITA_REALIZADA' },
            { name: 'VL_RECEITA_ORCADA'},
            { name: 'VL_DESPESA_EMPENHADA'},
            { name: 'VL_DESPESA_PAGA'},
            { name: 'VL_DESPESA_LIQUIDADA_EDUCACAO'}
        ]
    });
    $(document).ready(function() {
        $('select').formSelect();
        $('#acompanhargastos').addClass('active');
        $('#graficos').hide();
    });
</script>
@endsection