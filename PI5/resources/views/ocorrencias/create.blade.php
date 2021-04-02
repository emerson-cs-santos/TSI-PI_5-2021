@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Incluir</div>
                    <h2 class="page-title text-center">Nova Ocorrência</h2>
                </div>
            </div>

            @include('exibirAlert')

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Incluir Nova Ocorrência</div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{route('Casos.store', $casoId )}}"  method="post" enctype="multipart/form-data">
                                @csrf

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
                                                            <option value="Consulta"        @if( old('tipo') == 'Consulta')         selected @endif >Consulta</option>
                                                            <option value="Exame"           @if( old('tipo') == 'Exame')            selected @endif >Exame</option>
                                                            <option value="Pronto socorro"  @if( old('tipo') == 'Pronto socorro')   selected @endif >Pronto socorro</option>
                                                            <option value="Cirurgia"        @if( old('tipo') == 'CuraCirurgiado')   selected @endif >Cirurgia</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="data">Data da ocorrência*</label>
                                                        <input type="date" name="data" id="data" placeholder="Data da ocorrência" class="form-control" value ="{{ substr( old('tipo') ,0,10) }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="especialidade_id">Especialidade*:</label>
                                                        <select name="especialidade_id" class="form-control" id="especialidade_id" >
                                                            @foreach($especialidades as $especialidade)
                                                                <option value="{{$especialidade->id}}" @if( old('especialidade_id') == $especialidade->id ) selected @endif >{{$especialidade->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="detalhes" role="tabpanel" aria-labelledby="detalhes-tab">

                                                <div class="col-md-12">

                                                    <div class="form-group">
                                                        <label for="medico">Médico</label>
                                                        <textarea name="medico" class='form-control' id="medico" rows=2 placeholder="Digite o nome do médico ou profissional">{{old('medico')}}</textarea>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"> <i class="fas fa-save"></i> Salvar</button>
                                    <a href="{{ url()->previous() }}" class='btn btn-primary'> <i class="fas fa-arrow-left"></i> Voltar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
