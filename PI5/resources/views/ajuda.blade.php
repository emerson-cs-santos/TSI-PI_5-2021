@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Ajuda</div>
                    <h2 class="page-title text-center">Ajuda</h2>

                    <div class="d-flex justify-content-center border border-light">
                        <img src="{{asset('site/img/menuLogo_original.png')}}" class="w-25 h-25" alt="Logo do site">
                    </div>

                    @include('exibirAlert')
                </div>
            </div>

            <div class="col-12 mt-2 text-dark">

                <div class="card">
                    <div class="card-header h2">Ferramentas do site</div>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active h3" id="pills-casos-tab" data-toggle="pill" href="#pills-casos" role="tab" aria-controls="pills-casos" aria-selected="false">Casos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link h3" id="pills-ocorrencias-tab" data-toggle="pill" href="#pills-ocorrencias" role="tab" aria-controls="pills-ocorrencias" aria-selected="false">Ocorrências</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link h3" id="pills-relatorios-tab" data-toggle="pill" href="#pills-relatorios" role="tab" aria-controls="pills-relatorios" aria-selected="false">Relatórios</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link h3" id="pills-premium-tab" data-toggle="pill" href="#pills-premium" role="tab" aria-controls="pills-premium" aria-selected="false">Premium</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link h3" id="pills-perfil-tab" data-toggle="pill" href="#pills-perfil" role="tab" aria-controls="pills-perfil" aria-selected="false">Perfil/Cadastro</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent1">

                            <div class="tab-pane fade active show" id="pills-casos" role="tabpanel" aria-labelledby="pills-casos-tab">
                                <p class="h5">Os casos médicos são uma descrição do que está ocorrendo com a pessoa, pode ser um diagnóstico de uma ou mais doenças.</p>
                                <p class="h5">Também informe no caso o status dele e se está tomando medicações.</p>
                            </div>

                            <div class="tab-pane fade" id="pills-ocorrencias" role="tabpanel" aria-labelledby="pills-ocorrencias-tab">
                                <p class="h5">Dentro do caso, existem as ocorrências, que podem ser por exemplo:</p>
                                <ul class="h5">
                                    <li>Consultas</li>
                                    <li>Exames</li>
                                    <li>Cirurgia</li>
                                </ul>
                                <p class="h5">Além de poder colocar o máximo de informações possível da ocorrência, também é possível anexar arquivos, como exames e receitas.</p>
                            </div>

                            <div class="tab-pane fade" id="pills-relatorios" role="tabpanel" aria-labelledby="pills-relatorios-tab">
                                <p class="h5">Utilizado para obter as informações dos casos e suas ocorrências, com filtros e 3 tipos de relatórios:</p>
                                <ul class="h5">
                                    <li> <strong>Simples</strong> - Apenas as 5 últimas ocorrências.</li>
                                    <li> <strong>Completo</strong> - Considera todas as ocorrências (Apenas usuários Premium).</li>
                                </ul>
                                <p class="h5"> <strong>Anexos</strong> - Caso nos resultados dos filtros do relatório, exista anexos, é possível baixar todos eles de uma vez.</p>
                                <p class="h5"> <strong>Impressão</strong>  - É possivel gerar uma versão de impressão do resultado do relatório. Essa funcionalidade usa a função padrão de imprimir do navegador.</p>
                                <p class="h5"> <strong>E-mail</strong>  - A impressão é possível enviar uma um e-mail que pode ser informado no ato do envio, podendo enviar para um médico por exemplo.</p>
                            </div>

                            <div class="tab-pane fade" id="pills-premium" role="tabpanel" aria-labelledby="pills-premium-tab">
                                <p class="h5">Para utilizar todos os recursos do site, é preciso se tornar Premium. Utilize a opção em destaque para mudar o tipo do seu usuário.</p>
                            </div>


                            <div class="tab-pane fade" id="pills-perfil" role="tabpanel" aria-labelledby="pills-perfil-tab">
                                <p class="h5">Alterar informações pessoais e senha.</p>

                                <p class="h5"> <strong>Excluir Conta</strong> - Caso não deseje mais utilizar nosso site, atendendo a LGPD, é possível apagar sua conta e suas informações. Caso opte por isso, será necessário criar um cadastro, caso queira acessar novamente.</p>
                                <p class="h5"> <strong>Termos de uso</strong> - Visualizar os Termos de Uso e Política de Privacidade.</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if ( !empty(Auth::user()->name) )
                    @if ( Auth::user()->isAdmin() )

                    <div class="card">
                        <div class="card-header h2">Ferramentas Administrativas</div>
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3" id="pills-tab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active h3" id="pills-usuarios-tab" data-toggle="pill" href="#pills-usuarios" role="tab" aria-controls="pills-usuarios" aria-selected="false">Cadastro de Usuários</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link h3" id="pills-especialidades-tab" data-toggle="pill" href="#pills-especialidades" role="tab" aria-controls="pills-especialidades" aria-selected="false">Cadastro de Especialidades</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link h3" id="pills-tipos-tab" data-toggle="pill" href="#pills-tipos" role="tab" aria-controls="pills-tipos" aria-selected="false">Cadastro de Tipos</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent2">

                                <div class="tab-pane fade active show" id="pills-usuarios" role="tabpanel" aria-labelledby="pills-usuarios-tab">
                                    <p class="h5">Usuários do Sistema - Filtros, e informações básicas.</p>
                                    <ul class="h5">
                                        <li> <strong>Alterar nível</strong> - Essa opção vai mudar o nivel de acesso do usuário.</li>
                                        <li> <strong>Mover para lixeira</strong> - Atenção ao usar essa opção, pois vai excluir o usuário e seus casos médicos.</li>
                                        <li> <strong>Qtd. de Casos</strong> - Mostra quando casos o usuário tem.</li>
                                    </ul>
                                </div>

                                <div class="tab-pane fade" id="pills-especialidades" role="tabpanel" aria-labelledby="pills-especialidades-tab">
                                    <p class="h5">Especialidades médicas - Filtros, e informações básicas.</p>
                                    <ul class="h5">
                                        <li> <strong>Qtd. de Casos</strong> - Mostra quando casos estão usando a especialidade, considerando todos os usuários.</li>
                                        <li> <strong>Ações</strong> - Incluir, alterar e excluir, porém não será possível excluir se a especialidade estiver sendo usada em alguma ocorrência.</li>
                                    </ul>
                                </div>

                                <div class="tab-pane fade" id="pills-tipos" role="tabpanel" aria-labelledby="pills-tipos-tab">
                                    <p class="h5">Tipos de ocorrências, exemplos: consulta, exame, fisioterapia. Filtros, e informações básicas.</p>
                                    <ul class="h5">
                                        <li><strong>Cor</strong>  - Ao definir uma cor, ela será utilizada nos relatórios para destacar a informação.</li>
                                        <li><strong>Qtd. de Casos</strong>  - Mostra quando casos estão usando o tipo, considerando todos os usuários</li>
                                        <li><strong>Ações</strong> -  Incluir, alterar e excluir, porém não será possível excluir se o tipo estiver sendo usada em alguma ocorrência.</li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>

                    @endif
                @endif

            </div>

        </div>
    </section>
@endsection
