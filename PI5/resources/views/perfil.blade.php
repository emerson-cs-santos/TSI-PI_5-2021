@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Perfil</div>
                    <h2 class="page-title text-center">Informações de cadastro</h2>
                </div>
            </div>

            @include('exibirAlert')

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Informações de perfil</div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{route('teste')}}" method="get" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" name="name" placeholder="Nome de usuário" class="form-control" value ="{{Auth::user()->name}}" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" placeholder="Seu Email" class="form-control" value="{{ Auth::user()->email }}" required>
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Salvar">
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
                            <form accept-charset="utf-8">

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Salvar">
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
                            <form accept-charset="utf-8">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-danger" value="Apagar Conta">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
