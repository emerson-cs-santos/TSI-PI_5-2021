@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Premium</div>
                    <h2 class="page-title text-center">Torne-se usuário Premium!</h2>
                </div>
            </div>

            @include('exibirAlert')

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Premium</div>
                        <div class="card-body">
                            <h5 class="card-title text-center">Uma vez Premium, você terá acesso a todos recursos do site!</h5>
                            <form accept-charset="utf-8" action="{{ route('premium.mudar') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="col-12 mt-3 d-flex justify-content-center mb-3">
                                    @if ( Auth::user()->premium == 'sim' )
                                        <div class="form-group">
                                            <span class="h4 text-success"> Parabens! você já é usuário Premium! </span>
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <button type="button" onclick="confirmar('Torne-se Premium','Você tem certeza?', this.form)" class="btn btn-primary"> <i class="fas fa-pen-nib"></i> Mudar tipo da Conta</button>
                                        </div>
                                    @endif
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
