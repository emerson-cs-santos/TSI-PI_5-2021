@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Visualizar</div>
                    <h2 class="page-title text-center">Ver Ocorrência</h2>
                </div>
            </div>

            @include('exibirAlert')

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Ocorrência</div>
                        <div class="card-body">

                            <div class="box box-primary">
                                <div class="box-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                                        <li class="nav-item">
                                            <a class="nav-link active" id="geral-tab" data-toggle="tab" href="#geral" role="tab" aria-controls="geral" aria-selected="true">Geral</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="detalhes-tab" data-toggle="tab" href="#detalhes" role="tab" aria-controls="detalhes" aria-selected="false">Detalhes</a>
                                        </li>

                                    </ul>

                                    <div class="tab-content" id="myTabContent">

                                        <div class="tab-pane fade active show" id="geral" role="tabpanel" aria-labelledby="geral-tab">
                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <label for="tipo">Tipo*</label>
                                                    <select name="tipo" class="form-control" id="tipo" >
                                                        <option value="Consulta"        @if( $ocorrencia->tipo == 'Consulta')         selected @endif >Consulta</option>
                                                        <option value="Exame"           @if( $ocorrencia->tipo == 'Exame')            selected @endif >Exame</option>
                                                        <option value="Pronto socorro"  @if( $ocorrencia->tipo == 'Pronto socorro')   selected @endif >Pronto socorro</option>
                                                        <option value="Cirurgia"        @if( $ocorrencia->tipo == 'CuraCirurgiado')   selected @endif >Cirurgia</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="data">Data da ocorrência*</label>
                                                    <input type="date" name="data" id="data" placeholder="Data da ocorrência" class="form-control" value ="{{ substr( $ocorrencia->data ,0,10) }}" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="especialidade_id">Especialidade*:</label>
                                                    <select name="especialidade_id" class="form-control" id="especialidade_id" >
                                                        @foreach($especialidades as $especialidade)
                                                            <option value="{{$especialidade->id}}" @if( $ocorrencia->especialidade_id == $especialidade->id ) selected @endif >{{$especialidade->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="importancia">Relevância*</label>
                                                    <select name="importancia" class="form-control" id="importancia" >
                                                        <option value="Importante"  @if( $ocorrencia->importancia == 'Importante')    selected @endif >Importante</option>
                                                        <option value="Rotina"      @if( $ocorrencia->importancia == 'Rotina')        selected @endif >Rotina</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="resumo">Resumo*</label>
                                                    <textarea name="resumo" class='form-control' id="resumo" required rows=4 placeholder="Digite um resumo do que ocorreu">{{ $ocorrencia->resumo }}</textarea>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="detalhes" role="tabpanel" aria-labelledby="detalhes-tab">

                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <label for="local">Local</label>
                                                    <textarea name="local" class='form-control' id="local" rows=2 placeholder="Digite o local que ocorreu (clínica, hospital)">{{ $ocorrencia->local }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="medico">Médico</label>
                                                    <textarea name="medico" class='form-control' id="medico" rows=2 placeholder="Digite o nome do médico ou profissional">{{ $ocorrencia->medico }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="crm">CRM</label>
                                                    <textarea name="crm" class='form-control' id="crm" rows=1 placeholder="Digite o crm do médico/profissional">{{ $ocorrencia->crm }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="receitas">Receitas</label>
                                                    <textarea name="receitas" class='form-control' id="receitas" rows=3 placeholder="Digite as receitas obtidas">{{ $ocorrencia->receitas }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="desc">Detalhes</label>
                                                    <textarea name="desc" class='form-control' id="desc" rows=5 placeholder="Digite os detalhes do que ocorreu">{{ $ocorrencia->desc }}</textarea>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                @php
                                    if ( $ocorrencia->updated_at == null )
                                    {
                                        $DataAlteracao = 'Sem data';
                                    }
                                    else
                                    {
                                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $ocorrencia->updated_at );
                                        $DataAlteracao = $date->format('d/m/Y');
                                    }
                                @endphp

                                <div>
                                    <span>Última Alteração:</span>
                                </div>
                                <input type="text" value="{{ $DataAlteracao }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <a href="{{ route('Ocorrencias.index', $casoId) }}" class='btn btn-primary'> <i class="fas fa-arrow-left"></i> Voltar</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
