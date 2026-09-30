<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="icon" href="{{ asset('image/logo.jpeg') }}" type="image/png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Portail officiel de l'ARSP, Autorité de Régulation de la Sous-traitance dans le Secteur Privé.">
    <title>ARSP HAU-KATANGA</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        :root {
            --navy: #071d35;
            --blue: #0a4b7a;
            --cyan: #4bb3d3;
            --gold: #e6b84f;
            --paper: #f5f8fb;
            --ink: #183047;
            --muted: #657589;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .topline {
            background-color: rgba(4, 3, 82, 0.952);
            color: white;
            font-size: 0.85rem;
            position: relative;
            z-index: 12;
        }

        /* --- HERO CARROUSEL --- */
        .hero-section {
            position: relative;
            min-height: 95svh;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transition: background-image 1s ease-in-out;
            display: flex;
            flex-direction: column;
            color: white;
        }

        /* Overlay sombre */
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, rgba(7, 29, 53, 0.95) 0%, rgba(7, 29, 53, 0.6) 50%, rgba(7, 29, 53, 0.2) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-left: 5%;
            max-width: 800px;
            /* Animation initiale */
            animation: slideUp 0.8s ease-out forwards;
        }

        /* Animation du texte */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-title {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-subtitle {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: #e0e0e0;
            max-width: 600px;
        }

        .btn-contact-hero {
            background-color: white;
            color: var(--navy);
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-contact-hero:hover {
            background-color: var(--gold);
            color: var(--navy);
        }

        /* --- NAVIGATION (VOS CLASSES D'ORIGINE) --- */
        .nav-content {
            background: transparent;
            z-index: 10;
            position: relative;
        }

        .nav-content.is-fixed {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1030;
            background: rgba(7, 29, 53, .96) !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .24);
        }

        .logo_detoure {
            flex: 0 0 auto;
        }

        .logo_detoure img {
            display: block;
            width: auto;
            max-width: 160px;
            height: 60px;
            object-fit: contain;
        }

        .button-containt {
            box-shadow: 2px 4px 6px rgba(115, 115, 117, 0.952);
            color: rgb(240, 240, 247);
            border-radius: 20px;
            padding: 0 8px;
        }

        .button-containt li {
            color: rgb(4, 4, 131);
            font-size: 11px;
        }

        .button-containt #btn {
            color: rgb(240, 240, 247);
            font-size: 0.85rem;
            text-transform: uppercase;
            font-weight: 600;
        }

        .button-containt #btn:hover {
            color: var(--gold);
        }

        .dropdown-toggle::after {
            border: none;
            content: "\f107";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            vertical-align: middle;
            margin-left: 5px;
        }

        .bloc-lang {
            border-radius: 20px;
            border: 1px solid rgb(114, 113, 113);
            padding: 0;
            box-shadow: 2px 4px 6px rgba(115, 115, 117, 0.952);
            display: inline-flex;
        }

        .bloc-lang img {
            display: block;
            width: 24px;
            height: 16px;
            object-fit: cover;
        }

        .bloc-lang .btn {
            display: inline-flex;
            align-items: center;
            padding: 4px 6px;
            background: #fff;
            border: 0;
        }

        .bloc-lang .btn.active {
            background: var(--gold);
        }

        .bloc-lang .btn:focus-visible {
            outline: 2px solid var(--gold);
            outline-offset: 2px;
        }

        .nav-emblem {
            flex: 0 0 auto;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, .65);
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 .2rem rgba(230, 184, 79, .4);
        }

        /* --- BOUTONS SCROLL --- */
        .scroll-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid white;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .scroll-btn:hover {
            background: white;
            color: var(--navy);
        }

        /* --- AVIS OFFICIEL BANNER --- */
        .avis-banner {
            background-color: white;
            border-bottom: 5px solid var(--gold);
            padding: 15px 0;
            position: relative;
            z-index: 5;
        }

        .badge-avis {
            background-color: #ffeaea;
            color: #d63031;
            border: 1px solid #ffcccc;
            border-radius: 20px;
            padding: 5px 15px;
            font-weight: bold;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* --- PARTENAIRES --- */
        .partners-section {
            background-color: var(--paper);
            padding: 30px 0;
            border-bottom: 1px solid #ddd;
        }

        .partner-logo {
            max-height: 50px;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: all 0.3s;
        }

        .partner-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
        }

        /* --- FOOTER --- */
        footer {
            background-color: #040b17;
            color: #b0b8c1;
            padding: 60px 0 20px;
            font-size: 0.9rem;
        }

        footer h5 {
            color: white;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-size: 0.9rem;
            border-left: 3px solid var(--gold);
            padding-left: 10px;
        }

        footer ul {
            list-style: none;
            padding: 0;
        }

        footer ul li {
            margin-bottom: 10px;
        }

        footer ul li a {
            color: #b0b8c1;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer ul li a:hover {
            color: var(--gold);
        }

        .footer-contact-item {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .footer-contact-item i {
            color: var(--gold);
            margin-top: 4px;
        }

        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 5px;
            margin-right: 10px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .social-icons a:hover {
            background-color: var(--gold);
            color: var(--navy);
        }

        .btn-footer-outline {
            border: 1px solid white;
            color: white;
            border-radius: 50px;
            width: 100%;
            padding: 10px;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 0.8rem;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-footer-outline:hover {
            background-color: white;
            color: var(--navy);
        }

        @media (max-width: 991.98px) {
            .nav-content .navbar-collapse {
                margin-top: 12px;
                padding: 12px;
                border: 1px solid rgba(255, 255, 255, .2);
                border-radius: 8px;
                background: rgba(7, 29, 53, .96);
            }

            .button-containt {
                align-items: stretch;
                padding: 0;
                box-shadow: none;
            }

            .button-containt #btn,
            .button-containt>.btn {
                text-align: left;
            }

            .nav-emblem {
                margin-top: 10px;
                padding-top: 12px;
                border-top: 1px solid rgba(255, 255, 255, .2);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .topline>.col {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .hero-section {
                min-height: 100svh;
            }

            .hero-content {
                width: 100%;
                padding: 56px 24px 104px;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
                line-height: 1.65;
            }

            .btn-contact-hero {
                padding: 11px 22px;
            }

            .scroll-controls {
                padding: 12px !important;
            }

            .scroll-btn {
                width: 42px;
                height: 42px;
            }

            .avis-banner .container {
                align-items: flex-start !important;
                gap: 10px;
            }

            footer {
                padding: 42px 0 20px;
            }
        }

        @media (max-width: 400px) {
            .hero-content {
                padding-right: 18px;
                padding-left: 18px;
            }

            .hero-title {
                font-size: 1.75rem;
            }

            .topline p {
                overflow-wrap: anywhere;
            }
        }
    </style>
</head>

<body>
    @include('partials.sablier')

    <!-- =========================
         HEADER
    ========================== -->
    <header class="hero-section" id="heroCarousel">
        <div class="hero-overlay"></div>

        <!-- TOP LINE (Votre structure) -->
        <div class="topline py-0 text-center row m-0 mb-3">
            <div class="col p-1">
                <p class="mb-0">
                    <i class="fa fa-phone"></i> {{ $contact->tel ?? '--' }} |
                    <i class="fa fa-envelope"></i> {{ $contact->email ?? 'contact@arsp.cd' }}
                </p>
            </div>
            <div class="col p-1">
                <p class="mb-0 fw-bold">
                    <span data-i18n="slogan">« ARSP pour l'émergence des entrepreneurs Congolais. »</span>
                </p>
            </div>

            <div class="col p-1 d-flex align-items-center justify-content-center">
                <a href="#" class="btn" aria-label="Facebook"><i
                        class="fa-brands fa-facebook-f text-white"></i></a>
                <a href="#" class="btn" aria-label="LinkedIn"><i
                        class="fa-brands fa-linkedin-in text-white"></i></a>
                <a href="#" class="btn" aria-label="Twitter"><i
                        class="fa-brands fa-twitter text-white"></i></a>
                <a href="#" class="btn" aria-label="Instagram"><i
                        class="fa-brands fa-instagram text-white"></i></a>
                <!-- LANGUES -->
                <div>
                    <div class="bloc-lang p-0 gap-1 input-group px-0 ms-2">
                        <button type="button" class="btn position-relative input-group-text btn-sm language-button"
                            data-language="en" aria-label="Switch to English" aria-pressed="false" title="English">
                            <img src="{{ asset('image/american.jpg') }}" alt="Anglais">
                        </button>
                        <button type="button"
                            class="btn position-relative input-group-text btn-sm language-button active"
                            data-language="fr" aria-label="Passer en français" aria-pressed="true" title="Français">
                            <img src="{{ asset('image/french.jpg') }}" alt="Français">
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- NAVIGATION (Vos boutons exacts) -->
        <div id="navPlaceholder" aria-hidden="true" style="display: none;"></div>
        <nav class="navbar navbar-expand-lg nav-content bg-transparent px-3 py-2" id="siteNav">
            <a class="navbar-brand logo_detoure" href="{{ url('/') }}" aria-label="Accueil ARSP">
                <img src="https://arsp.cd/_next/image?url=%2Fassets%2Fimages%2Flogos%2FlogoNew.png&w=256&q=75"
                    alt="Logo ARSP">
            </a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Ouvrir le menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <div class="button-containt navbar-nav ms-lg-auto d-flex justify-content-end align-items-lg-center">
                    <!-- ACCUEIL -->
                    <a href="{{ url('/') }}" class="btn me-lg-3 text-light" id="btn"
                        data-i18n="home">ACCUEIL</a>

                    <!-- À PROPOS -->
                    <div class="dropdown">
                        <button type="button" class="btn dropdown-toggle text-light" data-bs-toggle="dropdown"
                            id="btn" data-i18n="about">À PROPOS</button>
                        <div class="dropdown-menu dropdown-menu-end bg-light">
                            <a href="#apropos_arsp" class="dropdown-item" data-i18n="aboutUs">À PROPOS DE NOUS</a>
                        </div>
                    </div>

                    <!-- ENREGISTREMENT -->
                    <div class="dropdown">
                        <button type="button" class="btn dropdown-toggle text-light" data-bs-toggle="dropdown"
                            id="btn" data-i18n="registration">ENREGISTREMENT</button>
                        <div class="dropdown-menu dropdown-menu-end bg-light">
                            <a href="{{ route('register') }}" class="dropdown-item"
                                data-i18n="userRegistration">ENREGISTREMENT UTILISATEUR</a>
                            <a href="{{ route('form_employe_register') }}" class="dropdown-item"
                                data-i18n="employeeRegistration">ENREGISTREMENT EMPLOYE</a>
                        </div>
                    </div>

                    <!-- CONNEXION -->
                    <div class="dropdown">
                        <button type="button" class="btn dropdown-toggle text-light" data-bs-toggle="dropdown"
                            id="btn" data-i18n="login">CONNEXION</button>
                        <div class="dropdown-menu dropdown-menu-end bg-light">
                            <a href="{{ route('login') }}" class="dropdown-item"
                                data-i18n="emailLogin">CONNEXION/EMAIL</a>
                            <a href="{{ route('form_employe_login') }}" class="dropdown-item"
                                data-i18n="employeeLogin">CONNEXION/MATRICULE</a>
                        </div>
                    </div>
                </div>

                <!-- EMBLÈME -->
                <div class="nav-emblem d-flex justify-content-start align-items-center">
                    <img src="{{ asset('image/embleme1.jpeg') }}" id="embleme" alt="Emblème"
                        style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <p class="text-white mx-2">|</p>
                    <a href="#apropos_arsp" class="btn rounded-4 text-light shadow-lg btn-sm p-2"
                        style="border: 1px solid white;" data-i18n="tenders">APPEL D'OFFRES</a>
                </div>
            </div>
        </nav>

        <!-- HERO CONTENT (Texte animé) -->
        <div class="container hero-content" id="heroTextContainer">
            <p class="text-warning fw-bold text-uppercase mb-2" style="letter-spacing: 2px;" data-i18n="eyebrow">
                Régulation et
                Accompagnement</p>
            <h1 class="hero-title" id="heroTitle">
                Garantir l'application de la loi pour une sous-traitance équitable et durable.
            </h1>
            <p class="hero-subtitle" id="heroSubtitle">
                À travers le contrôle, l'accompagnement et la protection des entreprises éligibles, l'ARSP veille au
                respect du cadre légal et garantit un accès équitable aux opportunités de sous-traitance.
            </p>
            <div>
                <a href="#apropos_arsp" class="btn-contact-hero">
                    <span data-i18n="contactArsp">Contacter l'ARSP</span> <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- BOUTONS SCROLL -->
        <div class="scroll-controls position-absolute bottom-0 end-0 p-4 d-flex gap-3" style="z-index: 10;">
            <div class="scroll-btn" id="prevBtn"><i class="fas fa-chevron-left"></i></div>
            <div class="scroll-btn" id="nextBtn"><i class="fas fa-chevron-right"></i></div>
        </div>
    </header>

    <!-- AVIS OFFICIEL BANNER -->
    <div class="avis-banner">
        <div class="container d-flex align-items-center flex-wrap">
            <span class="badge-avis me-3">
                <i class="fas fa-exclamation-triangle"></i> <span data-i18n="officialNotice">AVIS OFFICIEL</span>
            </span>
            <span class="text-muted small" data-i18n="noticeText">
                L'ARSP poursuit le contrôle rigoureux de la conformité des entreprises de sous-traitance à travers toute
                l'étendue du territoire national.
            </span>
        </div>
    </div>
    <div class="card-body" id="apropos_arsp">
        <h2 class="card-text container-fluid"><strong>{{ $apropos_arsp->titre }}</strong></h2>
        <div class="container-fluid p-4 bg-light rounded-3">
            <p class="card-text">{{ $apropos_arsp->nos_info }}</p>
        </div>
    </div>

    <!-- PARTENAIRES -->
    <section class="partners-section">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center g-4">
                <div class="col-6 col-md-2"><img src="https://via.placeholder.com/150x60?text=Ministère+PME"
                        alt="Partenaire" class="img-fluid partner-logo"></div>
                <div class="col-6 col-md-2"><img src="https://via.placeholder.com/150x60?text=RAWSUR"
                        alt="Partenaire" class="img-fluid partner-logo"></div>
                <div class="col-6 col-md-2"><img src="https://via.placeholder.com/150x60?text=Gouvernement"
                        alt="Partenaire" class="img-fluid partner-logo"></div>
                <div class="col-6 col-md-2"><img src="https://via.placeholder.com/150x60?text=APROCM"
                        alt="Partenaire" class="img-fluid partner-logo"></div>
                <div class="col-6 col-md-2"><img src="https://via.placeholder.com/150x60?text=FOGEC" alt="Partenaire"
                        class="img-fluid partner-logo"></div>
                <div class="col-6 col-md-2"><img src="https://via.placeholder.com/150x60?text=Présidence"
                        alt="Partenaire" class="img-fluid partner-logo"></div>
            </div>
        </div>
    </section>

    <!-- =========================
         FOOTER
    ========================== -->
    <footer id="contact">
        <div class="container">
            <div class="row g-4">
                <!-- Column 1: Logo & Desc -->
                <div class="col-lg-4 col-md-6">
                    <img src="https://arsp.cd/_next/image?url=%2Fassets%2Fimages%2Flogos%2FlogoNew.png&w=256&q=75"
                        alt="ARSP Logo" height="50" class="mb-3">
                    <p class="small text-muted mb-4" data-i18n="footerDescription">
                        L'Autorité de Régulation de la Sous-traitance dans le Secteur Privé (ARSP) est l'organe
                        technique du Gouvernement en matière de régulation des activités de sous-traitance.
                    </p>
                    <div class="social-icons">
                        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Column 2: Navigation -->
                <div class="col-lg-2 col-md-6">
                    <h5 data-i18n="navigation">Navigation</h5>
                    <ul>
                        <li><a href="#" data-i18n="institution">L'Institution</a></li>
                        <li><a href="#" data-i18n="services">Nos Services</a></li>
                        <li><a href="#" data-i18n="registration">Enregistrement</a></li>
                        <li><a href="#" data-i18n="registry">Registre</a></li>
                        <li><a href="#" data-i18n="news">Actualités</a></li>
                    </ul>
                </div>

                <!-- Column 3: Cadre Légal -->
                <div class="col-lg-3 col-md-6">
                    <h5 data-i18n="legalFramework">Cadre Légal</h5>
                    <ul>
                        <li><a href="#" data-i18n="law">Loi N°17/001</a></li>
                        <li><a href="#" data-i18n="sectorGuide">Guide Sectoriel</a></li>
                        <li><a href="#" data-i18n="decrees">Décrets & Arrêtés</a></li>
                        <li><a href="#" data-i18n="privacy">Confidentialité</a></li>
                        <li><a href="#" data-i18n="terms">Utilisation</a></li>
                    </ul>
                </div>

                <!-- Column 4: Contact -->
                <div class="col-lg-3 col-md-6">
                    <h5 data-i18n="contactUs">Nous Contacter</h5>
                    <div class="footer-contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span data-i18n="address">87, Avenue de l'Equateur<br>Commune de la Gombe /
                            Kinshasa<br>République démocratique du
                            Congo</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+243 824 940 440</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>contact@arsp.cd</span>
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&amp;query={{ $contact->latitude }},{{ $contact->longitude }}"
                        target="_blank" rel="noopener noreferrer" class="btn-footer-outline">
                        <i class="fas fa-map-marker-alt me-2"></i><span data-i18n="ourOffices">Nos Bureaux</span>
                    </a>
                </div>
            </div>

            <hr class="mt-5 mb-4 border-secondary">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted small">&copy; {{ date('Y', strtotime(now())) }} ARSP RDC</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-muted small me-3 text-decoration-none" data-i18n="sitemap">PLAN DU
                        SITE</a>
                    <a href="#" class="text-muted small text-decoration-none" data-i18n="legalNotice">MENTIONS
                        LÉGALES</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SCRIPT CARROUSEL (5 SECONDES) + ANIMATION -->
    <script>
        $(document).ready(function() {
            const siteNav = document.getElementById('siteNav');
            const navPlaceholder = document.getElementById('navPlaceholder');
            let navStart = siteNav.getBoundingClientRect().top + window.scrollY;

            function updateStickyNav() {
                const shouldFixNav = window.scrollY >= navStart;
                siteNav.classList.toggle('is-fixed', shouldFixNav);
                navPlaceholder.style.display = shouldFixNav ? 'block' : 'none';
                navPlaceholder.style.height = shouldFixNav ? `${siteNav.offsetHeight}px` : '0';
            }

            window.addEventListener('scroll', updateStickyNav, {
                passive: true
            });
            window.addEventListener('resize', () => {
                if (!siteNav.classList.contains('is-fixed')) {
                    navStart = siteNav.getBoundingClientRect().top + window.scrollY;
                }
                updateStickyNav();
            });
            updateStickyNav();

            const backgrounds = [
                "{{ asset('image/president_felix1.jpg') }}",
                "{{ asset('image/president_felix2.jpg') }}",
                "{{ asset('image/president_felix3.jpg') }}",
                "{{ asset('image/president_felix4.jpg') }}"
            ];

            const translations = {
                fr: {
                    slogan: '« ARSP pour l\'émergence des entrepreneurs Congolais. »',
                    home: 'ACCUEIL',
                    about: 'À PROPOS',
                    aboutUs: 'À PROPOS DE NOUS',
                    registration: 'ENREGISTREMENT',
                    userRegistration: 'ENREGISTREMENT UTILISATEUR',
                    employeeRegistration: 'ENREGISTREMENT EMPLOYÉ',
                    login: 'CONNEXION',
                    emailLogin: 'CONNEXION/EMAIL',
                    employeeLogin: 'CONNEXION/MATRICULE',
                    tenders: 'APPEL D\'OFFRES',
                    eyebrow: 'Régulation et Accompagnement',
                    contactArsp: 'Contacter l\'ARSP',
                    officialNotice: 'AVIS OFFICIEL',
                    noticeText: 'L\'ARSP poursuit le contrôle rigoureux de la conformité des entreprises de sous-traitance à travers toute l\'étendue du territoire national.',
                    footerDescription: 'L\'Autorité de Régulation de la Sous-traitance dans le Secteur Privé (ARSP) est l\'organe technique du Gouvernement en matière de régulation des activités de sous-traitance.',
                    navigation: 'Navigation',
                    institution: 'L\'Institution',
                    services: 'Nos Services',
                    registry: 'Registre',
                    news: 'Actualités',
                    legalFramework: 'Cadre Légal',
                    law: 'Loi N°17/001',
                    sectorGuide: 'Guide Sectoriel',
                    decrees: 'Décrets & Arrêtés',
                    privacy: 'Confidentialité',
                    terms: 'Utilisation',
                    contactUs: 'Nous Contacter',
                    address: '87, Avenue de l\'Equateur<br>Commune de la Gombe / Kinshasa<br>République démocratique du Congo',
                    ourOffices: 'Nos Bureaux',
                    sitemap: 'PLAN DU SITE',
                    legalNotice: 'MENTIONS LÉGALES'
                },
                en: {
                    slogan: '“ARSP for the growth of Congolese entrepreneurs.”',
                    home: 'HOME',
                    about: 'ABOUT',
                    aboutUs: 'ABOUT US',
                    registration: 'REGISTRATION',
                    userRegistration: 'USER REGISTRATION',
                    employeeRegistration: 'EMPLOYEE REGISTRATION',
                    login: 'SIGN IN',
                    emailLogin: 'SIGN IN / EMAIL',
                    employeeLogin: 'SIGN IN / EMPLOYEE ID',
                    tenders: 'CALL FOR TENDERS',
                    eyebrow: 'Regulation and Support',
                    contactArsp: 'Contact ARSP',
                    officialNotice: 'OFFICIAL NOTICE',
                    noticeText: 'ARSP continues rigorous compliance inspections of subcontracting companies throughout the national territory.',
                    footerDescription: 'The Regulatory Authority for Subcontracting in the Private Sector (ARSP) is the Government technical body responsible for regulating subcontracting activities.',
                    navigation: 'Navigation',
                    institution: 'The Institution',
                    services: 'Our Services',
                    registry: 'Registry',
                    news: 'News',
                    legalFramework: 'Legal Framework',
                    law: 'Law No. 17/001',
                    sectorGuide: 'Sector Guide',
                    decrees: 'Decrees & Orders',
                    privacy: 'Privacy',
                    terms: 'Terms of Use',
                    contactUs: 'Contact Us',
                    address: '87 Equateur Avenue<br>Gombe Municipality / Kinshasa<br>Democratic Republic of the Congo',
                    ourOffices: 'Our Offices',
                    sitemap: 'SITE MAP',
                    legalNotice: 'LEGAL NOTICE'
                }
            };

            const texts = [{
                    fr: {
                        title: "Garantir l'application de la loi pour une sous-traitance équitable et durable.",
                        subtitle: "À travers le contrôle, l'accompagnement et la protection des entreprises éligibles, l'ARSP veille au respect du cadre légal et garantit un accès équitable aux opportunités de sous-traitance."
                    },
                    en: {
                        title: 'Ensuring the law is applied for fair and sustainable subcontracting.',
                        subtitle: 'Through oversight, support, and the protection of eligible businesses, ARSP upholds the legal framework and ensures fair access to subcontracting opportunities.'
                    }
                },
                {
                    fr: {
                        title: "Construire une sous-traitance congolaise structurée et compétitive.",
                        subtitle: "À travers une régulation moderne et un accompagnement permanent, l'ARSP contribue au développement d'un écosystème de sous-traitance crédible, inclusif et capable d'attirer des partenariats équitables."
                    },
                    en: {
                        title: 'Building a structured and competitive Congolese subcontracting sector.',
                        subtitle: 'Through modern regulation and ongoing support, ARSP helps develop a credible, inclusive subcontracting ecosystem capable of attracting fair partnerships.'
                    }
                },
                {
                    fr: {
                        title: "Promouvoir l'excellence et l'innovation locale.",
                        subtitle: "Nous soutenons les entrepreneurs congolais dans leur croissance et leur mise en conformité avec les standards internationaux."
                    },
                    en: {
                        title: 'Promoting local excellence and innovation.',
                        subtitle: 'We support Congolese entrepreneurs as they grow and align their businesses with international standards.'
                    }
                },
                {
                    fr: {
                        title: "Un cadre légal strict pour des opportunités réelles.",
                        subtitle: "L'ARSP assure la protection des entreprises de sous-traitance et veille à l'équité dans l'attribution des marchés."
                    },
                    en: {
                        title: 'A strong legal framework for real opportunities.',
                        subtitle: 'ARSP protects subcontracting businesses and promotes fairness in the awarding of contracts.'
                    }
                }
            ];

            let currentIndex = 0;
            let currentLanguage = localStorage.getItem('arsp-language') === 'en' ? 'en' : 'fr';
            const totalSlides = backgrounds.length;
            const heroSection = $('#heroCarousel');
            const heroTextContainer = $('#heroTextContainer');
            const heroTitle = $('#heroTitle');
            const heroSubtitle = $('#heroSubtitle');

            function applyLanguage(language) {
                currentLanguage = language;
                document.documentElement.lang = language;
                document.querySelectorAll('[data-i18n]').forEach((element) => {
                    const key = element.dataset.i18n;
                    if (translations[language][key]) {
                        element.innerHTML = translations[language][key];
                    }
                });
                document.querySelectorAll('.language-button').forEach((button) => {
                    const selected = button.dataset.language === language;
                    button.classList.toggle('active', selected);
                    button.setAttribute('aria-pressed', selected ? 'true' : 'false');
                });
                heroTitle.text(texts[currentIndex][language].title);
                heroSubtitle.text(texts[currentIndex][language].subtitle);
                localStorage.setItem('arsp-language', language);
            }

            function changeSlide(index) {
                // Fondu du fond
                heroSection.css('opacity', '0.8');

                // Reset l'animation du texte (on retire la classe)
                heroTextContainer.removeClass('hero-content');

                setTimeout(() => {
                    // Changement image
                    heroSection.css('background-image', `url('${backgrounds[index]}')`);

                    // Changement texte
                    heroTitle.text(texts[index][currentLanguage].title);
                    heroSubtitle.text(texts[index][currentLanguage].subtitle);

                    // Retour opacité
                    heroSection.css('opacity', '1');

                    // Relance l'animation (on force le reflow)
                    void heroTextContainer[0].offsetWidth;
                    heroTextContainer.addClass('hero-content');
                }, 300);
            }

            document.querySelectorAll('.language-button').forEach((button) => {
                button.addEventListener('click', () => applyLanguage(button.dataset.language));
            });

            applyLanguage(currentLanguage);
            changeSlide(currentIndex);

            let autoSlide = setInterval(() => {
                currentIndex = (currentIndex + 1) % totalSlides;
                changeSlide(currentIndex);
            }, 5000);

            $('#nextBtn').click(function() {
                clearInterval(autoSlide);
                currentIndex = (currentIndex + 1) % totalSlides;
                changeSlide(currentIndex);
                autoSlide = setInterval(() => {
                    currentIndex = (currentIndex + 1) % totalSlides;
                    changeSlide(currentIndex);
                }, 5000);
            });

            $('#prevBtn').click(function() {
                clearInterval(autoSlide);
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                changeSlide(currentIndex);
                autoSlide = setInterval(() => {
                    currentIndex = (currentIndex + 1) % totalSlides;
                    changeSlide(currentIndex);
                }, 5000);
            });
        });
    </script>
</body>

</html>
