<?php?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="Lava Fácil - Lavandaria com serviços de lavagem, secagem, engomadoria e recolha e entrega de roupa." />
    <meta name="keywords" content="lavandaria, lavagem de roupa, secagem, engomadoria, recolha de roupa, Lava Fácil" />
    <meta name="author" content="Lava Fácil" />
    <title>Sobre Nós</title>
    <link rel="stylesheet" href="public/assets/css/homepage.css" />
    <link rel="stylesheet" href="public/assets/css/lib/bootstrap.min.css" />
    <link rel="stylesheet" href="public/assets/css/lib/datatables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
</head>
<?php include ('app/views/layouts/public_navbar.php'); ?>

    <!-- HERO -->
    <section class="py-5" style="background-color: rgb(45, 49, 54);">
        <div class="container text-center text-white">
            <h1 class="display-5 fw-bold">Sobre Nós</h1>
        </div>
    </section>

    <!-- SECÇÃO MISSÃO -->
    <section class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 mb-4">
                    <div class="bg-white p-3 rounded shadow-sm">
                        <img src="public/assets/img/equipa_02.png" class="img-fluid rounded" alt="A nossa equipa">
                    </div>
                </div>

                <div class="col-lg-6">
                    <h2 class="fw-bold text-primary mb-3">A Nossa Missão</h2>
                    <p>
                        A nossa missão é tornar o cuidado da roupa mais simples, cómodo e acessível para a comunidade de
                        Montemor-o-Novo.
                    </p>
                    <p>
                        Criámos uma solução pensada para quem valoriza o seu tempo e procura um serviço de confiança
                        para
                        tratar da sua roupa sem preocupações. Através da lavagem, secagem, engomadoria e recolha e
                        entrega
                        ao domicílio, assumimos todo o processo, garantindo um serviço completo, profissional e adaptado
                        às
                        necessidades de cada cliente.
                    </p>
                    <p>
                        Mais do que uma lavandaria, queremos oferecer tranquilidade e comodidade, permitindo que as
                        pessoas
                        tenham mais tempo para aquilo que realmente importa.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- SECÇÃO HISTÓRIA -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 order-lg-2 mb-4">
                    <div class="bg-white p-3 rounded shadow-sm">
                        <img src="public/assets/img/camisa.png" class="img-fluid rounded" alt="Qualidade e cuidado">
                    </div>
                </div>

                <div class="col-lg-6 order-lg-1">
                    <h2 class="fw-bold text-primary mb-3">A Nossa História</h2>
                    <p>
                        A nossa história começa em Montemor-o-Novo, uma cidade que conhecemos e onde vivemos. Foi através da nossa ligação à comunidade local que identificámos uma necessidade: existiam algumas soluções de lavandaria, mas faltava um serviço verdadeiramente completo, capaz de reunir todas as etapas do tratamento da roupa num único lugar.
                    </p>
                    <p>
                        Percebemos que muitas pessoas procuravam uma alternativa mais prática às tarefas tradicionais de
                        lavar, secar e passar a ferro. Entre deslocações, falta de tempo e a necessidade de recorrer a
                        diferentes serviços, cuidar da roupa acabava por ser uma tarefa demorada e pouco conveniente.
                    </p>
                    <p>
                        Foi desta realidade que nasceu a nossa ideia: criar uma lavandaria moderna, pensada para simplificar a vida dos clientes. Um espaço onde a roupa é entregue e todo o processo é tratado pela nossa equipa, com profissionalismo e cuidado.</p>
                    </p>
                    <p>
                        Acreditamos que a inovação não está apenas na tecnologia, mas também na forma como conseguimos melhorar a experiência das pessoas. Por isso, juntámos o atendimento presencial tradicional com soluções digitais, através do nosso website, e com um serviço de recolha e entrega ao domicílio, levando a comodidade diretamente até aos nossos clientes.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- SECÇÃO VALORES -->
    <section class="py-5" style="background-color: #f8f9fa;">
        <div class="container text-center">
            <h2 class="fw-bold text-primary mb-4">Os Nossos Valores</h2>

            <div class="row">

                <div class="col-md-4 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h4 class="fw-bold text-primary">Qualidade</h4>
                        <p>Cada peça é tratada com rigor e atenção ao detalhe.</p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h4 class="fw-bold text-primary">Confiança</h4>
                        <p>Transparência e responsabilidade em cada serviço.</p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h4 class="fw-bold text-primary">Comodidade</h4>
                        <p>Recolha e entrega ao domicílio para facilitar o seu dia.</p>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h4 class="fw-bold text-primary">Proximidade</h4>
                        <p>Somos uma empresa local, próxima da comunidade.</p>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h4 class="fw-bold text-primary">Inovação</h4>
                        <p>Combinamos tecnologia com atendimento humano.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECÇÃO EQUIPA -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 mb-4">
                    <div class="bg-white p-3 rounded shadow-sm">
                        <img src="public/assets/img/equipa_01.png" class="img-fluid rounded" alt="Equipa Lava Fácil">
                    </div>
                </div>

                <div class="col-lg-6">
                    <h2 class="fw-bold text-primary mb-3">A Equipa</h2>
                    <p>
                        Por trás de cada serviço está uma equipa dedicada e comprometida em oferecer a melhor experiência aos nossos clientes.
                    </p>
                    <p>
                        Somos pessoas da comunidade, que conhecem as necessidades locais e que acreditam que um bom serviço começa pela proximidade e pelo cuidado com cada detalhe.
                    </p>
                    <p>
                        Todos os dias trabalhamos para garantir que cada cliente recebe um atendimento personalizado e que cada peça de roupa é tratada com o máximo profissionalismo.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- SECÇÃO COMPROMISSO -->
    <section class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 order-lg-2 mb-4">
                    <div class="bg-white p-3 rounded shadow-sm">
                        <img src="public/assets/img/cliente_satisfeito.png" class="img-fluid rounded" alt="Cliente satisfeito">
                    </div>
                </div>

                <div class="col-lg-6 order-lg-1">
                    <h2 class="fw-bold text-primary mb-3">O Nosso Compromisso</h2>
                    <p>
                        Estamos empenhados em construir uma relação de confiança com todos os nossos clientes, oferecendo um serviço transparente, eficiente e de qualidade.
                    </p>
                    <p>
                        O nosso objetivo é crescer juntamente com a comunidade, tornando-nos uma referência em serviços de lavandaria em Montemor-o-Novo, não apenas pela qualidade do nosso trabalho, mas também pela forma próxima e dedicada como acompanhamos cada cliente.
                    </p>
                    <p>
                        No futuro, queremos continuar a melhorar, inovar e adaptar os nossos serviços, mantendo sempre o compromisso: cuidar da roupa dos nossos clientes para que eles tenham mais tempo para si.
                    </p>
                </div>

            </div>
        </div>
    </section>

