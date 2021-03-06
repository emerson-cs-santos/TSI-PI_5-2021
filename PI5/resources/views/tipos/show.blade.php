@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Visualizar</div>
                    <h2 class="page-title text-center">Ver Tipo</h2>
                </div>
            </div>

            @include('exibirAlert')

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Tipo</div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input type="text" class='form-control' name="name" id="name" autofocus required placeholder="Digite o nome do tipo" value="{{$tipo->name}}">
                            </div>

                            <div class="form-group">
                                <label for="color">Cor</label>
                                <input type="color" class='form-control' name="color" id="color" value="{{$tipo->color}}" data-placement="top" data-toggle="tooltip" title="Cor será utilizada nas ocorrências e na impressão do relatório">
                            </div>

                            <div class="form-group">
                                @php
                                    if ( $tipo->updated_at == null )
                                    {
                                        $DataAlteracao = 'Sem data';
                                    }
                                    else
                                    {
                                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $tipo->updated_at );
                                        $DataAlteracao = $date->format('d/m/Y');
                                    }
                                @endphp

                                <div>
                                    <span>Última Alteração:</span>
                                </div>
                                <input type="text" value="{{ $DataAlteracao }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <a href="{{route('Tipos.index')}}" class='btn btn-primary'> <i class="fas fa-arrow-left"></i> Voltar</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
