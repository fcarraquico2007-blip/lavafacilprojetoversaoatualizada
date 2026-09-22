

<?php
session_start();

$logado  = isset($_SESSION['user_id']);
$isAdmin = $logado && $_SESSION['role'] === 'admin';
$nome    = $_SESSION['nome'] ?? '';
?>



<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="Lava Fácil - Lavandaria com serviços de lavagem, secagem, engomadoria e recolha e entrega de roupa." />
    <meta name="keywords" content="lavandaria, lavagem de roupa, secagem, engomadoria, recolha de roupa, Lava Fácil" />
    <meta name="author" content="Lava Fácil" />
    <title>Lavandaria Lava Fácil</title>
    <link rel="stylesheet" href="public/assets/css/homepage.css" />
    <link rel="stylesheet" href="public/assets/css/lib/bootstrap.min.css" />
    <link rel="stylesheet" href="public/assets/css/lib/datatables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
</head>


<body>
    <?php include('app/views/layouts/public_navbar.php'); ?>

    <header class="hero-section position-relative" style="height: 92vh;">
        <div id="heroCarousel" class="carousel slide carousel-fade h-100" data-bs-ride="carousel"
            data-bs-interval="5000">

            <!-- CAROUSEL -->
            <div class="carousel-inner h-100">
                <div class="carousel-item active h-100"
                    style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('public/assets/img/loja_fora.png'); background-size: cover; background-position: center;">
                </div>

                <div class="carousel-item h-100"
                    style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('public/assets/img/loja_dentro.png'); background-size: cover; background-position: center;">
                </div>

                <div class="carousel-item h-100"
                    style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('public/assets/img/servico_secagem.png'); background-size: cover; background-position: center;">
                </div>

                <div class="carousel-item h-100"
                    style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('public/assets/img/imagem03.png'); background-size: cover; background-position: center;">
                </div>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev"
                style="z-index: 3;">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next"
                style="z-index: 3;">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden"></span>
            </button>

        </div>

        <!-- UNIQUE TEXT -->
        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-center text-white p-3" style="z-index: 2; pointer-events: none;">
            <div style="pointer-events: auto;">
                <h1 class="display-3 fw-bold">Lavagem profissional para toda <br> a roupa do dia-a-dia.</h1>
                <p class="lead">Tratamos da sua roupa com todo o cuidado.</p>
            </div>
        </div>

    </header>
<!-- ==================== SERVIÇOS ==================== -->

<section id="servicos" class="py-5 bg-light">

<div class="container">

    <div class="text-center mb-5" data-aos="fade-up">

        <h2 class="fw-bold display-5">
            Os nossos serviços
        </h2>

        <p class="text-muted">
            Tratamos da sua roupa com todo o cuidado.
        </p>

    </div>


    <div class="row g-4">


        <!-- LAVAGEM (cod_tiposervico = 1) -->

        <div class="col-lg-4 col-md-6" data-aos="zoom-in">

            <div class="service-card">

                <div class="icon">
                    <i class="bi bi-droplet"></i>
                </div>

                <h4>
                    Lavagem
                </h4>

                <p>
                    Lavagem profissional para toda a roupa do dia-a-dia.
                </p>

            </div>

        </div>


        <!-- SECAGEM (cod_tiposervico = 2) -->

        <div
            class="col-lg-4 col-md-6"
            data-aos="zoom-in"
            data-aos-delay="200">

            <div class="service-card">

                <div class="icon">
                    <i class="bi bi-fan"></i>
                </div>

                <h4>
                    Secagem
                </h4>

                <p>
                    Secagem cuidada para camisas, calças,
                    vestidos e muito mais.
                </p>


            </div>

        </div>


        <!-- PASSAR A FERRO / ENGOMADORIA (cod_tiposervico = 3) -->

        <div
            class="col-lg-4 col-md-6"
            data-aos="zoom-in">

            <div class="service-card">

                <div class="icon">
                    <i class="bi bi-thermometer-high"></i>
                </div>

                <h4>
                    Passar a ferro
                </h4>

                <p>
                    Ideal para fatos, vestidos e roupa delicada.
                </p>


            </div>

        </div>


        <!-- LAVAGEM + SECAGEM (cod_tiposervico = 6) -->

        <div
            class="col-lg-4 col-md-6"
            data-aos="zoom-in"
            data-aos-delay="100">

            <div class="service-card">

                <div class="icon">
                    <i class="bi bi-wind"></i>
                </div>

                <h4>
                    Lavagem + Secagem
                </h4>

                <p>
                    Um serviço completo para deixar a sua roupa
                    limpa e pronta a usar.
                </p>


            </div>

        </div>


        <!-- LAVAGEM + SECAGEM + FERRO (cod_tiposervico = 7) -->

        <div
            class="col-lg-4 col-md-6"
            data-aos="zoom-in"
            data-aos-delay="100">

            <div class="service-card">

                <div class="icon">
                    <i class="bi bi-layers"></i>
                </div>

                <h4>
                    Lavagem + Secagem + Ferro
                </h4>

                <p>
                    O serviço completo para quem procura
                    praticidade e comodidade.
                </p>

              

            </div>

        </div>


        <!-- PACKS: 3 planos mensais (cod_tiposervico 8, 9, 10) — não dá
             para ir direto a um único agendar.php?id=X, por isso aponta
             para uma mini-página só com esses 3 packs. -->

        <div
            class="col-lg-4 col-md-6"
            data-aos="zoom-in"
            data-aos-delay="100">

            <div class="service-card">

                <div class="icon">
                    <i class="bi bi-boxes"></i>
                </div>

                <h4>
                    Packs
                </h4>

                <p>
                    Escolha um dos nossos packs mensais
                    e simplifique o cuidado da sua roupa.
                </p>

               

            </div>

        </div>

    </div>
