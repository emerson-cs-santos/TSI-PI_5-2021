@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Incluir</div>
                    <h2 class="page-title text-center">Nova Especialidade</h2>
                </div>
            </div>

            @include('exibirAlert')

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Especialidade</div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{route('Especialidades.store')}}"  method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Nome*</label>
                                    <input type="text" class='form-control' name="name" id="name" autofocus required placeholder="Digite o nome da especialidade" value="{{old('name')}}">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"> <i class="fas fa-save"></i> Salvar</button>
                                    <a href="{{route('Especialidades.index')}}" class='btn btn-primary'> <i class="fas fa-arrow-left"></i> Voltar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
