@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Incluir</div>
                    <h2 class="page-title text-center">Novo Tipo</h2>
                </div>
            </div>

            @include('exibirAlert')

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Tipo</div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{route('Tipos.store')}}"  method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Nome*</label>
                                    <input type="text" class='form-control' name="name" id="name" autofocus required placeholder="Digite o nome do Tipo" value="{{old('name')}}">
                                </div>

                                <div class="form-group">
                                    <label for="color">Cor*</label>
                                    <input type="color" class='form-control' name="color" id="color" value="{{old('color')}}" data-placement="top" data-toggle="tooltip" title="Cor será utilizada nas ocorrências e na impressão do relatório">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"> <i class="fas fa-save"></i> Salvar</button>
                                    <a href="{{route('Tipos.index')}}" class='btn btn-primary'> <i class="fas fa-arrow-left"></i> Voltar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
