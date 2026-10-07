<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'ARSP Haut-Katanga')</title>
    <link rel="icon" href="{{ asset('image/logo.jpeg') }}" type="image/jpeg">

    {{-- Préchargement des ressources critiques --}}
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    {{-- Feuilles de style --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        :root {
            --primary: #0a4b7a;
            --primary-light: #1a6ba8;
            --accent: #dc3545;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #212529;
            position: relative;
            overflow-x: hidden;
        }

        /* Image de fond + flou global */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image: url('https://www.wordsjustforyou.com/wp-content/uploads/2020/12/Happy-New-Year-2026-GIF-77701201225.gif');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            filter: blur(6px) brightness(0.85);
            transform: scale(1.05);
            /* évite les bords blancs dus au blur */
            z-index: -2;
        }

        /* Voile sombre pour le contraste */
        body::after {
            content: "";
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, rgba(10, 75, 122, 0.55), rgba(0, 0, 0, 0.65));
            z-index: -1;
        }

        /* Carte centrale */
        .corps {
            width: 100%;
            max-width: 720px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 18px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
            animation: fadeUp 0.6s ease-out;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .corps-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: #fff;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .corps-header img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #fff;
            padding: 3px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        }

        .corps-header .brand-name {
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: 0.3px;
            line-height: 1.1;
        }

        .corps-header .brand-sub {
            font-size: 0.78rem;
            opacity: 0.85;
        }

        .corps-body {
            padding: 32px 28px;
            text-align: center;
        }

        .icon-info {
            width: 72px;
            height: 72px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fff3cd, #ffe69c);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.35);
        }

        .icon-info i {
            font-size: 32px;
            color: #b8860b;
        }

        .welcome-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 6px;
        }

        .welcome-title i {
            color: #ffc107;
            margin-right: 6px;
        }

        .welcome-sub {
            color: #6c757d;
            font-size: 0.92rem;
            margin-bottom: 22px;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid var(--primary);
            border-radius: 8px;
            padding: 16px 18px;
            text-align: left;
            font-size: 0.95rem;
            color: #495057;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .info-box .steps {
            margin: 10px 0 0 0;
            padding-left: 20px;
        }

        .info-box .steps li {
            margin-bottom: 4px;
        }

        .btn-logout {
            background: linear-gradient(135deg, #dc3545, #b02a37);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 50px;
            font-size: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 6px 18px rgba(220, 53, 69, 0.35);
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(220, 53, 69, 0.5);
            color: #fff;
        }

        .btn-logout:active {
            transform: translateY(0);
        }

        .footer-note {
            margin-top: 18px;
            font-size: 0.78rem;
            color: #adb5bd;
        }

        @media (max-width: 576px) {
            .corps-body {
                padding: 24px 18px;
            }

            .welcome-title {
                font-size: 1.15rem;
            }

            .corps-header {
                padding: 14px 16px;
            }

            .corps-header .brand-name {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="corps">

        {{-- En-tête de la carte --}}
        <div class="corps-header">
            <img src="{{ asset('image/logo.jpeg') }}" alt="Logo ARSP">
            <div>
                <div class="brand-name">ARSP HAUT-KATANGA</div>
                <div class="brand-sub">Autorité de Régulation de la Sous-traitance</div>
            </div>
        </div>

        {{-- Corps --}}
        <div class="corps-body">

            <div class="icon-info">
                <i class="fas fa-compass"></i>
            </div>

            <div class="welcome-title">
                <i class="fas fa-hand-sparkles"></i>
                Bienvenue, {{ $user->name }} !
            </div>
            <p class="welcome-sub">Vous avez été redirigé(e) vers cette page de secours.</p>

            <div class="info-box">
                <strong><i class="fas fa-circle-info me-1"></i> Pourquoi cette page ?</strong>
                <ul class="steps">
                    <li>Vous venez de créer votre compte avec succès, ou</li>
                    <li>Vous vous êtes trompé(e) de chemin / URL.</li>
                </ul>
                <hr class="my-2">
                <strong><i class="fas fa-lightbulb me-1"></i> Que faire ?</strong>
                <ul class="steps">
                    <li>Déconnectez-vous puis reconnectez-vous.</li>
                    <li>Si le problème persiste, contactez l'administrateur.</li>
                </ul>
            </div>

            <form action="{{ route('logout') }}" method="post"
                onsubmit="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt me-2"></i> Se déconnecter
                </button>
            </form>

            <div class="footer-note">
                <i class="fas fa-shield-halved me-1"></i>
                © {{ date('Y') }} ARSP Haut-Katanga — Tous droits réservés
            </div>
        </div>
    </div>
</body>

</html>
