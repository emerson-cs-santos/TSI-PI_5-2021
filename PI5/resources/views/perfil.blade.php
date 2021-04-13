@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Perfil</div>
                    <h2 class="page-title text-center">Informações de cadastro</h2>

                    @if ( Auth::user()->premium == 'sim' )
                        <span class="h5 text-success">Usuário Premium</span>
                    @else
                        <span class="h5 text-info">Usuário Regular</span>
                    @endif

                </div>
            </div>

            @include('exibirAlert')

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Informações de perfil @if( empty(Auth::user()->genero) or empty(Auth::user()->nascimento) ) - Complete seu cadastro! @endif </div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{route('perfil-atualizar')}}"  method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" name="name" id="name" placeholder="Nome de usuário" class="form-control @error('password') is-invalid @enderror" value ="{{Auth::user()->name}}" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" placeholder="Seu Email" class="form-control @error('password') is-invalid @enderror" value="{{ Auth::user()->email }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="genero">Gênero</label>
                                    <select name="genero" class="form-control" id="genero">
                                        <option value="Masculino" @if( Auth::user()->genero == 'Masculino') selected @endif >Masculino</option>
                                        <option value="Feminino" @if( Auth::user()->genero == 'Feminino') selected @endif >Feminino</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nascimento" @if( empty(Auth::user()->nascimento) ) class="text-danger" @endif >Data de Aniversário</label>
                                    <input type="date" name="nascimento" id="nascimento" placeholder="Data de Aniversário" class="form-control @error('password') is-invalid @enderror" value ="{{ substr(Auth::user()->nascimento,0,10) }}" required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Atualizar senha</div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{route('perfil-atualizar-senha')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="SenhaAtual">Senha atual</label>
                                    <input type="password" name="SenhaAtual" class="form-control @error('password') is-invalid @enderror" required placeholder="Digite a senha atual">
                                </div>

                                <div class="form-group">
                                    <label for="password">Nova Senha</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Digite a nova senha">
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Senha</label>
                                    <input type="password" class='form-control @error('password') is-invalid @enderror' name="password_confirmation" required placeholder="Digite novamente a nova senha">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Apagar conta Permanentemente</div>
                        <div class="card-body">
                            <h5 class="card-title">Uma vez apagado a conta, não será possivel mais recuperar seus dados.</h5>
                            <form accept-charset="utf-8" action="{{ route('perfil-apagar') }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <div class="form-group">
                                    <button type="button" onclick="confirmar('Apagar conta','Você tem certeza?', this.form)" class="btn btn-danger"> <i class="fas fa-exclamation-triangle"></i> Apagar Conta</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Termos de Uso e Política de Privacidade</div>
                        <div class="card-body">
                            <a href="{{ route('termos') }}" target="_blank" class="btn btn-secondary">Visualizar</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
