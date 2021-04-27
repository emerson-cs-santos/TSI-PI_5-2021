@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Incluir</div>
                    <h2 class="page-title text-center">Novo Caso Médico</h2>
                </div>
            </div>

            @include('exibirAlert')

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Caso Médico</div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{route('Casos.store')}}"  method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="nome">Nome*</label>
                                    <input type="text" class='form-control' name="nome" id="nome" autofocus required placeholder="Digite o nome do Caso" value="{{old('nome')}}">
                                </div>

                                <div class="form-group">
                                    <label for="descricao">Descrição*</label>
                                    <textarea name="descricao" class='form-control' id="descricao" required rows=10 placeholder="Digite uma descrição para o caso">{{old('descricao')}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status*</label>
                                    <select name="status" class="form-control" id="status" >
                                        <option value="Em investigação" @if( old('status') == 'Em investigação') selected @endif >Em investigação</option>
                                        <option value="Doença controlada" @if( old('status') == 'Doença controlada') selected @endif >Doença controlada com remédio contínuo</option>
                                        <option value="Curado" @if( old('status') == 'Curado') selected @endif >Curado</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="medicamentos">Medicamentos</label>
                                    <textarea name="medicamentos" class='form-control' id="medicamentos" rows=10 placeholder="Digite os medicamentos que estão sendo utilizados">{{old('medicamentos')}}</textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"> <i class="fas fa-save"></i> Salvar</button>
                                    <a href="{{route('Casos.index')}}" class='btn btn-primary'> <i class="fas fa-arrow-left"></i> Voltar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
