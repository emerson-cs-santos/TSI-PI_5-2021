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
                                <p class="h5">Utilize os Filtros para ajudar a encontrar registros cadastrados.</p>

                                <p class="h5"><strong>Botões de ação:</strong></p>
                                <ul class="h5">
                                    <li><strong>Novo</strong>  - Criar novo cadastro de caso.</li>
                                    <li><strong>Visualizar</strong>  - Ver cadastro do caso.</li>
                                    <li><strong>Editar</strong>  - Alterar cadastro do caso.</li>
                                    <li><strong>Ocorrências</strong>  - Abrir cadastro de ocorrências do caso.</li>
                                    <li><strong>Mover para Lixeira</strong>  - Registro não será mais considerado no sistema, mas é possível restaurar usando a lixeira.</li>
                                </ul>

                                <p class="h5"> <strong>Lixeira</strong> - Mostra casos excluídos, podendo além de filtrar:</p>
                                <ul class="h5">
                                    <li> <strong>Reativar</strong> - Restaura cadastro e ele voltará a ser listado no cadastro normal.</li>
                                    <li> <strong>Apagar</strong> - Atenção ao usar essa opção, pois vai excluir o caso e suas ocorrências de forma definitiva.</li>
                                </ul>
                            </div>

                            <div class="tab-pane fade" id="pills-ocorrencias" role="tabpanel" aria-labelledby="pills-ocorrencias-tab">
                                <p class="h5">Dentro do caso, existem as ocorrências, que podem ser por exemplo:</p>
                                <ul class="h5">
                                    <li>Consultas</li>
                                    <li>Exames</li>
                                    <li>Cirurgia</li>
                                </ul>
                                <p class="h5">Além de poder colocar o máximo de informações possível da ocorrência, também é possível anexar arquivos, como exames e receitas.</p>
                                <p class="h5">Utilize os Filtros para ajudar a encontrar registros cadastrados.</p>

                                <p class="h5"><strong>Botões de ação:</strong></p>
                                <ul class="h5">
                                    <li><strong>Novo</strong>  - Criar nova ocorrência.</li>
                                    <li><strong>Visualizar</strong>  - Ver cadastro da ocorrência.</li>
                                    <li><strong>Editar</strong>  - Alterar cadastro da ocorrência.</li>
                                    <li><strong>Mover para Lixeira</strong>  - Registro não será mais considerado no sistema, mas é possível restaurar usando a lixeira.</li>
                                </ul>

                                <p class="h5"> <strong>Lixeira</strong> - Mostra ocorrências excluídas, podendo além de filtrar:</p>
                                <ul class="h5">
                                    <li> <strong>Reativar</strong> - Restaura cadastro e ele voltará a ser listado no cadastro normal.</li>
                                    <li> <strong>Apagar</strong> - Atenção ao usar essa opção, pois vai excluir a ocorrência de forma definitiva.</li>
                                </ul>
                            </div>

                            <div class="tab-pane fade" id="pills-relatorios" role="tabpanel" aria-labelledby="pills-relatorios-tab">
                                <p class="h5">Utilizado para obter as informações dos casos e suas ocorrências, com filtros e 2 tipos de relatórios:</p>
                                <ul class="h5">
                                    <li> <strong>Simples</strong> - Apenas as 5 últimas ocorrências.</li>
                                    <li> <strong>Completo</strong> - Considera todas as ocorrências (Apenas usuários Premium).</li>
                                </ul>
                                <p class="h5"> <strong>Anexos</strong> - Caso nos resultados dos filtros do relatório, exista anexos, é possível baixar todos eles de uma vez.</p>
                                <p class="h5"> <strong>Impressão</strong>  - É possivel gerar uma versão de impressão do resultado do relatório. Essa funcionalidade usa a função padrão de imprimir do navegador.</p>
                                <p class="h5"> <strong>E-mail</strong>  - É possível enviar uma impressão (PDF) por e-mail, por exemplo, podendo enviar para um médico informando o e-mail dele no ato do envio.</p>
                            </div>

                            <div class="tab-pane fade" id="pills-premium" role="tabpanel" aria-labelledby="pills-premium-tab">
                                <p class="h5">Para utilizar todos os recursos do site, é preciso se tornar Premium. Acesse a opção no menu premium e atualize o tipo do seu usuário.</p>
                            </div>


                            <div class="tab-pane fade" id="pills-perfil" role="tabpanel" aria-labelledby="pills-perfil-tab">
                                <p class="h5">Alterar informações pessoais e senha.</p>

                                <p class="h5"> <strong>Excluir Conta</strong> - Caso não deseje mais utilizar nosso site, atendendo a LGPD, é possível apagar sua conta e suas informações. Caso opte por isso, será necessário criar um novo cadastro, para acessar novamente.</p>
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

                                    <p class="h5"><strong>Botões de ação:</strong></p>
                                    <ul class="h5">
                                        <li> <strong>Alterar nível</strong> - Essa opção vai mudar o nivel de acesso do usuário, de Padrão para Administrador e vice versa.</li>
                                        <li> <strong>Mover para lixeira</strong> - Registro não será mais considerado no sistema, mas é possível restaurar usando a lixeira.</li>
                                        <li> <strong>Qtd. de Casos</strong> - Mostra quando casos o usuário tem.</li>
                                    </ul>

                                    <p class="h5"> <strong>Lixeira</strong> - Mostra usuários excluídos, podendo além de filtrar:</p>
                                    <ul class="h5">
                                        <li> <strong>Reativar</strong> - Restaura cadastro e ele voltará a ser listado no cadastro normal.</li>
                                        <li> <strong>Apagar</strong> - Atenção ao usar essa opção, pois vai excluir o usuário e seus casos médicos (incluindo as ocorrências) de forma definitiva e o e-mail informando o usuário que conta foi apagada não será enviado.</li>
                                    </ul>
                                </div>

                                <div class="tab-pane fade" id="pills-especialidades" role="tabpanel" aria-labelledby="pills-especialidades-tab">
                                    <p class="h5">Especialidades médicas - Filtros, e informações básicas.</p>

                                    <p class="h5"><strong>Qtd. de Casos</strong> - Mostra quando casos estão usando a especialidade, considerando todos os usuários.</p>

                                    <p class="h5"><strong>Botões de ação:</strong></p>
                                    <ul class="h5">
                                        <li><strong>Novo</strong>  - Criar nova especialidade.</li>
                                        <li><strong>Visualizar</strong>  - Ver cadastro da especialidade.</li>
                                        <li><strong>Editar</strong>  - Alterar cadastro da especialidade.</li>
                                        <li><strong>Mover para Lixeira</strong>  - Registro não será mais considerado no sistema, mas é possível restaurar usando a lixeira. Porém não será possível excluir se a especialidade estiver sendo usada em alguma ocorrência.</li>
                                    </ul>

                                    <p class="h5"> <strong>Lixeira</strong> - Mostra especialidades excluídas, podendo além de filtrar:</p>
                                    <ul class="h5">
                                        <li> <strong>Reativar</strong> - Restaura cadastro e ele voltará a ser listado no cadastro normal.</li>
                                        <li> <strong>Apagar</strong> - Atenção ao usar essa opção, pois vai excluir a especialidade de forma definitiva.</li>
                                    </ul>
                                </div>

                                <div class="tab-pane fade" id="pills-tipos" role="tabpanel" aria-labelledby="pills-tipos-tab">
                                    <p class="h5">Tipos de ocorrências, exemplos: consulta, exame, fisioterapia. Filtros, e informações básicas.</p>
                                    <ul class="h5">
                                        <li><strong>Cor</strong>  - Ao definir uma cor, ela será utilizada nos relatórios para destacar a informação.</li>
                                        <li><strong>Qtd. de Casos</strong>  - Mostra quando casos estão usando o tipo, considerando todos os usuários</li>
                                    </ul>

                                    <p class="h5"><strong>Botões de ação:</strong></p>
                                    <ul class="h5">
                                        <li><strong>Novo</strong>  - Criar novo tipo.</li>
                                        <li><strong>Visualizar</strong>  - Ver cadastro do tipo.</li>
                                        <li><strong>Editar</strong>  - Alterar cadastro do tipo.</li>
                                        <li><strong>Mover para Lixeira</strong>  - Registro não será mais considerado no sistema, mas é possível restaurar usando a lixeira. Porém não será possível excluir se o tipo estiver sendo usado em alguma ocorrência.</li>
                                    </ul>

                                    <p class="h5"> <strong>Lixeira</strong> - Mostra tipos excluídos, podendo além de filtrar:</p>
                                    <ul class="h5">
                                        <li> <strong>Reativar</strong> - Restaura cadastro e ele voltará a ser listado no cadastro normal.</li>
                                        <li> <strong>Apagar</strong> - Atenção ao usar essa opção, pois vai excluir o tipo de forma definitiva.</li>
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
