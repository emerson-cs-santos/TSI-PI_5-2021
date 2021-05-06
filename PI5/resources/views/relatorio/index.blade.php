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
                                            <label for="tipo">Tipo do Relatório @if ( Auth::user()->premium == 'nao' ) Apenas disponivel modo simples @endif </label>
                                            <select name="tipo" class="form-control" id="tipo" onchange='apaga_filtros()'>
                                                <option value="simples" @if( isset($buscarTipo) )  @if($buscarTipo == 'simples') selected @endif  @else selected @endif    >Simples - Apenas as 5 ultimas Ocorrencias</option>

                                                @if ( Auth::user()->premium == 'sim' )
                                                    <option value="resumido" @if( isset($buscarTipo) )  @if($buscarTipo == 'resumido') selected @endif  @endif >Resumido - Apenas com Ocorrências importantes</option>
                                                    <option value="completo" @if( isset($buscarTipo) )  @if($buscarTipo == 'completo') selected @endif  @endif >Completo - Todas as Ocorrências</option>
                                                @endif
                                            </select>
                                        </div>

                                        @if ( Auth::user()->premium == 'sim' )
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-11 mt-2">
                                                    <input type="search" name="busca" class="form-control" id='busca' placeholder="O que está buscando?" oninput='seta_completo_busca()'
                                                        @if( isset($busca) )  value="{{$busca}}"  @endif >
                                                </div>

                                                <div class="col-12 col-sm-12 col-md-1 mt-2">
                                                    <button type="submit" class="btn btn-secondary" data-placement="top" data-toggle="tooltip" title="Fazer busca">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif


                                        @if ( Auth::user()->premium == 'sim' )
                                            <div class="col-12 d-flex justify-content-center mt-3">
                                                <div class="row">

                                                    <div class="form-group col-sm-12 col-md-6">
                                                        <label for="dataInicial">Data da ocorrência Inicial</label>
                                                        <input type="date" name="dataInicial" id="dataInicial" class="form-control" oninput='seta_completo_data()'
                                                            @if( isset($buscarDataInicial) )  value="{{$buscarDataInicial}}"  @endif >
                                                    </div>

                                                    <div class="form-group col-sm-12 col-md-6">
                                                        <label for="dataFinal">Data da ocorrência Final</label>
                                                        <input type="date" name="dataFinal" id="dataFinal" class="form-control" oninput='seta_completo_data()'
                                                            @if( isset($buscarDataFinal) )  value="{{$buscarDataFinal}}"  @endif >
                                                    </div>

                                                </div>
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
                                                    <th>Ocorrência</th>
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
                                                            <td>{{$registro->caso}}</td>
                                                            <td>{{$registro->resumo}}</td>

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
