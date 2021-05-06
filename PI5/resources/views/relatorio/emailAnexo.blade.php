<div class="container">

    <div class="row">
        <div class="col-md-12 page-header">
            <div class="page-pretitle">Impressão</div>
            <h2 class="page-title text-center"> Impressão do Relátorio de Casos e suas Ocorrências</h2>
        </div>
    </div>

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 ml-auto">
                <div class="row align-items-center">

                    {{-- Conteiner final onde as informações são de fato exibidas --}}
                    <div class="container">
                        <div class="col-12">

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

                            {{-- Casos inicio --}}

                            @php
                                $casoAtual = 0;
                            @endphp

                            <div style="margin-top: 10px">

                            </div>

                        @foreach($registros as $registro)

                            @if ( $registro->caso_id != $casoAtual )

                                <div style="margin-top: 10px margin-bottom: 20px">

                                </div>

                                @php
                                    $casoAtual = $registro->caso_id
                                @endphp

                                <div class="border border-info rounded ">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span style="font-size: large;"><strong> Caso:</strong> <span> {{$registro->caso}} </span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-2 text">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span> <strong> Descrição:</strong> <span> {{$registro->casoDesc}} </span> </span>
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $corStatus = "Black";

                                        if( $registro->status == 'Em investigação' )
                                        {
                                            $corStatus = "red";
                                        }

                                        if( $registro->status == 'Doença controlada' )
                                        {
                                            $corStatus = "GoldenRod";
                                        }

                                        if( $registro->status == 'Curado' )
                                        {
                                            $corStatus = "ForestGreen";
                                        }

                                    @endphp

                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span> <strong> Status:</strong> <span style="color: {{$corStatus}};" > {{$registro->status}} </span> </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span> <strong> Medicamentos:</strong> <span> {{$registro->medicamentos}} </span> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="margin-top: 20px">
                                    <span> <strong> Ocorrências:</strong> </span>
                                </div>
                            @endif

                            <div style="margin-top: 10px">

                            </div>

                            {{-- Ocorrencias do Caso inicio --}}

                            <div class="border border-dark rounded mb-3">
                                <div class="col-12 mt-3">
                                    <span> <strong> Tipo:</strong> <span style="color: {{$registro->cor}};">{{$registro->tipo}}</span> </span>
                                </div>

                                @php
                                    $corImportancia = "text-dark";

                                    if( $registro->importancia == 'Importante' )
                                    {
                                        $corImportancia = "GoldenRod";
                                    }

                                    if( $registro->importancia == 'Rotina' )
                                    {
                                        $corImportancia = "MediumBlue";
                                    }

                                @endphp

                                <div class="col-12 mt-3">
                                    <span class="h5"> <strong> Relevância:</strong> <span style="color: {{$corImportancia}};"> {{$registro->importancia}} </span> </span>
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
