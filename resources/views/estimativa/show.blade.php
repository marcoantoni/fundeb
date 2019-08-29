@extends('app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
<div class="header">
    <h1>Estimativa por aluno</h1>
    <h2>Veja qual a estimativa de custo anual por aluno</h2>
</div>
<div class="content">
    <table class="pure-table">
        <thead>
            <tr>
                <th>MODALIDADE / SEGMENTO</th>
                <th>TIPO</th>
                <th>EDUCACAO</th>
                <th>VALOR ANUAL</th>
            </tr>
        </thead>

        <tbody>
            @foreach($estimativas AS $estimativa)
            <tr>
                <td>{{ $estimativa->modalidade }} / {{ $estimativa->segmento }}</td>    
                
                @if ($estimativa->tipo == 'U' )
                    <td>Urbana</td>
                @elseif($estimativa->tipo == 'R')
                    <td>Rural</td>
                @else
                    <td>-</td>
                @endif
                
                @if ($estimativa->educacao == 'P')
                    <td>Pública</td>
                @else
                    <td></td>
                @endif

                <td>{{ $estimativa->valor }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection