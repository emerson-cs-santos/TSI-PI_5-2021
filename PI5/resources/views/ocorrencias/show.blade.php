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

                                        <li class="nav-item">
                                            <a class="nav-link" id="anexo-tab" data-toggle="tab" href="#anexo" role="tab" aria-controls="anexo" aria-selected="false">Anexar arquivos</a>
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
                                                    <input type="date" name="data" id="data" class="form-control" value ="{{ substr( $ocorrencia->data ,0,10) }}" required>
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
                                                    @php
                                                        $local = '';

                                                        if ( $ocorrencia->local !== ' ' )
                                                        {
                                                            $local = $ocorrencia->local;
                                                        }
                                                    @endphp
                                                    <label for="local">Local</label>
                                                    <textarea name="local" class='form-control' id="local" rows=2 placeholder="Digite o local que ocorreu (clínica, hospital)">{{ $local }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    @php
                                                        $medico = '';

                                                        if ( $ocorrencia->medico !== ' ' )
                                                        {
                                                            $medico = $ocorrencia->medico;
                                                        }
                                                    @endphp
                                                    <label for="medico">Médico</label>
                                                    <textarea name="medico" class='form-control' id="medico" rows=2 placeholder="Digite o nome do médico ou profissional">{{ $medico }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    @php
                                                        $crm = '';

                                                        if ( $ocorrencia->crm !== ' ' )
                                                        {
                                                            $crm = $ocorrencia->crm;
                                                        }
                                                    @endphp
                                                    <label for="crm">CRM</label>
                                                    <textarea name="crm" class='form-control' id="crm" rows=1 placeholder="Digite o crm do médico/profissional">{{ $crm }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    @php
                                                        $receitas = '';

                                                        if ( $ocorrencia->receitas  !== ' ' )
                                                        {
                                                            $receitas = $ocorrencia->receitas ;
                                                        }
                                                    @endphp
                                                    <label for="receitas">Receitas</label>
                                                    <textarea name="receitas" class='form-control' id="receitas" rows=3 placeholder="Digite as receitas obtidas">{{ $receitas }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    @php
                                                        $desc = '';

                                                        if ( $ocorrencia->desc !== ' ' )
                                                        {
                                                            $desc = $ocorrencia->desc;
                                                        }
                                                    @endphp
                                                    <label for="desc">Detalhes</label>
                                                    <textarea name="desc" class='form-control' id="desc" rows=5 placeholder="Digite os detalhes do que ocorreu">{{ $desc }}</textarea>
                                                </div>

                                            </div>

                                        </div>



                                        <div class="tab-pane fade" id="anexo" role="tabpanel" aria-labelledby="anexo-tab">

                                            <div class="col-md-12">
                                                <span class="h5">Neste local é possivel visualizar seus exames, receitas etc, arquivos referente a ocorrência.</span>

                                                <div class="form-group mt-1">
                                                    <span class="font-weight-bold">Arquivos da Ocorrência</span>
                                                    <div>
                                                        <a href="{{ route('Ocorrencias.getfileTodos', ['caso'=>$casoId,'ocorrencia'=>$ocorrencia->id ] ) }}" class="btn btn-info"> <i class="fas fa-download"></i> Baixar todos os arquivos</a>
                                                    </div>

                                                    {{-- Tabela inicio --}}
                                                    <div class="table-responsive mt-3">
                                                        <table class="table table-striped bg-light text-center table-bordered table-hover">
                                                            <thead class="text-dark">
                                                                <tr>
                                                                    <th>Nome</th>
                                                                    <th>Extensão</th>
                                                                    <th class="text-center" >Ação</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($arquivos as $arquivo)
                                                                <tr>
                                                                    <td>{{$arquivo->nome}}</td>
                                                                    <td>{{$arquivo->extensao}}</td>

                                                                    <td>
                                                                        <a href="{{ route('Ocorrencias.getfile', ['caso'=>$casoId,'ocorrencia'=>$ocorrencia->id,'nomearquivo'=>$arquivo->nome] ) }}" class="btn btn-xs btn-info"> <i class="fas fa-file-download"></i> Baixar</a>
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
