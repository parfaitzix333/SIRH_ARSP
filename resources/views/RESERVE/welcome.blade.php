<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Portail officiel de l'ARSP, Autorité de Régulation de la Sous-traitance dans le Secteur Privé.">
    <title>ARSP | Haut-Katanga</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --navy: #092b3c;
            --blue: #126b80;
            --gold: #e6b84f;
            --paper: #f3f6f4;
            --ink: #193544;
        }

        body {
            color: var(--ink);
            font-family: 'Manrope', sans-serif;
        }

        .topline {
            background: #061e2b;
            color: #e8f0ef;
            font-size: .78rem;
        }

        .topline a {
            color: inherit;
            text-decoration: none;
        }

        .hero {
            min-height: 690px;
            position: relative;
            overflow: hidden;
            color: #fff;
            background-color: var(--navy);
            background-position: center 38%;
            background-size: cover;
            transition: background-image .4s ease;
        }

        .hero::before {
            position: absolute;
            inset: 0;
            content: '';
            background: linear-gradient(90deg, rgba(5, 28, 41, .94), rgba(5, 28, 41, .76) 48%, rgba(5, 28, 41, .2));
        }

        .hero>* {
            position: relative;
            z-index: 1;
        }

        .site-nav {
            border-bottom: 1px solid rgba(255, 255, 255, .2);
        }

        .site-nav .nav-link,
        .site-nav .navbar-brand {
            color: #fff;
        }

        .site-nav .nav-link:hover {
            color: var(--gold);
        }

        .brand-logo {
            width: 100%;
            height: 56px;
            object-fit: contain;
        }

        .hero-copy {
            max-width: 760px;
            padding-top: 100px;
            padding-bottom: 160px;
        }

        .hero-copy.is-animating>* {
            animation: hero-rise-in .7s ease both;
        }

        .hero-copy.is-animating>*:nth-child(2) {
            animation-delay: .08s;
        }

        .hero-copy.is-animating>*:nth-child(3) {
            animation-delay: .16s;
        }

        .hero-copy.is-animating>*:nth-child(4) {
            animation-delay: .24s;
        }

        @keyframes hero-rise-in {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #mainNav.collapsing {
            transition: height 1s ease;
        }

        @media (prefers-reduced-motion: reduce) {
            .hero-copy.is-animating>* {
                animation-duration: .01ms;
                animation-delay: 0s;
            }

            #mainNav.collapsing {
                transition-duration: .01ms;
            }
        }

        .eyebrow {
            color: var(--gold);
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .hero h1 {
            max-width: 760px;
            margin: 14px 0 20px;
            font-size: clamp(2.4rem, 5vw, 4.4rem);
            font-weight: 800;
            line-height: 1.08;
        }

        .hero-copy>p:not(.eyebrow) {
            max-width: 620px;
            color: #e0e9e8;
            line-height: 1.8;
        }

        .btn-gold {
            background: var(--gold);
            border: 1px solid var(--gold);
            color: #102e3a;
            font-weight: 800;
        }

        .btn-gold:hover {
            background: #f1cb70;
            border-color: #f1cb70;
            color: #102e3a;
        }

        .slide-controls {
            position: absolute;
            right: max(24px, calc((100vw - 1140px) / 2));
            bottom: 104px;
            z-index: 2;
            display: flex;
            gap: 10px;
        }

        .slide-controls button {
            width: 44px;
            height: 44px;
            border: 1px solid rgba(255, 255, 255, .7);
            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
            color: #fff;
        }

        .notice {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 2;
            padding: 17px 0;
            border-bottom: 4px solid var(--gold);
            background: #fff;
            color: var(--ink);
        }

        .notice-label {
            color: #9a3130;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .06em;
        }

        .partners {
            padding: 34px 0;
            background: var(--paper);
            border-bottom: 1px solid #dfe7e4;
        }

        .partner-name {
            color: #536c72;
            font-size: .83rem;
            font-weight: 800;
            text-align: center;
        }

        .info_arsp-section {
            padding: 76px 0;
            background: #fff;
        }

        .info_arsp-heading {
            margin-bottom: 32px;
        }

        .info_arsp-heading h2 {
            color: var(--navy);
            font-weight: 800;
        }

        .accordion-item {
            margin-bottom: 12px;
            border: 1px solid #e2e9e7 !important;
            border-radius: 6px !important;
            overflow: hidden;
        }

        .accordion-button {
            color: var(--navy);
            font-weight: 700;
        }

        .accordion-button:not(.collapsed) {
            background: #f3f7f5;
            color: var(--blue);
            box-shadow: none;
        }

        footer {
            padding: 58px 0 20px;
            background: #071e2a;
            color: #c2d0d1;
            font-size: .88rem;
        }

        footer h2 {
            color: #fff;
            font-size: .9rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        footer a {
            color: #c2d0d1;
            text-decoration: none;
        }

        footer a:hover {
            color: var(--gold);
        }

        .footer-links {
            display: grid;
            gap: 10px;
            padding: 0;
            list-style: none;
        }

        @media (max-width: 767.98px) {
            .hero {
                min-height: 720px;
            }

            .hero-copy {
                padding-top: 72px;
                padding-bottom: 190px;
            }

            .hero h1 {
                font-size: 2.55rem;
            }

            .slide-controls {
                right: 20px;
                bottom: 118px;
            }
        }

        #heroCarousel {
            height: 98vh;
        }
    </style>
</head>

<body>
    <div class="topline py-2">
        <div class="container d-flex flex-wrap justify-content-between gap-2">
            <div><i class="fa-solid fa-phone me-2"></i>+243 824 940 440 <span class="mx-2">|</span> <a
                    href="mailto:contact@arsp.cd"><i class="fa-solid fa-envelope me-2"></i>contact@arsp.cd</a></div>
            <strong>ARSP, pour l'émergence des entrepreneurs congolais</strong>
        </div>
    </div>

    <header class="hero" id="heroCarousel" style="background-image: url('{{ asset('image/president_felix1.jpg') }}')">
        <nav class="navbar navbar-expand-lg site-nav">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}"
                    aria-label="Accueil ARSP">
                    <img class="brand-logo"
                        src="https://arsp.cd/_next/image?url=%2Fassets%2Fimages%2Flogos%2FlogoNew.png&w=256&q=75"
                        alt="Logo ARSP">
                    <span class="fw-bold"><small class="d-block fw-normal">HAUT-KATANGA</small></span>
                </a>
                <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Ouvrir le menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="#apropos">À propos</a></li>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Enregistrement</a>
                            <ul class="dropdown-menu">
                                @if (Route::has('form_employe_register'))
                                    <li><a class="dropdown-item" href="{{ route('form_employe_register') }}">Créer un
                                            compte employé</a></li>
                                @endif
                                @if (Route::has('register'))
                                    <li><a class="dropdown-item" href="{{ route('register') }}">Créer un compte</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Connexion</a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if (Route::has('login'))
                                    <li><a class="dropdown-item" href="{{ route('login') }}">Connexion au portail</a>
                                    </li>
                                @endif
                                @if (Route::has('form_employe_login'))
                                    <li><a class="dropdown-item" href="{{ route('form_employe_login') }}">Connexion
                                            employé</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item ms-lg-2"><a class="btn btn-gold btn-sm px-3" href="#contact">Nous
                                contacter</a></li>
                    </ul>
                </div>
            </div>

        </nav>

        <div class="container hero-copy is-animating">
            <p class="eyebrow mb-2">Régulation et accompagnement</p>
            <h1 id="heroTitle">Garantir l'application de la loi pour une sous-traitance équitable et durable.</h1>
            <p id="heroSubtitle">À travers le contrôle, l'accompagnement et la protection des entreprises éligibles,
                l'ARSP veille au respect du cadre légal et garantit un accès équitable aux opportunités de
                sous-traitance.</p>
            <a class="btn btn-gold rounded-pill px-4 py-3 mt-3" href="#contact">Contacter l'ARSP <i
                    class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>

        <div class="slide-controls" aria-label="Commandes du carrousel">
            <button type="button" id="prevBtn" aria-label="Diapositive précédente"><i
                    class="fa-solid fa-chevron-left"></i></button>
            <button type="button" id="nextBtn" aria-label="Diapositive suivante"><i
                    class="fa-solid fa-chevron-right"></i></button>
        </div>
        <div class="ligne_tricolore row g-0 position-absolute bottom-0 start-0 end-0" style="height: 4px;">
            <div class="bg-primary bleu col" style="height: 4px;"></div>
            <div class="bg-warning jaune col" style="height: 4px;"></div>
            <div class="bg-danger rouge col" style="height: 4px;"></div>
        </div>
        <div class="notice">
            <div class="container d-flex flex-wrap align-items-center gap-2 gap-md-3">
                <span class="notice-label"><i class="fa-solid fa-triangle-exclamation me-2"></i>AVIS OFFICIEL</span>
                <span class="small">L'ARSP poursuit le contrôle de conformité des entreprises de sous-traitance sur
                    l'ensemble du territoire national.</span>
            </div>
        </div>
    </header>
    <div class="card" id="apropos"></div>
    <div class="card-body">
        <h2 class="card-text container-fluid"><strong>{{ $apropos_arsp->titre }}</strong></h2>
        <div class="container-fluid p-4 bg-light rounded-3">
            <p class="card-text">{{ $apropos_arsp->nos_info }}</p>
        </div>
    </div>
    </div>

    <section class="partners" aria-label="Partenaires institutionnels">
        <div class="container">
            <div class="row align-items-center justify-content-center g-4">
                <div class="col-6 col-md-2 partner-name">MINISTÈRE DES PME</div>
                <div class="col-6 col-md-2 partner-name">RAWSUR</div>
                <div class="col-6 col-md-2 partner-name">GOUVERNEMENT</div>
                <div class="col-6 col-md-2 partner-name">APROCM</div>
                <div class="col-6 col-md-2 partner-name">FOGEC</div>
                <div class="col-6 col-md-2 partner-name">PRÉSIDENCE</div>
            </div>
        </div>
    </section>



    <footer id="contact">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <img src="{{ asset('image/logo.jpeg') }}" alt="Logo ARSP" width="58" height="58"
                        class="mb-3 rounded-circle bg-white p-1">
                    <p>L'Autorité de Régulation de la Sous-traitance dans le Secteur Privé est l'organe technique du
                        Gouvernement chargé de réguler les activités de sous-traitance.</p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h2>Navigation</h2>
                    <ul class="footer-links">
                        <li><a href="#apropos">L'institution</a></li>
                        <li><a href="#">Actualités</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h2>Cadre légal</h2>
                    <ul class="footer-links">
                        <li><a href="#">Loi n° 17/001</a></li>
                        <li><a href="#">Guide sectoriel</a></li>
                        <li><a href="#">Décrets et arrêtés</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h2>Nous contacter</h2>
                    <p><a href="https://www.google.com/maps/search/?api=1&amp;query={{ $contact->latitude }},{{ $contact->longitude }}"
                            target="_blank" rel="noopener noreferrer">
                            <i class="fa-solid fa-location-dot me-2"></i>{{ $contact->adresse }}
                        </a></p>
                    <p><i class="fa-solid fa-phone me-2"></i>+243 824 940 440</p><a href="mailto:contact@arsp.cd"><i
                            class="fa-solid fa-envelope me-2"></i>contact@arsp.cd</a>
                </div>
            </div>
            <hr class="mt-5 border-secondary">
            <p class="mb-0 small text-center">© {{ date('Y') }} ARSP RDC</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            const slides = [{
                    image: "{{ asset('image/president_felix1.jpg') }}",
                    title: "Garantir l'application de la loi pour une sous-traitance équitable et durable.",
                    subtitle: "À travers le contrôle, l'accompagnement et la protection des entreprises éligibles, l'ARSP veille au respect du cadre légal et garantit un accès équitable aux opportunités de sous-traitance."
                },
                {
                    image: "{{ asset('image/president_felix2.jpg') }}",
                    title: "Construire une sous-traitance congolaise structurée et compétitive.",
                    subtitle: "Par une régulation moderne et un accompagnement permanent, l'ARSP contribue au développement d'un écosystème inclusif et ouvert à des partenariats équitables."
                },
                {
                    image: "{{ asset('image/president_felix3.jpg') }}",
                    title: "Promouvoir l'excellence et l'innovation locale.",
                    subtitle: "Nous soutenons les entrepreneurs congolais dans leur croissance et leur mise en conformité avec les standards en vigueur."
                },
                {
                    image: "{{ asset('image/president_felix4.jpg') }}",
                    title: "Un cadre légal strict pour des opportunités réelles.",
                    subtitle: "L'ARSP protège les entreprises de sous-traitance et veille à l'équité dans l'attribution des marchés."
                }
            ];
            const hero = document.getElementById('heroCarousel');
            const title = document.getElementById('heroTitle');
            const subtitle = document.getElementById('heroSubtitle');
            const heroCopy = document.querySelector('.hero-copy');
            let current = 0;

            function showSlide(index) {
                current = (index + slides.length) % slides.length;
                hero.style.backgroundImage = `url('${slides[current].image}')`;
                title.textContent = slides[current].title;
                subtitle.textContent = slides[current].subtitle;
                heroCopy.classList.remove('is-animating');
                void heroCopy.offsetWidth;
                heroCopy.classList.add('is-animating');
            }

            document.getElementById('prevBtn').addEventListener('click', () => showSlide(current - 1));
            document.getElementById('nextBtn').addEventListener('click', () => showSlide(current + 1));
            window.setInterval(() => showSlide(current + 1), 10000);
        })();
    </script>
</body>

</html>
