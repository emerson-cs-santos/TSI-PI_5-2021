@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Casos</div>
                    <h2 class="page-title text-center"> {{ Request::path() == 'trashed-Casos' ? 'Lixeira de Casos Médicos' : 'Casos Médicos' }} </h2>
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

                                    @if( Request::path() !== 'trashed-Casos' )
                                        <div class='d-flex mb-2 justify-content-center'>
                                            <a href="{{route('Casos.create')}}" class='btn btn-success'> <i class="fas fa-plus"></i> Novo</a>
                                        </div>
                                    @endif

                                    @if( Request::path() !== 'trashed-Casos')
                                        <form action="/buscar-Casos" method="POST" role="search">
                                        {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-11 mt-2">
                                                    <input type="search" name="busca" class="form-control" placeholder="O que está buscando?"
                                                        @if( isset($busca) )  value="{{$busca}}"  @endif >
                                                </div>

                                                <div class="col-12 col-sm-12 col-md-1 mt-2">
                                                    <button type="submit" class="btn btn-secondary" data-placement="top" data-toggle="tooltip" title="Fazer busca">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif

                                    {{-- Tabela inicio --}}
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped bg-light text-center table-bordered table-hover">
                                            <thead class="text-dark">
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Status</th>
                                                    <th>Qtd. Ocorrências</th>
                                                    @if( count($casos) > 0 )
                                                        <th class="text-center" @if( Request::path() == 'trashed-Casos' ) colspan="2" @else colspan="4" @endif >Ações</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($casos as $caso)
                                                <tr>
                                                    <td>{{$caso->nome}}</td>
                                                    <td>{{$caso->status}}</td>
                                                    <td>{{$caso->ocorrencias()->count()}}</td>

                                                    @if(!$caso->trashed())

                                                        <td>
                                                            <a href="{{ route('Casos.show', $caso->id) }}" class="btn btn-xs btn-primary"><i class="fas fa-eye"></i> Visualizar</a>
                                                        </td>

                                                        <td>
                                                            <a href="{{ route('Casos.edit', $caso->id) }}" class="btn btn-xs btn-warning"> <i class="fas fa-edit"></i> Editar</a>
                                                        </td>

                                                        <td>
                                                            <a href="{{ route('Ocorrencias.index', $caso->id) }}" class="btn btn-xs btn-secondary"> <i class="fas fa-file-medical"></i> Ocorrencias</a>
                                                        </td>

                                                        @else
                                                        <td>
                                                            <form action="{{ route('restore-Casos.update', $caso->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="button" onclick="confirmar('Reativar registro','Você tem certeza?', this.form)" class="btn btn-primary btn-xs float-center ml-1">Reativar</button>
                                                            </form>
                                                        </td>
                                                    @endif

                                                    <td>
                                                        <form action="{{ route('Casos.destroy', $caso->id) }}" class="d-inline" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            @php
                                                                $acaoDeletar = $caso->trashed() ? 'Apagar' : 'Mover para Lixeira';
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

                                    <!---Pagination-->
                                    <div class="pagination justify-content-center mt-3">

                                        @if ($casos->hasPages())
                                            <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
                                                {{-- Previous Page Link --}}
                                                @if ($casos->onFirstPage())
                                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                                        {!! __('pagination.previous') !!}
                                                    </span>
                                                @else
                                                    <a href="{{ $casos->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                                        {!! __('pagination.previous') !!}
                                                    </a>
                                                @endif

                                                {{-- Next Page Link --}}
                                                @if ($casos->hasMorePages())
                                                    <a href="{{ $casos->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                                        {!! __('pagination.next') !!}
                                                    </a>
                                                @else
                                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                                        {!! __('pagination.next') !!}
                                                    </span>
                                                @endif
                                            </nav>
                                        @endif

                                    </div>
                                    <!---End of Pagination-->

                                    <div class="col-12 mt-3 d-flex justify-content-center mb-3">
                                        @if( Request::path() == 'trashed-Casos' )
                                            <a href="{{route('Casos.index')}}" class='btn btn-info'> <i class="fas fa-arrow-left"></i> Voltar ao cadastro</a>
                                        @else
                                            <a href="{{ route('trashed-Casos.index') }}" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" title="Acessar registros excluídos"><i class="fas fa-recycle"></i> Lixeira</a>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
