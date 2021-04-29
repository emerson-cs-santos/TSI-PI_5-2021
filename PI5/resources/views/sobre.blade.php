@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Sobre</div>
                    <h2 class="page-title text-center">Sobre o Site</h2>

                    <div class="d-flex justify-content-center border border-light">
                        <img src="{{asset('site/img/menuLogo_original.png')}}" class="w-25 h-25" alt="Logo do site">
                    </div>

                    @include('exibirAlert')
                </div>
            </div>

            <div class="col-12 mt-2 text-dark">
                <span class="h2">Sistemas para Internet - 5º Semestre</span>
            </div>

            <div class="col-12 mt-2 text-dark">
                <p class="h3"> Projeto Integrador V: Sistema para Internet com recursos de segurança </p>

                <p class="h3"> WebSite com objetivo de controlar casos médicos pela perspectiva do paciente</p>

                <div class="mt-3">
                    <p class="h3 font-weight-bold"> Aluno:</p>
                    <p class="h3"> Emerson Costa Santos </p>
                </div>

                <div class="mt-3">
                    <p class="h3 font-weight-bold"> Contato: </p>
                    <p class="h3"> emersoncs@outlook.com.br </p>
                </div>

            </div>

        </div>
    </section>
@endsection
