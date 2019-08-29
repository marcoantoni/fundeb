<!DOCTYPE html>
<html lang="pt-BR">
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	  <title>Relatório de matriculas do municipio</title>

	  <!-- CSS  -->
	  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	  <link type="text/css" rel="stylesheet" href="https://materializecss.com/dist/css/materialize.min.css"  media="screen,projection"/>
	  <link href="https://materializecss.com/templates/starter-template/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	   <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	</head>
	<body>

		<style>
			.card{height: 180px;}
		</style>
		<div class="row">
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
		<div class="row">
			<table class="highlight striped responsive-table">
			    <thead>
			        <tr>
			            <th>TIPO</th>
			            <th>MATRICULAS</th>
			            <th>ESCOLA</th>
			            <th>EDUCACAO</th>
			        </tr>
			    </thead>

			    <tbody>
			        @foreach($matriculas AS $matricula)
			        <tr>
			            <td>{{ $matricula->nome }}</td>
			            <td>{{ $matricula->quantidade }}</td>
			            <td> 
			                @if($matricula->educacao == 'U')
			                    Urbano
			                @elseif($matricula->educacao == 'R')
			                    Rural
			                @elseif($matricula->educacao == null)
			                        -
			                @endif
			            </td>
			            <td>
			                @if($matricula->tipo == 'P')    
			                    Público
			                @else
			                    Conveniada
			                @endif    
			            </td>
			        </tr>
			        @endforeach
			    </tbody>
			</table>
		</div>
		<script>
		    var url = '{{ url("/matricula/indicadores") }}' + '/{{ Request::segment(2) }}';
		    $.ajax({
		            type: 'GET',
		            url: url,
		            contentType: 'application/json',
		            dataType: 'json',
		        })
		        .done(function(data) {
		            $('#matriculasaee').append(data[0].quantidade);
		            $('#matriculasedespecial').append(data[1].quantidade);
		            $('#matriculasedinfantil').append(data[3].quantidade);
		            $('#matriculaseja').append(data[4].quantidade);
		            $('#matriculasedfundamental').append(data[5].quantidade);
		            $('#matriculasensmedio').append(data[6].quantidade);
		        });
		    //http://127.0.0.1:8000/matricula/indicadores/4956
		    $(document).ready(function(){
		        $('select').material_select();
		  });
		</script>
	</body>
</html>