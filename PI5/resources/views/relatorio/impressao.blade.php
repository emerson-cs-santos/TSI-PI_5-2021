@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Impressão</div>
                    <h2 class="page-title text-center"> Impressão do Relátorio de Casos e suas Ocorrências</h2>
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

                                    <div class="col-12 mt-1 d-flex justify-content-center mb-3">
                                        <a href="{{ route('relatorio') }}" class='btn btn-secondary'> <i class="fas fa-arrow-left"></i> Voltar</a>
                                    </div>

                                    <div class="col-12 mt-1 d-flex justify-content-center mb-3">
                                        <button onclick="window.print()" class='btn btn-success'> <i class="fas fa-print"></i> Imprimir</button>
                                    </div>

                                    {{-- Dados Pessoais inicio --}}
                                    <div class="mt-3 row text-center">

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <span class="h5">Paciente: {{Auth::user()->name}} </span>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <span class="h5">Genero: {{Auth::user()->genero}}</span>
                                        </div>

                                        @php
                                            $date = DateTime::createFromFormat('Y-m-d H:i:s', Auth::user()->nascimento );
                                            $nascimento = $date->format('d/m/Y');
                                        @endphp

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <span class="h5">Aniversário: {{$nascimento}}</span>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <span class="h5">Idade: {{$idade}}</span>
                                        </div>
                                    </div>
                                    {{-- Dados Pessoais fim --}}


                                    {{-- Casos inicio --}}

                                    @php
                                        $casoAtual = 0;
                                    @endphp

                                    @foreach($registros as $registro)

                                        @if ( $registro->caso_id != $casoAtual )

                                            <div class="mt-5">

                                            </div>

                                            @php
                                                $casoAtual = $registro->caso_id
                                            @endphp

                                            <div class="col-12">
                                                <span class="h3"> Caso: {{$registro->caso}} </span>
                                            </div>

                                            <div class="col-12">
                                                <span class="h5"> Descrição: {{$registro->casoDesc}} </span>
                                            </div>

                                            <div class="col-12">
                                                <span class="h5"> Status: {{$registro->status}} </span>
                                            </div>

                                            <div class="col-12">
                                                <span class="h5"> Medicamentos: {{$registro->medicamentos}} </span>
                                            </div>

                                            <div class="col-12 mt-3">
                                                <span class="h4"> Ocorrencias:</span>
                                            </div>
                                        @endif

                                        {{-- Ocorrencias do Caso inicio --}}

                                            <div class="col-12 mt-3">
                                                <span class="h5"> Tipo: {{$registro->tipo}} </span>
                                            </div>

                                            @php
                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $registro->data );
                                                $DataOcorrencia = $date->format('d/m/Y');
                                            @endphp
                                            <div class="col-12">
                                                <span class="h5"> Data: {{$DataOcorrencia}} </span>
                                            </div>

                                            <div class="col-12">
                                                <span class="h5"> Especialidade: {{$registro->especialidade}} </span>
                                            </div>

                                            <div class="col-12">
                                                <span class="h5"> Receitas: {{$registro->receitas}} </span>
                                            </div>

                                            <div class="col-12">
                                                <span class="h5"> Resumo: {{$registro->resumo}} </span>
                                            </div>

                                        {{-- Ocorrencias do Caso fim --}}

                                    @endforeach
                                    {{-- Casos fim --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
