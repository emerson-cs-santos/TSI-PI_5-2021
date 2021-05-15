@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Especialidades</div>
                    <h2 class="page-title text-center"> {{ Str::of( Request::path() )->contains( ['trashed-Especialidades', 'buscar-Especialidades-trashed'] ) ? 'Lixeira de Especialidades' : 'Cadastro de Especialidades' }} </h2>
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

                                    @if( !Str::of( Request::path() )->contains( ['trashed-Especialidades', 'buscar-Especialidades-trashed'] ) )
                                        <div class='d-flex mb-2 justify-content-center'>
                                            <a href="{{route('Especialidades.create')}}" class='btn btn-success'> <i class="fas fa-plus"></i> Novo</a>
                                        </div>
                                    @endif

                                    @if( Str::of( Request::path() )->contains( ['trashed-Especialidades', 'buscar-Especialidades-trashed'] ) )
                                        <form action="/buscar-Especialidades-trashed" method="POST" role="search">
                                    @else
                                        <form action="/buscar-Especialidades" method="POST" role="search">
                                    @endif
                                            {{ csrf_field() }}

                                            <div class="row">

                                                <div class="form-group col-sm-12 col-md-3">
                                                    <label for="codigo">Código:</label>
                                                    <input type="number" name="codigo" id="codigo" class="form-control" placeholder="Buscar código"
                                                        @if( isset($codigo_Buscado) )  value="{{$codigo_Buscado}}"  @endif >
                                                </div>

                                                <div class="form-group col-sm-12 col-md-9">
                                                    <label for="nome">Nome:</label>
                                                    <input type="search" name="nome" id="nome" class="form-control" placeholder="Buscar nome"
                                                        @if( isset($nome_Buscado) )  value="{{$nome_Buscado}}"  @endif >
                                                </div>

                                            </div>

                                            <div class="col-sm-12 col-md-12 d-flex justify-content-center mt-1">
                                                <button type="submit" class="btn btn-secondary" data-placement="top" data-toggle="tooltip" title="Fazer busca">
                                                    <span class="fa fa-search" data-placement="top" data-toggle="tooltip" title="Fazer busca"></span>
                                                </button>
                                            </div>

                                        </form>

                                    <div class="col-12 mt-3 d-flex justify-content-center mb-3">
                                        @if( Str::of( Request::path() )->contains( ['trashed-Especialidades', 'buscar-Especialidades-trashed'] ) )
                                            <a href="{{route('Especialidades.index')}}" class='btn btn-info'> <i class="fas fa-arrow-left"></i> Voltar ao cadastro</a>
                                        @else
                                            <a href="{{ route('trashed-Especialidades.index') }}" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" title="Acessar registros excluídos"><i class="fas fa-recycle"></i> Lixeira</a>
                                        @endif
                                    </div>

                                    {{-- Tabela inicio --}}
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped bg-light text-center table-bordered table-hover">
                                            <thead class="text-dark">
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Nome</th>
                                                    <th>Qtd. de Casos (todos usuários)</th>
                                                    @if( count($especialidades) > 0 )
                                                        <th class="text-center" @if( Str::of( Request::path() )->contains( ['trashed-Especialidades', 'buscar-Especialidades-trashed'] ) ) colspan="2" @else colspan="3" @endif >Ações</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($especialidades as $especialidade)
                                                <tr>
                                                    <td>{{$especialidade->id}}</td>
                                                    <td>{{$especialidade->name}}</td>
                                                    <td>{{$especialidade->casos( $especialidade->id )}}</td>

                                                    @if(!$especialidade->trashed())
                                                        <td>
                                                            <a href="{{ route('Especialidades.show', $especialidade->id) }}" class="btn btn-xs btn-primary"><i class="fas fa-eye"></i> Visualizar</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('Especialidades.edit', $especialidade->id) }}" class="btn btn-xs btn-warning"> <i class="fas fa-edit"></i>Editar</a>
                                                        </td>
                                                        @else
                                                        <td>
                                                            <form action="{{ route('restore-Especialidades.update', $especialidade->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="button" onclick="confirmar('Reativar registro','Você tem certeza?', this.form)" class="btn btn-primary btn-xs float-center ml-1">Reativar</button>
                                                            </form>
                                                        </td>
                                                    @endif

                                                    <td>
                                                        <form action="{{ route('Especialidades.destroy', $especialidade->id) }}" class="d-inline" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            @php
                                                                $acaoDeletar = $especialidade->trashed() ? 'Apagar' : 'Mover para Lixeira';
                                                            @endphp
                                                            <button type="button" onclick="confirmar('{{ $acaoDeletar }}','Você tem certeza?', this.form)" class="btn btn-danger btn-xs float-center"> <i class="fas fa-trash-alt"></i> {{ $acaoDeletar}} </button>
                                                        </form>
                                                    </td>
                                                </tr>
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