<br>
</div>
 <div class="d-grid gap-2 col-2 mx-auto">
  <button class="btn btn-primary" type="button"onclick="window.location.href='login.html'">Agendar</button>
 
 </div>

</section>

    <!--  COMO FUNCIONA  -->

    <section id="como" class="py-5 my-5">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="display-5 fw-bold">
                    Como Funciona
                </h2>

                <p class="text-muted">
                    Quatro passos simples.
                </p>

            </div>


            <div class="row text-center">


                <div class="col-lg-3">

                    <div class="step">

                        <div class="step-number">
                            1
                        </div>

                        <i class="bi bi-phone display-4 text-primary"></i>

                        <h5 class="mt-3">
                            Faz o agendamento
                        </h5>

                    </div>

                </div>


                <div class="col-lg-3">

                    <div class="step">

                        <div class="step-number">
                            2
                        </div>

                        <i class="bi bi-truck display-4 text-primary"></i>

                        <h5 class="mt-3">
                            Recolhemos 
                        </h5>

                    </div>

                </div>


                <div class="col-lg-3">

                    <div class="step">

                        <div class="step-number">
                            3
                        </div>

                        <i class="bi bi-droplet-fill display-4 text-primary"></i>

                        <h5 class="mt-3">
                            Lavamos
                        </h5>

                    </div>

                </div>


                <div class="col-lg-3">

                    <div class="step">

                        <div class="step-number">
                            4
                        </div>

                        <i class="bi bi-house-check-fill display-4 text-primary"></i>

                        <h5 class="mt-3">
                            Entregamos 
                        </h5>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--  TESTEMUNHOS  -->

    <section class="py-5 bg-light">


        <div class="container">

            <div class="text-center mb-5">

                <h2 class="display-5 fw-bold">
                    O que dizem os nossos clientes
                </h2>

            </div>


            <div class="row">


                <div class="col-lg-4 mb-4">

                    <div class="testimonial">

                       <img
                    src="img/Camila Aurora Machado.PNG"
                    class="testimonial-img"
                    alt="Mario Santos"
                    loading="lazy">

                <h5>
                    Camila Machado
                </h5>

                        <div class="stars" aria-label="5 estrelas">
                            ★★★★★
                        </div>

                        <p>
                            Excelente serviço. Muito rápidos e a roupa
                            vem sempre impecável.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4 mb-4">

                    <div class="testimonial">

                         <img
                    src="img/Isadora Vênus Albuquerque.PNG"
                    class="testimonial-img"
                    alt="Mario Santos"
                    loading="lazy">

                        <h5>
                           Isadora Alburquerque
                        </h5>

                        <div class="stars" aria-label="5 estrelas">
                            ★★★★★
                        </div>

                        <p>
                            Serviço de recolha fantástico.
                            Nunca mais precisei de perder tempo.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4 mb-4">

                    <div class="testimonial">

                        <img src="img/imagem a.png" class="testimonial-img" alt="André Martins" loading="lazy">

                        <h5>
                            André Martins
                        </h5>

                        <div class="stars" aria-label="5 estrelas">
                            ★★★★★
                        </div>

                        <p>
                            Muito profissionais.
                            Recomendo a toda a gente.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

