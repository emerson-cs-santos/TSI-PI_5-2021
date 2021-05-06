@extends('layouts.site')

@section('content_site')
    <section class="content mt-3" id="impressao">
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

                                    <div class="col-12 mt-1 d-flex justify-content-center mb-3 form-group">
                                        <button onclick="window.print()" class='btn btn-success'> <i class="fas fa-print"></i> Imprimir</button>
                                    </div>

                                    <div class="col-12 mt-1 d-flex justify-content-center mb-3">
                                        {{-- <form action="/relatorio-email" method="POST" role="search"> --}}
                                        <form action="{{ route('relatorio.email') }}" method="POST">
                                            {{ csrf_field() }}

                                            @php
                                                $registrosEmail = $registros->toJson();
                                            @endphp

                                            <input type="text" name="registros" id='registros' value="{{$registrosEmail}}" hidden>

                                            <div class="text-center col-12 form-group">
                                                <label for="email">Enviar esse relatório por e-mail para seu médico</label>
                                                <input type="email" class="form-control" name="email" id="email" required data-placement="top" placeholder="nome@server.com.br" data-toggle="tooltip" title="Você pode usar essa opção para enviar esse relatório para seu médico">
                                            </div>

                                            <div class="col-12 d-flex justify-content-center mt-2">
                                                <button type="submit" class="btn btn-primary float-center" data-placement="top" data-toggle="tooltip" title="Você pode usar essa opção para enviar esse relatório para seu médico">
                                                    <span class="fas fa-paperclip"></span> Enviar por e-mail
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Dados Pessoais inicio --}}
                                    <div class="mt-3 row text-center border border-dark rounded">

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <span class="h5">Paciente: {{Auth::user()->name}} </span>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-3">
                                            <span class="h5">Genero: {{Auth::user()->genero}}</span>
                                        </div>

                                        @php
                                            $nascimento = 'Não informado';

                                            if ( !empty(Auth::user()->nascimento) )
                                            {
                                                $nacimento = Auth::user()->nascimento;
                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $nacimento );
                                                $nascimento = $date->format('d/m/Y');
                                            }
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

                                            <div class="mt-1 mb-5">

                                            </div>

                                            @php
                                                $casoAtual = $registro->caso_id
                                            @endphp

                                            <div class="border border-info rounded ">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <span class="h3 font-weight-bold">Caso:</span>
                                                        </div>

                                                        <div class="col-md-10">
                                                            <span class="h3" > {{$registro->caso}} </span>
                                                        </div>
                                                    </div>
                                                    {{-- <span class="h3"> <strong>Caso:</strong> {{$registro->caso}} </span> --}}
                                                </div>

                                                <div class="col-12 mt-2 text">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <span class="h5 font-weight-bold">Descrição:</span>
                                                        </div>

                                                        <div class="col-md-10">
                                                            <span class="h5" > {{$registro->casoDesc}} </span>
                                                        </div>
                                                    </div>
                                                    {{-- <span class="h5"> <strong>Descrição:</strong> {{$registro->casoDesc}} </span> --}}
                                                </div>

                                                @php
                                                    $corStatus = "text-dark";

                                                    if( $registro->status == 'Em investigação' )
                                                    {
                                                        $corStatus = "text-danger";
                                                    }

                                                    if( $registro->status == 'Doença controlada' )
                                                    {
                                                        $corStatus = "text-warning";
                                                    }

                                                    if( $registro->status == 'Curado' )
                                                    {
                                                        $corStatus = "text-success";
                                                    }
                                                @endphp

                                                <div class="col-12 mt-2">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <span class="h5 font-weight-bold">Status:</span>
                                                        </div>

                                                        <div class="col-md-10">
                                                            <span class="h5 {{$corStatus}} font-weight-bold" > {{$registro->status}} </span>
                                                        </div>
                                                    </div>
                                                    {{-- <span class="h5"> <strong>Status:</strong> <span class="{{$corStatus}} font-weight-bold" > {{$registro->status}} </span>   </span> --}}
                                                </div>

                                                <div class="col-12 mt-2">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <span class="h5">Medicamentos:</span>
                                                        </div>

                                                        <div class="col-md-10">
                                                            <span class="h5" > {{$registro->medicamentos}} </span>
                                                        </div>
                                                    </div>
                                                    {{-- <span class="h5"> <strong>Medicamentos:</strong> {{$registro->medicamentos}} </span> --}}
                                                </div>
                                            </div>

                                            <div class="col-12 mt-3">
                                                <span class="h4 font-weight-bold"> Ocorrencias: </span>
                                            </div>
                                        @endif

                                        {{-- Ocorrencias do Caso inicio --}}

                                        <div class="border border-dark rounded mb-3">
                                            <div class="col-12 mt-3">
                                                <span class="h5"> <strong> Tipo:</strong> <span style="color: {{$registro->cor}};" class="font-weight-bold">{{$registro->tipo}}</span> </span>
                                            </div>

                                            @php
                                                $corImportancia = "text-dark";

                                                if( $registro->importancia == 'Importante' )
                                                {
                                                    $corImportancia = "text-warning";
                                                }

                                                if( $registro->importancia == 'Rotina' )
                                                {
                                                    $corImportancia = "text-primary";
                                                }
                                            @endphp

                                            <div class="col-12 mt-3">
                                                <span class="h5"> <strong> Relevância:</strong> <span class="{{$corImportancia}} font-weight-bold"> {{$registro->importancia}} </span> </span>
                                            </div>

                                            @php
                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $registro->data );
                                                $DataOcorrencia = $date->format('d/m/Y');
                                            @endphp
                                            <div class="col-12 mt-2">
                                                <span class="h5"> <strong> Data:</strong>  {{$DataOcorrencia}} </span>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <span class="h5"> <strong> Especialidade:</strong>  {{$registro->especialidade}} </span>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <span class="h5"> <strong> Receitas:</strong>  {{$registro->receitas}} </span>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <span class="h5"> <strong> Resumo:</strong>  {{$registro->resumo}} </span>
                                            </div>
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