<footer class="footer">

<div class="container">

    <div class="row">


        <div class="col-lg-4">

            <h3>
                <i class="bi bi-droplet-half"></i>
                Lava Fácil
            </h3>

            <p>
                A forma mais rápida de tratar da sua roupa.
            </p>

        </div>


        <div class="col-lg-4">

            <h5>
                Links
            </h5>

            <ul>

                <li>
                    <a href="#">
                        Início
                    </a>
                </li>

                <li>
                    <a href="#servicos">
                        Serviços
                    </a>
                </li>

                <li>
                    <a href="#contactos">
                        Contactos
                    </a>
                </li>

                <li>
                    <a href="sing-up.html">
                        Criar conta
                    </a>
                </li>

                <li>
                    <a href="login.html">
                        Login
                    </a>
                </li>

            </ul>

        </div>


        <div class="col-lg-4">

            <h5>
                Redes Sociais
            </h5>

            <div class="social-links">

                <a
                    href="#"
                    aria-label="Facebook"
                    class="text-decoration-none">

                    <i class="bi bi-facebook social"></i>

                </a>

                

                <a
                    href="#"
                    aria-label="WhatsApp"
                    class="text-decoration-none">

                    <i class="bi bi-whatsapp social"></i>

                </a>

            </div>

        </div>

    </div>


    <hr>


    <div class="text-center">

        © 2026 Lava Fácil - Todos os direitos reservados.

    </div>

</div>

</footer>


</body>

</html>