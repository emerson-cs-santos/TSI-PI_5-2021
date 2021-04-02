@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Home</div>
                    <h2 class="page-title text-center">Controle sua Saúde!</h2>

                    <div class="d-flex justify-content-center border border-light">
                        <img src="{{asset('site/img/menuLogo_original.png')}}" class="w-25 h-25" alt="Logo do site">
                    </div>

                    @include('exibirAlert')

                    <p class="mt-3 h5">Cansado de não sentir que está progredindo em um problema médico? </p>
                    <p>Isso pode estar ocorrendo por não estar juntando todas as informações que cada médico descobre. O Correto seria os próprios médicos passarem essas informações entre si, mas isso quase sempre não é possível, ainda mais trocando de clinicas atendidas pelo convenio ou mesmo pelo SUS.</p>
                    <p>Aqui é possível fazer total controle não só seu, mas de pessoas que estão sob seus cuidados.</p>

                    <p class="mt-2 h4 text-center"> @if( !empty(Auth::user()->name)  ) Olá {{Auth::user()->name}}, controle @else Controle @endif sua saúde agora mesmo: </p>
                </div>
            </div>

            @if( empty(Auth::user()->name)  )

                <div class="container">
                    <div class="row">

                        <div class="col-sm-12 col-md-6">
                            <div class="card">
                                <div class="content">
                                    <div class="dfd text-center">
                                        <a href="{{ route('register') }}" data-placement="top" data-toggle="tooltip" title="Clique para criar seu cadastro!"> <i class="blue large-icon mb-2 fas fa-user-plus"></i> </a>
                                        <a href="{{ route('register') }}" class="h4" data-placement="top" data-toggle="tooltip" title="Clique para criar seu cadastro!"> <p class="h4">Criar Cadastro</p> </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="card">
                                <div class="content">
                                    <div class="dfd text-center">
                                        <a href="{{ route('login') }}" data-placement="top" data-toggle="tooltip" title="Clique aqui para acessar o sistema"> <i class="blue large-icon mb-2 fas fa-sign-in-alt"></i> </a>
                                        <a href="{{ route('login') }}" class="h4" data-placement="top" data-toggle="tooltip" title="Clique aqui para acessar o sistema"> <p class="h4">Fazer login</p> </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @else

                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center border border-light">
                            <div class="card">
                                <div class="content">
                                    <div class="dfd text-center">
                                        <a href="{{route('Casos.index')}}" data-placement="top" data-toggle="tooltip" title="Clique para criar seu cadastro!"> <i class="blue large-icon mb-2 fas fa-file-medical-alt"></i> </a>
                                        <a href="{{route('Casos.index')}}" class="h4" data-placement="top" data-toggle="tooltip" title="Clique para criar seu cadastro!"> <p class="h4">Acessar meus casos</p> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif

            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4 mt-3">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="icon-big text-center">
                                        <i class="teal fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="detail text-center">
                                        <p class="detail-subtitle">Usuários</p>
                                        <span class="number">6.267</span>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="stats">
                                    <i class="fas fa-heartbeat"></i> Pessoas que levam a sério sua saúde!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4 mt-3">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="icon-big text-center">
                                        <i class="violet fas fa-laptop-medical"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="detail text-center">
                                        <p class="detail-subtitle">Casos resolvidos</p>
                                        <span class="number">28.210</span>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="stats">
                                    <i class="fas fa-smile-wink"></i> Menos problemas na vida!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4 mt-3">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="icon-big text-center">
                                        <i class="olive fas fa-credit-card"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="detail text-center">
                                        <p class="detail-subtitle">Assinantes</p>
                                        <span class="number">4.250</span>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="stats">
                                    <i class="fas fa-unlock-alt"></i> Acesso a todos os recursos do site!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="dfd text-center">
                                    <i class="blue large-icon mb-2 fas fa-thumbs-up"></i>
                                    <h4 class="mb-0"> <a href="https://www.facebook.com/pages/Super-Potato-Akihabara/169636663054466">Facebook</a></h4>
                                    <p class="text-muted">Curta nossa página no Facebook</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="dfd text-center">
                                    <i class="orange large-icon mb-2 fas fa-reply-all"></i>
                                    <h4 class="mb-0"> <a href="https://www.instagram.com/explore/locations/214069665/super-potato-akihabara/">@controlesaude</a></h4>
                                    <p class="text-muted">Nos siga no Instagram</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="dfd text-center">
                                    <i class="grey large-icon mb-2 fas fa-envelope"></i>
                                    <h4 class="mb-0">Dúvidas?</h4>
                                    <p class="text-muted">controlesaude@senac.com.br</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
