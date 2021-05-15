@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Ocorrências</div>
                    <h2 class="page-title text-center">
                        @if( Str::of( Request::path() )->contains( ['trashed-Ocorrencias', 'buscar-Ocorrencias-Trashed'] ) )
                            Lixeira de
                        @endif
                        Ocorrências do caso {{$caso}}
                    </h2>
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

                                    @if( !Str::of( Request::path() )->contains( ['trashed-Ocorrencias', 'buscar-Ocorrencias-Trashed'] ) )
                                        <div class='d-flex mb-2 justify-content-center'>
                                            <a href="{{route('Ocorrencias.create', $casoId )}}" class='btn btn-success'> <i class="fas fa-plus"></i> Novo</a>
                                        </div>
                                    @endif

                                    @if( Str::of( Request::path() )->contains( ['trashed-Ocorrencias', 'buscar-Ocorrencias-Trashed'] )  )
                                        <form action="/buscar-Ocorrencias-Trashed/{{$casoId}}" method="POST" role="search">
                                    @else
                                        <form action="/buscar-Ocorrencias/{{$casoId}}" method="POST" role="search">
                                    @endif
                                        {{ csrf_field() }}

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
                                            <div class="form-group col-sm-12 col-md-12">
                                                <label for="resumo">Resumo:</label>
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

                                    </form>

                                    <div class="col-12 mt-3 d-flex justify-content-center mb-3">
                                        @if( Str::of( Request::path() )->contains( ['trashed-Ocorrencias', 'buscar-Ocorrencias-Trashed'] )  )
                                            <a href="{{route('Ocorrencias.index', $casoId )}}" class='btn btn-info'> <i class="fas fa-arrow-left"></i> Voltar ao cadastro</a>
                                        @else
                                            <a href="{{ route('trashed-Ocorrencias.index', $casoId ) }}" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" title="Acessar registros excluídos"><i class="fas fa-recycle"></i> Lixeira</a>
                                        @endif
                                    </div>

                                    <div class="col-12 mt-3 d-flex justify-content-center mb-3">
                                        <a href="{{route('Casos.index' )}}" class='btn btn-secondary'> <i class="fas fa-arrow-left"></i> Voltar aos casos</a>
                                    </div>


                                    {{-- Tabela inicio --}}
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped bg-light text-center table-bordered table-hover">
                                            <thead class="text-dark">
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Data</th>
                                                    <th>Importância</th>
                                                    <th>Especialidade</th>
                                                    <th>Resumo</th>
                                                    <th>Qtd. Anexos</th>
                                                    @if( count($ocorrencias) > 0 )
                                                        <th class="text-center" @if( Str::of( Request::path() )->contains( ['trashed-Ocorrencias', 'buscar-Ocorrencias-Trashed'] ) ) colspan="2" @else colspan="3" @endif >Ações</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ocorrencias as $ocorrencia)

                                                    @if ( $ocorrencia->caso_id == $casoId and $ocorrencia->user_id == Auth::user()->id)

                                                        <tr>
                                                            <td style="color: {{$ocorrencia->cor}}" class="font-weight-bold">{{$ocorrencia->tipo}}</td>

                                                            @php
                                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $ocorrencia->data );
                                                                $DataOcorrencia = $date->format('d/m/Y');
                                                            @endphp
                                                            <td>{{ $DataOcorrencia}}</td>

                                                            <td>{{$ocorrencia->importancia}}</td>
                                                            <td>{{$ocorrencia->especialidade}}</td>
                                                            <td>{{$ocorrencia->resumo}}</td>
                                                            <td>{{$ocorrencia->arquivos()->count()}}</td>

                                                            @if(!$ocorrencia->trashed())

                                                                <td>
                                                                    <a href="{{ route( 'Ocorrencias.show', ['caso'=>$casoId,'ocorrencia'=>$ocorrencia->id] ) }}" class="btn btn-xs btn-primary"><i class="fas fa-eye"></i> Visualizar</a>
                                                                </td>

                                                                <td>
                                                                    <a href="{{ route('Ocorrencias.edit', ['caso'=>$casoId,'ocorrencia'=>$ocorrencia->id] ) }}" class="btn btn-xs btn-warning"> <i class="fas fa-edit"></i> Editar</a>
                                                                </td>

                                                                @else
                                                                <td>
                                                                    <form action="{{ route('restore-Ocorrencias.update', ['caso'=>$casoId,'ocorrencia'=>$ocorrencia->id]) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="button" onclick="confirmar('Reativar registro','Você tem certeza?', this.form)" class="btn btn-primary btn-xs float-center ml-1">Reativar</button>
                                                                    </form>
                                                                </td>
                                                            @endif

                                                            <td>
                                                                <form action="{{ route('Ocorrencias.destroy', ['caso'=>$casoId,'ocorrencia'=>$ocorrencia->id] ) }}" class="d-inline" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    @php
                                                                        $acaoDeletar = $ocorrencia->trashed() ? 'Apagar' : 'Mover para Lixeira';
                                                                    @endphp
                                                                    <button type="button" onclick="confirmar('{{ $acaoDeletar }}','Você tem certeza?', this.form)" class="btn btn-danger btn-xs float-center"> <i class="fas fa-trash-alt"></i> {{ $acaoDeletar}} </button>
                                                                </form>
                                                            </td>
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
