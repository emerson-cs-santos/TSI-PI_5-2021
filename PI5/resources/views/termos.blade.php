@extends('layouts.site')

@section('content_site')
    <section class="content mt-3">
        <div class="container">

            <div class="row">
                <div class="col-md-12 page-header">
                    <div class="page-pretitle">Termos de Uso e Política de Privacidade</div>
                    <h2 class="page-title text-center">Termos de Uso e Política de Privacidade</h2>

                    <div class="d-flex justify-content-center border border-light">
                        <img src="{{asset('site/img/menuLogo_original.png')}}" class="w-25 h-25" alt="Logo do site">
                    </div>

                    @include('exibirAlert')
                </div>
            </div>

            <div class="col-12 mt-3 d-flex justify-content-center mb-3">
                <button onclick="window.print()" class='btn btn-success'> <i class="fas fa-print"></i> Imprimir</button>
            </div>

            <h3>Termos de Uso</h3>
            <p>Os serviços do sistema são fornecidos pela pessoa jurídica com a seguinte Razão Social/nome: <strong>Sistemas SA </strong>, com nome fantasia <strong>Sistemas Espertos</strong>, inscrito no CNPJ sob o nº <strong>85.389.782/0001-55</strong>,titular da propriedade intelectual sobre software, website, aplicativos, conteúdos e demais ativos relacionados à plataforma <strong>Saúde sob Controle</strong>.</p>

            <h4 class="font-weight-bold">1. Do objeto</h4>
            <p>A plataforma visa auxiliar os usuários a controlar seus <strong>casos médicos</strong>.</p>
            <p>A plataforma caracteriza-se pela prestação do seguinte serviço: <strong>Cadastro e Relatórios</strong>.</p>
            <p>A plataforma realiza a venda de serviços <strong>premium</strong>.</p>

            <h4 class="font-weight-bold">2. Da aceitação</h4>
            <p>O presente Termo estabelece obrigações contratadas de livre e espontânea vontade, por tempo indeterminado, entre a plataforma e as pessoas físicas ou jurídicas, usuárias do OU site OU aplicativo.</p>
            <p>Ao utilizar a plataforma o usuário aceita integralmente as presentes normas e compromete-se a observá-las, sob o risco de aplicação das penalidades cabíveis.</p>
            <p>A aceitação do presente instrumento é imprescindível para o acesso e para a utilização de quaisquer serviços fornecidos pela empresa. Caso não concorde com as disposições deste instrumento, o usuário não deve utilizá-los.</p>

            <h4 class="font-weight-bold">3. Do acesso dos usuários</h4>
            <p>Serão utilizadas todas as soluções técnicas à disposição do responsável pela plataforma para permitir o acesso ao serviço 24 (vinte e quatro) horas por dia, 7 (sete) dias por semana. No entanto, a navegação na plataforma ou em alguma de suas páginas poderá ser interrompida, limitada ou suspensa para atualizações, modificações ou qualquer ação necessária ao seu bom funcionamento.</p>

            <h4 class="font-weight-bold">4. Do cadastro</h4>
            <p>O acesso às funcionalidades da plataforma exigirá a realização de um cadastro prévio e, a depender dos serviços ou produtos escolhidos, o pagamento de determinado valor.</p>
            <p>Ao se cadastrar o usuário deverá informar dados, recentes e válidos, sendo de sua exclusiva responsabilidade manter referidos dados atualizados, bem como o usuário se compromete com a veracidade dos dados fornecidos.</p>
            <p>O usuário se compromete a não informar seus dados cadastrais e/ou de acesso à plataforma a terceiros, responsabilizando-se integralmente pelo uso que deles seja feito.</p>
            <p>Menores de 18 anos e aqueles que não possuírem plena capacidade civil deverão obter previamente o consentimento expresso de seus responsáveis legais para utilização da plataforma e dos serviços ou produtos, sendo de responsabilidade exclusiva dos mesmos o eventual acesso por menores de idade e por aqueles que não possuem plena capacidade civil sem a prévia autorização.</p>
            <p>Mediante a realização do cadastro o usuário declara e garante expressamente ser plenamente capaz, podendo exercer e usufruir livremente dos serviços e produtos.</p>
            <p>O usuário deverá fornecer um endereço de e-mail válido, através do qual o site realizará todas as comunicações necessárias.</p>
            <p>Após a confirmação do cadastro, o usuário possuirá um login e uma senha pessoal, a qual assegura ao usuário o acesso individual à mesma. Desta forma, compete ao usuário exclusivamente a manutenção de referida senha de maneira confidencial e segura, evitando o acesso indevido às informações pessoais.</p>
            <p>Toda e qualquer atividade realizada com o uso da senha será de responsabilidade do usuário, que deverá informar prontamente a plataforma em caso de uso indevido da respectiva senha.</p>
            <p>Não será permitido ceder, vender, alugar ou transferir, de qualquer forma, a conta, que é pessoal e intransferível.</p>
            <p>Caberá ao usuário assegurar que o seu equipamento seja compatível com as características técnicas que viabilize a utilização da plataforma e dos serviços ou produtos.</p>
            <p>O usuário poderá, a qualquer tempo, requerer o cancelamento de seu cadastro junto ao site <strong>Saúde sob Controle </strong>. O seu descadastramento será realizado o mais rapidamente possível, desde que não sejam verificados débitos em aberto.</p>
            <p>O usuário, ao aceitar os Termos e Política de Privacidade, autoriza expressamente a plataforma a coletar, usar, armazenar, tratar, ceder ou utilizar as informações derivadas do uso dos serviços, do site e quaisquer plataformas, incluindo todas as informações preenchidas pelo usuário no momento em que realizar ou atualizar seu cadastro, além de outras expressamente descritas na Política de Privacidade que deverá ser autorizada pelo usuário.</p>

            <h4 class="font-weight-bold">5. Dos serviços </h4>
            <p>A plataforma poderá disponibilizar para o usuário um conjunto específico de funcionalidades e ferramentas para otimizar o uso dos serviços e produtos.</p>
            <p>Na plataforma os serviços ou produtos oferecidos estão descritos e apresentados com o maior grau de exatidão, contendo informações sobre suas características, qualidades, quantidades, composição, preço, garantia, prazos de validade e origem, entre outros dados, bem como sobre os riscos que apresentam à saúde e segurança do usuário.</p>
            <p>Antes de finalizar a compra sobre determinado produto ou serviço, o usuário deverá se informar sobre as suas especificações e sobre a sua destinação.</p>

            <h4 class="font-weight-bold">6. Dos preços</h4>
            <p>A plataforma se reserva no direito de reajustar unilateralmente, a qualquer tempo, os valores dos serviços ou produtos sem consulta ou anuência prévia do usuário.</p>
            <p>Os valores aplicados são aqueles que estão em vigor no momento do pedido.</p>
            <p>Os preços são indicados em reais e não incluem as taxas de entrega, as quais são especificadas à parte e são informadas ao usuário antes da finalização do pedido.</p>
            <p>Na contratação de determinado serviço ou produto, a plataforma poderá solicitar as informações financeiras do usuário, como CPF, endereço de cobrança e dados de cartões. Ao inserir referidos dados o usuário concorda que sejam cobrados, de acordo com a forma de pagamento que venha a ser escolhida, os preços então vigentes e informados quando da contratação. Referidos dados financeiros poderão ser armazenados para facilitar acessos e contratações futuras.</p>

            <h4 class="font-weight-bold">7. Do cancelamento</h4>
            <p>O usuário poderá cancelar a contratação dos serviços de acordo com os termos que forem definidos no momento de sua contratação. Ainda, o usuário também poderá cancelar os serviços em até 7 (sete) dias após a contratação, mediante contato com o <strong>controlesaudesuporte@senac.com.br</strong>, de acordo com o <strong>Código de Defesa do Consumidor (Lei no. 8.078/90) </strong>.</p>
            <p>O serviço poderá ser cancelado por:</p>
            <p>a) parte do usuário: nessas condições os serviços somente cessarão quando concluído o ciclo vigente ao tempo do cancelamento;</p>
            <p>b) violação dos Termos de Uso: os serviços serão cessados imediatamente.</p>
            <p>Em caso de arrependimento, o usuário poderá cancelar a compra do modo premium em até 7 (sete) dias após o seu recebimento, mediante contato com o <strong>controlesaudesuporte@senac.com.br</strong>, de acordo com o <strong>Código de Defesa do Consumidor (Lei nº 8.078/90) </strong>.</p>

            <h4 class="font-weight-bold">9. Do suporte</h4>
            <p>Em caso de qualquer dúvida, sugestão ou problema com a utilização da plataforma, o usuário poderá entrar em contato com o suporte, através do e-mail <strong>controlesaudesuporte@senac.com.br</strong>  OU telefone <strong>2185-9685</strong>.</p>
            <p>Estes serviços de atendimento ao usuário estarão disponíveis nos seguintes dias e horários: 08:00 às 17:00.</p>

            <h4 class="font-weight-bold">10. Das responsabilidades</h4>
            <p>É de responsabilidade do usuário:</p>
            <p>a) defeitos ou vícios técnicos originados no próprio sistema do usuário;</p>
            <p>b) a correta utilização da plataforma, dos serviços ou produtos oferecidos, prezando pela boa convivência, pelo respeito e cordialidade entre os usuários;</p>
            <p>c) pelo cumprimento e respeito ao conjunto de regras disposto nesse Termo de Condições Geral de Uso, na respectiva Política de Privacidade e na legislação nacional e internacional;</p>
            <p>d) pela proteção aos dados de acesso à sua conta/perfil (login e senha).</p>
            <p>É de responsabilidade da plataforma <strong>Saúde sob Controle</strong>;</p>
            <p>a) indicar as características do serviço ou produto;</p>
            <p>b) os defeitos e vícios encontrados no serviço ou produto oferecido desde que lhe tenha dado causa;</p>
            <p>c) as informações que foram por ele divulgadas, sendo que os comentários ou informações divulgadas por usuários são de inteira responsabilidade dos próprios usuários;</p>
            <p>d) os conteúdos ou atividades ilícitas praticadas através da sua plataforma.</p>
            <p>A plataforma não se responsabiliza por links externos contidos em seu sistema que possam redirecionar o usuário à ambiente externo a sua rede.</p>
            <p>Não poderão ser incluídos links externos ou páginas que sirvam para fins comerciais ou publicitários ou quaisquer informações ilícitas, violentas, polêmicas, pornográficas, xenofóbicas, discriminatórias ou ofensivas.</p>

            <h4 class="font-weight-bold">11. Dos direitos autorais</h4>
            <p>O presente Termo de Uso concede aos usuários uma licença não exclusiva, não transferível e não sublicenciável, para acessar e fazer uso da plataforma e dos serviços e produtos por ela disponibilizados.</p>
            <p>A estrutura do site ou aplicativo, as marcas, logotipos, nomes comerciais, layouts, gráficos e design de interface, imagens, ilustrações, fotografias, apresentações, vídeos, conteúdos escritos e de som e áudio, programas de computador, banco de dados, arquivos de transmissão e quaisquer outras informações e direitos de propriedade intelectual da razão social Sistemas SA, observados os termos da <strong>Lei da Propriedade Industrial (Lei nº 9.279/96), Lei de Direitos Autorais (Lei nº 9.610/98) e Lei do Software (Lei nº 9.609/98) </strong>, estão devidamente reservados.</p>
            <p>Este Termos de Uso não cede ou transfere ao usuário qualquer direito, de modo que o acesso não gera qualquer direito de propriedade intelectual ao usuário, exceto pela licença limitada ora concedida.</p>
            <p>O uso da plataforma pelo usuário é pessoal, individual e intransferível, sendo vedado qualquer uso não autorizado, comercial ou não-comercial. Tais usos consistirão em violação dos direitos de propriedade intelectual da razão social <strong>Sistemas SA</strong> puníveis nos termos da legislação aplicável.</p>

            <h4 class="font-weight-bold">12. Das sanções</h4>
            <p>Sem prejuízo das demais medidas legais cabíveis, a razão social <strong>Sistemas SA</strong>  poderá, a qualquer momento, advertir, suspender ou cancelar a conta do usuário:</p>
            <p>a) que violar qualquer dispositivo do presente Termo;</p>
            <p>b) que descumprir os seus deveres de usuário;</p>
            <p>c) que tiver qualquer comportamento fraudulento, doloso ou que ofenda a terceiros.</p>

            <h4 class="font-weight-bold">13. Da rescisão</h4>
            <p>A não observância das obrigações pactuadas neste Termo de Uso ou da legislação aplicável poderá, sem prévio aviso, ensejar a imediata rescisão unilateral por parte da razão social <strong>Sistemas SA</strong>   e o bloqueio de todos os serviços prestados ao usuário.</p>

            <h4 class="font-weight-bold">14. Das alterações</h4>
            <p>Os itens descritos no presente instrumento poderão sofrer alterações, unilateralmente e a qualquer tempo, por parte de <strong>Saúde sob Controle</strong>, para adequar ou modificar os serviços, bem como para atender novas exigências legais. As alterações serão veiculadas OU pelo site <strong>Saúde sob Controle</strong> e o usuário poderá optar por aceitar o novo conteúdo ou por cancelar o uso dos serviços, caso seja assinante de algum serviço.</p>
            <p>Os serviços oferecidos podem, a qualquer tempo e unilateralmente, e sem qualquer aviso prévio, ser deixados de fornecer, alterados em suas características, bem como restringido para o uso ou acesso. </p>

            <h4 class="font-weight-bold">15. Da política de privacidade</h4>
            <p>Além do presente Termo, o usuário deverá consentir com as disposições contidas na respectiva Política de Privacidade a ser apresentada a todos os interessados dentro da interface da plataforma. </p>

            <h4 class="font-weight-bold">16. Do foro</h4>
            <p>Para a solução de controvérsias decorrentes do presente instrumento será aplicado integralmente o Direito brasileiro. Os eventuais litígios deverão ser apresentados no foro da comarca em que se encontra a sede da empresa.</p>


            <h3 class="mt-5">Política de Privacidade</h3>

            <h4 class="font-weight-bold">SEÇÃO 1 - INFORMAÇÕES GERAIS</h4>
            <p>A presente Política de Privacidade contém informações sobre coleta, uso, armazenamento, tratamento e proteção dos dados pessoais dos usuários e visitantes do <strong>Saúde sob Controle</strong> com a finalidade de demonstrar absoluta transparência quanto ao assunto e esclarecer a todos interessados sobre os tipos de dados que são coletados, os motivos da coleta e a forma como os usuários podem gerenciar ou excluir as suas informações pessoais.</p>
            <p>Esta Política de Privacidade aplica-se a todos os usuários e visitantes <strong>Saúde sob Controle</strong>  e integra os Termos e Condições Gerais de Uso do <strong>Saúde sob Controle</strong>  devidamente inscrita no CNPJ sob o nº <strong>85.389.782/0001-55</strong>, situado em Rua Professor do saber, 25 doravante nominada Sistemas SA.</p>
            <p>O presente documento foi elaborado em conformidade com a Lei Geral de Proteção de Dados Pessoais <strong> (Lei 13.709/18), o Marco Civil da Internet (Lei 12.965/14) (e o Regulamento da UE n. 2016/6790) </strong>. Ainda, o documento poderá ser atualizado em decorrência de eventual atualização normativa, razão pela qual se convida o usuário a consultar periodicamente esta seção.</p>

            <h4 class="font-weight-bold">SEÇÃO 2 - COMO RECOLHEMOS OS DADOS PESSOAIS DO USUÁRIO?</h4>
            <p>Os dados pessoais do usuário são recolhidos pela plataforma da seguinte forma:</p>
            <p>Quando o usuário cria uma conta/perfil na plataforma <strong>Saúde sob Controle: </strong> esses dados são os dados de identificação básicos, como <strong>Nome, Email, Idade e gênero</strong>. A partir deles, podemos identificar o usuário e o visitante, além de garantir uma maior segurança e bem-estar às suas necessidades. Ficam cientes os usuários e visitantes de que seu perfil na plataforma não estará acessível a demais usuários e visitantes da plataforma <strong>Saúde sob Controle</strong>.</p>
            <p>Quando um usuário e visitante acessa páginas do site <strong>Saúde sob Controle</strong> as informações sobre interação e acesso são coletadas pela empresa para garantir uma melhor experiência ao usuário e visitante. Estes dados podem tratar sobre as palavras-chaves utilizadas em uma busca, o compartilhamento de um documento específico, comentários, visualizações de páginas, perfis, a URL de onde o usuário e visitante provêm, o navegador que utilizam e seus IPs de acesso, dentre outras que poderão ser armazenadas e retidas.</p>
            <p>Por intermédio de terceiro: a plataforma <strong>Saúde sob Controle</strong> recebe dados de terceiros, como Google, Facebook, GitHub quando um usuário faz login com o seu perfil de um desses sites. A utilização desses dados é autorizada previamente pelos usuários junto ao terceiro em questão.</p>
            <p>outras</p>

            <h4 class="font-weight-bold">SEÇÃO 3 - QUAIS DADOS PESSOAIS RECOLHEMOS SOBRE O USUÁRIO E VISITANTE?</h4>
            <p>Os dados pessoais do usuário recolhidos são os seguintes:</p>
            <p>Dados para a criação da conta/perfil na plataforma <strong>Nome, Email, Idade e gênero</strong>.</p>
            <p>Dados para concretizar transações: dados referentes ao pagamento e transações, tais como, número do cartão de crédito e outras informações sobre o cartão, além dos pagamentos efetuados.</p>
            <p>Dados relacionados a contratos: diante da formalização do contrato de compra e venda ou de prestação de serviços entre a plataforma e o usuário e visitante poderão ser coletados e armazenados dados relativos a execução contratual, inclusive as comunicações realizada entre a empresa e o usuário.</p>
            <p>outras</p>

            <h4 class="font-weight-bold">SEÇÃO 3 - PARA QUE FINALIDADES UTILIZAMOS OS DADOS PESSOAIS DO USUÁRIO E VISITANTE?</h4>
            <p>Os dados pessoais do usuário coletados e armazenados pela plataforma <strong>Saúde sob Controle</strong> tem por finalidade:</p>
            <p>Bem-estar do usuário: aprimorar o produto e/ou serviço oferecido, facilitar, agilizar e cumprir os compromissos estabelecidos entre o usuário e a empresa, melhorar a experiência dos usuários e fornecer funcionalidades específicas a depender das características básicas do usuário.</p>
            <p>Melhorias da plataforma: compreender como o usuário utiliza os serviços da plataforma, para ajudar no desenvolvimento de negócios e técnicas.</p>
            <p>Anúncios: apresentar anúncios personalizados para o usuário com base nos dados fornecidos.</p>
            <p>Comercial: os dados são usados para personalizar o conteúdo oferecido e gerar subsídio à plataforma para a melhora da qualidade no funcionamento dos serviços.</p>
            <p>Previsão do perfil do usuário: tratamento automatizados de dados pessoais para avaliar o uso na plataforma.</p>
            <p>Dados de cadastro: para permitir o acesso do usuário a determinados conteúdos da plataforma, exclusivo para usuários cadastrados</p>
            <p>Dados de contrato: conferir às partes segurança jurídica e facilitar a conclusão do negócio.</p>
            <p>Outras</p>
            <p>O tratamento de dados pessoais para finalidades não previstas nesta Política de Privacidade somente ocorrerá mediante comunicação prévia ao usuário, de modo que os direitos e obrigações aqui previstos permanecem aplicáveis.</p>

            <h4 class="font-weight-bold">SEÇÃO 4 - POR QUANTO TEMPO OS DADOS PESSOAIS FICAM ARMAZENADOS?</h4>
            <p>Os dados pessoais do usuário são armazenados pela plataforma durante o período necessário para a prestação do serviço ou o cumprimento das finalidades previstas no presente documento, conforme o disposto no inciso I do artigo 15 da Lei 13.709/18.</p>
            <p>Os dados podem ser removidos a pedido do usuário, excetuando os casos em que a lei oferecer outro tratamento.</p>
            <p>Ainda, os dados pessoais dos usuários apenas podem ser conservados após o término de seu tratamento nas seguintes hipóteses previstas no artigo 16 da referida lei:</p>
            <p>I - cumprimento de obrigação legal ou regulatória pelo controlador;</p>
            <p>II - estudo por órgão de pesquisa, garantida, sempre que possível, a anonimização dos dados pessoais;</p>
            <p>III - transferência a terceiro, desde que respeitados os requisitos de tratamento de dados dispostos nesta Lei;</p>
            <p>IV - uso exclusivo do controlador, vedado seu acesso por terceiro, e desde que anonimizados os dados.</p>

            <h4 class="font-weight-bold">SEÇÃO 5 - SEGURANÇA DOS DADOS PESSOAIS ARMAZENADOS</h4>
            <p>A plataforma se compromete a aplicar as medidas técnicas e organizativas aptas a proteger os dados pessoais de acessos não autorizados e de situações de destruição, perda, alteração, comunicação ou difusão de tais dados.</p>
            <p>Os dados relativas a cartões de crédito são criptografados usando a tecnologia "secure socket layer" (SSL) que garante a transmissão de dados de forma segura e confidencial, de modo que a transmissão dos dados entre o servidor e o usuário ocorre de maneira cifrada e encriptada.</p>
            <p>A plataforma não se exime de responsabilidade por culpa exclusiva de terceiro, como em caso de ataque de hackers ou crackers, ou culpa exclusiva do usuário, como no caso em que ele mesmo transfere seus dados a terceiros. O site se compromete a comunicar o usuário em caso de alguma violação de segurança dos seus dados pessoais.</p>
            <p>Os dados pessoais armazenados são tratados com confidencialidade, dentro dos limites legais. No entanto, podemos divulgar suas informações pessoais caso sejamos obrigados pela lei para fazê-lo ou se você violar nossos Termos de Serviço.</p>

            <h4 class="font-weight-bold">SEÇÃO 6 - COMPARTILHAMENTO DOS DADOS</h4>
            <p>O compartilhamento de dados do usuário ocorre apenas com os dados referentes a publicações realizadas pelo próprio usuário, tais ações são compartilhadas publicamente com os outros usuários.</p>
            <p>Os dados do perfil do usuário são compartilhados publicamente em sistemas de busca e dentro da plataforma, sendo permitido ao usuário modificar tal configuração para que seu perfil não apareça nos resultados de busca de tais ferramentas.</p>

            <h4 class="font-weight-bold">SEÇÃO 6 - OS DADOS PESSOAIS ARMAZENADOS SERÃO TRANSFERIDOS A TERCEIROS?</h4>
            <p>Os dados pessoais não podem ser compartilhados com terceiros.</p>
            <p>Com relação aos fornecedores de serviços terceirizados como processadores de transação de pagamento, informamos que cada qual tem sua própria política de privacidade. Desse modo, recomendamos a leitura das suas políticas de privacidade para compreensão de quais informações pessoais serão usadas por esses fornecedores.</p>
            <p>Os fornecedores podem ser localizados ou possuir instalações localizadas em países diferentes. Nessas condições, os dados pessoais transferidos podem se sujeitar às leis de jurisdições nas quais o fornecedor de serviço ou suas instalações estão localizados.</p>
            <p>Ao acessar nossos serviços e prover suas informações, você está consentindo o processamento, transferência e armazenamento desta informação em outros países.</p>
            <p>Ao ser redirecionado para um aplicativo ou site de terceiros, você não será mais regido por essa Política de Privacidade ou pelos Termos de Serviço da nossa plataforma. Não somos responsáveis pelas práticas de privacidade de outros sites e lhe incentivamos a ler as declarações de privacidade deles.</p>

            <h4 class="font-weight-bold">SEÇÃO 07 – COOKIES OU DADOS DE NAVEGAÇÃO</h4>
            <p>Os cookies referem-se a arquivos de texto enviados pela plataforma ao computador do usuário e visitante e que nele ficam armazenados, com informações relacionadas à navegação no site. Tais informações são relacionadas aos dados de acesso como local e horário de acesso e são armazenadas pelo navegador do usuário e visitante para que o servidor da plataforma possa lê-las posteriormente a fim de personalizar os serviços da plataforma.</p>
            <p>O usuário e o visitante da plataforma <strong>Saúde sob Controle</strong> manifesta conhecer e aceitar que pode ser utilizado um sistema de coleta de dados de navegação mediante à utilização de cookies.</p>
            <p>O cookie persistente permanece no disco rígido do usuário e visitante depois que o navegador é fechado e será usado pelo navegador em visitas subsequentes ao site. Os cookies persistentes podem ser removidos seguindo as instruções do seu navegador. Já o cookie de sessão é temporário e desaparece depois que o navegador é fechado. É possível redefinir seu navegador da web para recusar todos os cookies, porém alguns recursos da plataforma podem não funcionar corretamente se a capacidade de aceitar cookies estiver desabilitada.</p>

            <h4 class="font-weight-bold">SEÇÃO 8 - CONSENTIMENTO</h4>
            <p>Ao utilizar os serviços e fornecer as informações pessoais na plataforma, o usuário está consentindo com a presente Política de Privacidade.</p>
            <p>O usuário, ao cadastrar-se, manifesta conhecer e pode exercitar seus direitos de cancelar seu cadastro, acessar e atualizar seus dados pessoais e garante a veracidade das informações por ele disponibilizadas.</p>
            <p>O usuário tem direito de retirar o seu consentimento a qualquer tempo, para tanto deve entrar em contato através do e-mail <strong>controlesaudesuporte@senac.com.br</strong>.</p>

            <h4 class="font-weight-bold">SEÇÃO 9 - ALTERAÇÕES PARA ESSA POLÍTICA DE PRIVACIDADE</h4>
            <p>Reservamos o direito de modificar essa Política de Privacidade a qualquer momento, então, é recomendável que o usuário e visitante revise-a com frequência.</p>
            <p>As alterações e esclarecimentos vão surtir efeito imediatamente após sua publicação na plataforma. Quando realizadas alterações os usuários serão notificados. Ao utilizar o serviço ou fornecer informações pessoais após eventuais modificações, o usuário e visitante demonstra sua concordância com as novas normas.</p>
            <p>Diante da fusão ou venda da plataforma à outra empresa os dados dos usuários podem ser transferidos para os novos proprietários para que a permanência dos serviços oferecidos.</p>

            <h4 class="font-weight-bold">SEÇÃO 10 – JURISDIÇÃO PARA RESOLUÇÃO DE CONFLITOS</h4>
            <p>Para a solução de controvérsias decorrentes do presente instrumento será aplicado integralmente o Direito brasileiro.</p>
            <p>Os eventuais litígios deverão ser apresentados no foro da comarca em que se encontra a sede da empresa.</p>

        </div>
    </section>
@endsection
