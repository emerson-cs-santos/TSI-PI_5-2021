@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Relatório</div>
                    <h2 class="page-title text-center"> Relátorio de Casos e suas Ocorrências</h2>
                </div>
            </div>

            @include('exibirAlert')

            <div class="container-fluid mt-2">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 ml-auto">
                        <div class="row align-items-center">

                            {{-- Conteiner final onde as informações são de fato exibidas --}}
                            <div class="container">
                                <div class="col-12">

                                    <form action="/buscar-relatorio" method="POST" role="search">
                                    {{ csrf_field() }}

                                        <div class="form-group">
                                            <label for="tipo">Tipo do Relatório @if ( Auth::user()->premium == 'nao' ) Apenas disponível modo simples @endif </label>
                                            <select name="tipo" class="form-control" id="tipo">
                                                <option value="simples" @if( isset($buscarTipo) )  @if($buscarTipo == 'simples') selected @endif  @else selected @endif    >Simples - Apenas as 5 últimas Ocorrências</option>

                                                @if ( Auth::user()->premium == 'sim' )
                                                    <option value="completo" @if( isset($buscarTipo) )  @if($buscarTipo == 'completo') selected @endif  @endif >Completo - Todas as Ocorrências</option>
                                                @endif
                                            </select>
                                        </div>

                                        @if ( Auth::user()->premium == 'sim' )

                                            <div class="row">

                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label for="tipo_id">Tipo:</label>
                                                    <select name="tipo_id" class="form-control" id="tipo_id" >
                                                        @foreach($tipos as $tipo)
                                                            <option style="color: {{$tipo->color}}" value="{{$tipo->id}}"
                                                            @if ( $tipo_idBuscado == $tipo->id ) selected @endif >{{$tipo->name}}</option>
                                                        @endforeach
                                                            <option value="todos" @if ( $tipo_idBuscado == 'todos' ) selected @endif >Todos</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label for="importancia">Relevância:</label>
                                                    <select name="importancia" class="form-control" id="importancia" >
                                                        <option value="Importante" @if ( $importancia_Buscado == 'Importante' ) selected @endif >Importante</option>
                                                        <option value="Rotina" @if ( $importancia_Buscado == 'Rotina' ) selected @endif >Rotina</option>
                                                        <option value="todos" @if ( $importancia_Buscado == 'todos' ) selected @endif >Todos</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-12 col-md-4">
                                                    <label for="especialidade_id">Especialidade:</label>
                                                    <select name="especialidade_id" class="form-control" id="especialidade_id" >
                                                        @foreach($especialidades as $especialidade)
                                                            <option value="{{$especialidade->id}}" @if ( $especialidade_idBuscado == $especialidade->id ) selected @endif >{{$especialidade->name}} </option>
                                                        @endforeach
                                                            <option value="todos" @if ( $especialidade_idBuscado == 'todos' ) selected @endif >Todos</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="form-group col-sm-12 col-md-7">
                                                    <label for="caso">Caso:</label>
                                                    <input type="search" name="caso" id="caso" class="form-control" placeholder="Buscar caso"
                                                        @if( isset($caso_Buscado) )  value="{{$caso_Buscado}}"  @endif >
                                                </div>

                                                <div class="form-group col-sm-12 col-md-5">
                                                    <label for="status">Status:</label>
                                                    <select name="status" class="form-control" id="status" >
                                                        <option value="Em investigação" @if ( $status_Buscado == 'Em investigação' ) selected @endif >Em investigação</option>
                                                        <option value="Doença controlada" @if ( $status_Buscado == 'Doença controlada' ) selected @endif >Doença controlada com remédio contínuo</option>
                                                        <option value="Curado" @if ( $status_Buscado == 'Curado' ) selected @endif >Curado</option>
                                                        <option value="todos" @if ( $status_Buscado == 'todos' ) selected @endif >Todos</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-sm-12 col-md-12">
                                                    <label for="resumo">Ocorrência (Resumo):</label>
                                                    <input type="search" name="resumo" id="resumo" class="form-control" placeholder="Buscar resumo"
                                                        @if( isset($resumo_Buscado) )  value="{{$resumo_Buscado}}"  @endif >
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="form-group col-sm-12 col-md-6">
                                                    <label for="dataInicial">Data da ocorrência Inicial:</label>
                                                    <input type="date" name="dataInicial" id="dataInicial" class="form-control"
                                                        @if( isset($buscarDataInicial) )  value="{{$buscarDataInicial}}"  @endif >
                                                </div>

                                                <div class="form-group col-sm-12 col-md-6">
                                                    <label for="dataFinal">Data da ocorrência Final:</label>
                                                    <input type="date" name="dataFinal" id="dataFinal" class="form-control"
                                                        @if( isset($buscarDataFinal) )  value="{{$buscarDataFinal}}"  @endif >
                                                </div>

                                            </div>

                                            <div class="col-sm-12 col-md-12 d-flex justify-content-center mt-1">
                                                <button type="submit" class="btn btn-secondary" data-placement="top" data-toggle="tooltip" title="Fazer busca">
                                                    <span class="fa fa-search" data-placement="top" data-toggle="tooltip" title="Fazer busca"></span>
                                                </button>
                                            </div>

                                        @endif

                                    </form>

                                    <div class="col-12 mt-3 d-flex justify-content-center mb-3">
                                        @php
                                            $imprimir = $registros->toJson();
                                        @endphp

                                        <form action="/relatorio-impressao" method="POST" role="search">
                                            {{ csrf_field() }}

                                            <input type="search" name="campoImpressao" id='campoImpressao' value="{{$imprimir}}" hidden>

                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary" data-placement="top" data-toggle="tooltip" title="Fazer impressão">
                                                    <span class="fa fa-print"></span> Impressão
                                                </button>
                                            </div>
                                        </form>

                                        <form action="/relatorio-file-todos" method="POST" role="search">
                                            {{ csrf_field() }}

                                            <input type="search" name="campoGetFiles" id='campoGetFiles' value="{{$imprimir}}" hidden>

                                            <div class="col-12">
                                                <button type="submit" class="btn btn-info" data-placement="top" data-toggle="tooltip" title="Baixar anexos das ocorrências">
                                                    <span class="fas fa-download"></span> Baixar arquivos
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Tabela inicio --}}
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped bg-light text-center table-bordered table-hover">
                                            <thead class="text-dark">
                                                <tr>
                                                    <th>Caso</th>
                                                    <th>Status</th>
                                                    <th>Ocorrência (Resumo)</th>
                                                    <th>Data</th>
                                                    <th>Especialidade</th>
                                                    <th>Tipo</th>
                                                    <th>Relevância</th>
                                                    <th>Qtd. Anexos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($registros as $registro)

                                                    @if ( $registro->user_id == Auth::user()->id)

                                                        <tr>
                                                            <td style="color:blue; text-decoration: underline;"> <a href="{{ route('Casos.show', $registro->caso_id) }}" data-placement="top" data-toggle="tooltip" title="Abrir Caso">{{$registro->caso}}</a> </td>
                                                            <td>{{$registro->status}}</td>
                                                            <td style="color:blue; text-decoration: underline;"> <a href="{{ route( 'Ocorrencias.show', ['caso'=>$registro->caso_id,'ocorrencia'=>$registro->id] ) }}" data-placement="top" data-toggle="tooltip" title="Abrir Ocorrência">{{$registro->resumo}}</a> </td>

                                                            @php
                                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $registro->data );
                                                                $DataOcorrencia = $date->format('d/m/Y');
                                                            @endphp
                                                            <td>{{ $DataOcorrencia}}</td>

                                                            <td>{{$registro->especialidade}}</td>
                                                            <td style="color: {{$registro->cor}}" class="font-weight-bold">{{$registro->tipo}}</td>
                                                            <td>{{$registro->importancia}}</td>
                                                            <td>{{$registro->arquivos()->count()}}</td>
                                                        </tr>

                                                    @endif

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- Tabela fim --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