<!-- ACCORDION -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                <h2 class="mb-4">FAQ</h2>

                <div class="accordion" id="faqAccordion">

                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-1">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faq-collapse-1"
                                aria-expanded="false" aria-controls="faq-collapse-1">
                                E se alguma peça ficar danificada?
                            </button>
                        </h3>
                        <div id="faq-collapse-1" class="accordion-collapse collapse"
                            aria-labelledby="faq-heading-1" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Embora tenhamos todo o cuidado no tratamento das suas peças, reconhecemos que podem ocorrer imprevistos. Caso isso aconteça, oferecemos um crédito em serviços no valor aproximado da peça danificada, ou, em alternativa, o reembolso do valor correspondente, consoante a preferência do cliente.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-2">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faq-collapse-2"
                                aria-expanded="false" aria-controls="faq-collapse-2">
                                Como faço o pagamento?
                            </button>
                        </h3>
                        <div id="faq-collapse-2" class="accordion-collapse collapse"
                            aria-labelledby="faq-heading-2" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Aceitamos pagamento em numerário, MB Way e multibanco, e pode ser feito no momento da entrega ou através do site.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-3">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faq-collapse-3"
                                aria-expanded="false" aria-controls="faq-collapse-3">
                                Qual é o prazo de entrega?
                            </button>
                        </h3>
                        <div id="faq-collapse-3" class="accordion-collapse collapse"
                            aria-labelledby="faq-heading-3" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Normalmente entre 24 a 48 horas após a recolha, dependendo do tipo de serviço.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-4">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faq-collapse-4"
                                aria-expanded="false" aria-controls="faq-collapse-4">
                                Como sei que a minha roupa não se vai misturar com a de outros clientes?
                            </button>
                        </h3>
                        <div id="faq-collapse-4" class="accordion-collapse collapse"
                            aria-labelledby="faq-heading-4" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Cada encomenda é identificada individualmente com etiqueta própria desde a recolha até à entrega, garantindo que recebe exatamente as suas peças.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mantenha apenas uma secção do mapa -->
<section style="display: flex; justify-content: center; margin-bottom: 3%;">
    <div id="map" style="height: 400px; width: 50%;"></div>
</section>

    <!-- ==================== CONTACTOS ==================== -->

<section id="contactos" class="contact-section">

<div class="container">

    <div class="row align-items-center">


        <div class="col-lg-6">

            <h2 class="display-5 fw-bold">
                Fale connosco
            </h2>

            <p>
                Estamos disponíveis para esclarecer
                qualquer dúvida.
            </p>


            <div class="contact-item">

                <i class="bi bi-telephone-fill"></i>

                <a
                    href="tel:+351266742593"
                    class="text-decoration-none">

                    266 742 593

                </a>

            </div>


            <div class="contact-item">

                <i class="bi bi-envelope-fill"></i>

                <a
                    href="mailto:LavaFácil.pt@gmail.com"
                    class="text-decoration-none">

                    LavaFácil.pt@gmail.com

                </a>

            </div>


            <div class="contact-item">

                <i class="bi bi-geo-alt-fill"></i>

                <span>
                    Edifício Start-up Montemor-o-Novo,
                    situado na Zona Industrial da ADUA,
                    Lote 38
                </span>

            </div>

        </div>

<div class="col-lg-6" id="#contactos">

            <!-- Mensagem de feedback (sucesso/erro) -->
            <div id="contactFeedback" class="alert d-none" role="alert"></div>

            <form
                id="contactForm"
                action="contactos.php"
                method="post"
                novalidate>

                <div class="mb-3">

                    <label for="nome" class="visually-hidden">
                        Nome
                    </label>

                    <input
                        id="nome"
                        name="nome"
                        type="text"
                        class="form-control"
                        placeholder="Nome"
                        autocomplete="name"
                        required>

                </div>


                <div class="mb-3">

                    <label for="email" class="visually-hidden">
                        Email
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="form-control"
                        placeholder="Email"
                        autocomplete="email"
                        required>

                </div>


                <div class="mb-3">

                    <label for="mensagem" class="visually-hidden">
                        Mensagem
                    </label>

                    <textarea
                        id="mensagem"
                        name="mensagem"
                        class="form-control"
                        rows="5"
                        placeholder="Mensagem"
                        required></textarea>

                </div>


                <button
                    type="submit"
                    id="contactSubmitBtn"
                    class="btn btn-primary btn-lg w-100">

                    Enviar Mensagem

                </button>

            </form>

        </div>

    </div>

</div>

</section>
<br>

<script src="assets/js/contactos.js"></script>

<br>


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
                    aria-label="Instagram"
                    class="text-decoration-none">

                    <i class="bi bi-instagram social"></i>

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



    <script src="public/assets/js/scripts.js"></script>
    <script src="public/assets/js/lib/bootstrap.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
    <script src="public/assets/js/mapa.js"></script>
    <script src="public/assets/js/lib/jquery.js"></script>
</body>



</html>