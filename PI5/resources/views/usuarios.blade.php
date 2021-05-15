@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Usuários</div>
                    <h2 class="page-title text-center"> {{ Str::of( Request::path() )->contains( ['trashed-Users', 'buscar-Users-trashed'] ) ? 'Lixeira de Usuários' : 'Cadastro de Usuários' }} </h2>
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

                                    @if( Str::of( Request::path() )->contains( ['trashed-Users', 'buscar-Users-trashed'] ) )
                                        <form action="/buscar-Users-trashed" method="POST" role="search">
                                    @else
                                        <form action="/buscar-Users" method="POST" role="search">
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

                                            <div class="row">

                                                <div class="form-group col-sm-12 col-md-6">
                                                    <label for="nivel">Nível:</label>
                                                    <select name="nivel" class="form-control" id="nivel" >
                                                        <option value="padrao" @if ( $nivel_Buscado == 'padrao' ) selected @endif >Padrão</option>
                                                        <option value="adm" @if ( $nivel_Buscado == 'adm' ) selected @endif >Administrador</option>
                                                        <option value="todos" @if ( $nivel_Buscado == 'todos' ) selected @endif >Todos</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-12 col-md-6">
                                                    <label for="premium">Premium:</label>
                                                    <select name="premium" class="form-control" id="premium" >
                                                        <option value="Sim" @if ( $premium_Buscado == 'Sim' ) selected @endif >Sim</option>
                                                        <option value="Não" @if ( $premium_Buscado == 'Não' ) selected @endif >Não</option>
                                                        <option value="todos" @if ( $premium_Buscado == 'todos' ) selected @endif >Todos</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="form-group col-sm-12 col-md-12">
                                                    <label for="email">E-mail:</label>
                                                    <input type="search" name="email" id="email" class="form-control" placeholder="Buscar e-mail"
                                                        @if( isset($email_Buscado) )  value="{{$email_Buscado}}"  @endif >
                                                </div>

                                            </div>

                                            <div class="col-sm-12 col-md-12 d-flex justify-content-center mt-1">
                                                <button type="submit" class="btn btn-secondary" data-placement="top" data-toggle="tooltip" title="Fazer busca">
                                                    <span class="fa fa-search" data-placement="top" data-toggle="tooltip" title="Fazer busca"></span>
                                                </button>
                                            </div>

                                        </form>

                                        <div class="col-12 mt-3 d-flex justify-content-center mb-3">
                                            @if( Str::of( Request::path() )->contains( ['trashed-Users', 'buscar-Users-trashed'] ) )
                                                <a href="{{route('Users.index')}}" class='btn btn-info'> <i class="fas fa-arrow-left"></i> Voltar ao cadastro</a>
                                            @else
                                                <a href="{{ route('trashed-Users.index') }}" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" title="Acessar registros excluídos"><i class="fas fa-recycle"></i> Lixeira</a>
                                            @endif
                                        </div>


                                    {{-- Tabela inicio --}}
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped bg-light text-center table-bordered table-hover">
                                            <thead class="text-dark">
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Nome</th>
                                                    <th>E-mail</th>
                                                    <th>Nível</th>
                                                    <th>Premium</th>
                                                    <th>Qtd. Casos</th>
                                                    @if( count($usuarios) > 0 )
                                                        <th class="text-center" colspan="2"  >Ações</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($usuarios as $usuario)
                                                <tr>
                                                    <td>{{$usuario->id}}</td>
                                                    <td>{{$usuario->name}}</td>
                                                    <td>{{$usuario->email}}</td>
                                                    <td>{{$usuario->type == 'admin' ? 'Administrador' : 'Padrão'  }}</td>
                                                    <td>{{$usuario->premium == 'sim' ? ' Sim' : 'Não' }}</td>
                                                    <td>{{$usuario->casos()->count()}}</td>

                                                    @if(!$usuario->trashed())

                                                        @php
                                                            $mudancaDescricao = '';

                                                            if ( $usuario->type == 'admin' )
                                                            {
                                                                $mudancaDescricao = 'Administrador -> Padrão';
                                                            }
                                                            else
                                                            {
                                                                $mudancaDescricao = 'Padrão -> Administrador';
                                                            }
                                                        @endphp

                                                        <td>
                                                            <form action="{{ route('perfil-type', $usuario->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="button" onclick="confirmar('Alterar Nível de acesso','{{$mudancaDescricao}}', this.form)" class="btn btn-xs btn-warning"> <i class="fas fa-users-cog"></i> Alterar Nível</button>
                                                            </form>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <form action="{{ route('restore-Users.update', $usuario->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="button" onclick="confirmar('Reativar registro','Você tem certeza?', this.form)" class="btn btn-primary btn-xs float-center ml-1"> <i class="fas fa-trash-restore"></i> Reativar</button>
                                                            </form>
                                                        </td>
                                                    @endif

                                                    <td>
                                                        <form action="{{ route('Users.destroy', $usuario->id) }}" class="d-inline" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            @php
                                                                $acaoDeletar = $usuario->trashed() ? 'Apagar' : 'Mover para Lixeira';
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
