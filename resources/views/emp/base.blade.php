<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ARSP - Autorité de Régulation de la Sous-traitance dans le Secteur Privé">

    <title>@yield('title', 'ARSP HAU-KATANGA')</title>
    <link rel="icon" href="{{ asset('image/logo.jpeg') }}" type="image/jpeg">

    {{-- Préchargement des ressources critiques --}}
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    {{-- Feuilles de style --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    @include('dg.shared_style')

    <style>
        /* ============================================
           VARIABLES CSS - Cohérence du design
           ============================================ */
        :root {
            --primary-dark: #032e5a;
            --primary: #0a4b7a;
            --primary-light: #1e293b;
            --accent: #ffc107;
            --bg-body: #f4f6f9;
            --bg-white: #ffffff;
            --text-dark: #1f2937;
            --text-body: #374151;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
            --border-light: #f3f4f6;
            --header-height: 80px;
            --sidebar-width: 250px;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 20px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ============================================
           RESET & BASE
           ============================================ */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-body);
            line-height: 1.5;
            overflow-x: hidden;
            min-height: 100vh;
        }

        body.no-scroll {
            overflow: hidden;
        }

        /* Focus accessible */
        *:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }

        /* ============================================
           EN-TÊTE
           ============================================ */
        .app-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            box-shadow: var(--shadow-md);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .header-center {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            min-width: 0;
            padding: 0 10px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .logo-image {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--bg-white);
            transition: transform var(--transition);
            flex-shrink: 0;
        }

        .logo-image:hover {
            transform: scale(1.05);
        }

        .header-title {
            color: var(--bg-white);
            line-height: 1.2;
            min-width: 0;
        }

        .header-title h1 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        .header-title p {
            font-size: 0.7rem;
            font-weight: 300;
            margin: 0;
            opacity: 0.85;
            letter-spacing: 0.3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 320px;
        }

        /* Bouton toggle sidebar */
        .toggle-btn {
            display: none;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--bg-white);
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-size: 1.1rem;
            transition: var(--transition);
        }

        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Profil utilisateur */
        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--bg-white);
            font-size: 0.85rem;
            white-space: nowrap;
            padding: 6px 12px;
            border-radius: var(--radius-lg);
            background: rgba(255, 255, 255, 0.08);
            transition: var(--transition);
        }

        .user-info:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .user-info .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .user-info .user-details {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .user-info .user-name {
            font-weight: 500;
            font-size: 0.8rem;
        }

        .user-info .role-badge {
            font-size: 0.6rem;
            padding: 1px 8px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.15);
            color: var(--accent);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            align-self: flex-start;
            margin-top: 2px;
        }

        /* ============================================
           SÉLECTEUR ANNÉE
           ============================================ */
        .annee-selector {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 12px 4px 16px;
            border-radius: var(--radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: var(--transition);
            max-width: 280px;
            min-width: 160px;
        }

        .annee-selector:hover,
        .annee-selector:focus-within {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .annee-selector .annee-label {
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .annee-selector .annee-label i {
            margin-right: 4px;
            color: var(--accent);
        }

        .annee-selector select {
            background: transparent;
            border: none;
            color: var(--bg-white);
            font-size: 0.85rem;
            font-weight: 500;
            padding: 6px 4px;
            cursor: pointer;
            outline: none;
            min-width: 110px;
            max-width: 180px;
        }

        .annee-selector select option {
            background: var(--primary-dark);
            color: var(--bg-white);
            padding: 8px;
        }

        .annee-selector .select-arrow {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.7rem;
            pointer-events: none;
        }

        /* ============================================
           SIDEBAR
           ============================================ */
        .app-sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--bg-white);
            border-right: 1px solid var(--border-color);
            padding: 20px 0;
            overflow-y: auto;
            z-index: 900;
            transition: transform var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .app-sidebar .nav-section {
            padding: 0 15px;
            margin-bottom: 20px;
        }

        .app-sidebar .nav-section-title {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            padding: 0 12px 8px;
        }

        .app-sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            margin-bottom: 3px;
            border-radius: var(--radius-sm);
            color: var(--text-body);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
            border-left: 3px solid transparent;
        }

        .app-sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .app-sidebar .nav-link:hover {
            background: #f1f5f9;
            color: var(--primary);
            border-left-color: var(--primary);
        }

        .app-sidebar .nav-link:hover i {
            color: var(--primary);
        }

        .app-sidebar .nav-link.active {
            background: linear-gradient(90deg, rgba(10, 75, 122, 0.1) 0%, transparent 100%);
            color: var(--primary);
            border-left-color: var(--primary);
            font-weight: 600;
        }

        .app-sidebar .nav-link.active i {
            color: var(--primary);
        }

        .app-sidebar .logout-wrapper {
            margin-top: 20px;
            padding: 0 15px;
        }

        .app-sidebar .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 11px 14px;
            border: none;
            border-radius: var(--radius-sm);
            background: linear-gradient(135deg, #dc3545, #b02a37);
            color: var(--bg-white);
            font-weight: 600;
            transition: var(--transition);
            cursor: pointer;
        }

        .app-sidebar .logout-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(220, 53, 69, 0.25);
        }

        /* Overlay mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: var(--header-height) 0 0 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 850;
            opacity: 0;
            transition: opacity var(--transition);
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* ============================================
           CONTENU PRINCIPAL
           ============================================ */
        .app-main {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 25px 30px;
            min-height: calc(100vh - var(--header-height));
            transition: margin-left var(--transition);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============================================
           TABLEAUX
           ============================================ */
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
            position: relative;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            background: var(--bg-white);
        }

        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #c1c7cd;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #a0a7ae;
        }

        .table-striped {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            table-layout: fixed;
        }

        .table-striped.wide {
            min-width: 900px;
        }

        .table-striped.medium {
            min-width: 700px;
        }

        .table-striped thead th {
            padding: 1rem 1.5rem;
            color: var(--bg-white);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: none;
            white-space: nowrap;
            background: linear-gradient(135deg, var(--primary-light) 0%, #0f172a 100%);
            position: sticky;
            top: 0;
            z-index: 10;
            text-align: left;
        }

        .table-striped tbody td {
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
            color: var(--text-body);
            vertical-align: middle;
            word-wrap: break-word;
            border-bottom: 1px solid var(--border-light);
        }

        .table-striped tbody tr {
            transition: background 0.2s ease;
        }

        .table-striped tbody tr:hover {
            background: #f8fafc;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .toggle-btn {
                display: block;
            }

            .app-sidebar {
                transform: translateX(-100%);
                box-shadow: var(--shadow-lg);
            }

            .app-sidebar.open {
                transform: translateX(0);
            }

            .app-main {
                margin-left: 0;
                padding: 20px;
            }

            .header-title h1 {
                font-size: 1.1rem;
            }

            .header-title p {
                font-size: 0.65rem;
                max-width: 240px;
            }

            .logo-image {
                width: 45px;
                height: 45px;
            }

            .user-info .user-details {
                display: none;
            }

            .user-info {
                padding: 6px;
            }

            .annee-selector {
                padding: 3px 10px 3px 14px;
                min-width: 130px;
                max-width: 200px;
            }

            .annee-selector select {
                font-size: 0.75rem;
                min-width: 90px;
                max-width: 140px;
            }

            .annee-selector .annee-label {
                font-size: 0.6rem;
            }

            .table-wrapper {
                margin: 0 -0.5rem;
                padding: 0 0.5rem;
            }

            .table-striped {
                min-width: 700px;
            }

            .table-striped.wide {
                min-width: 900px;
            }

            .table-striped.medium {
                min-width: 700px;
            }

            .table-striped thead th,
            .table-striped tbody td {
                padding: 0.75rem 1rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 768px) {
            :root {
                --header-height: 70px;
            }

            .app-header {
                padding: 8px 12px;
            }

            .header-center {
                padding: 0 5px;
            }

            .logo-image {
                width: 38px;
                height: 38px;
            }

            .header-title h1 {
                font-size: 0.9rem;
            }

            .header-title p {
                display: none;
            }

            .annee-selector {
                padding: 2px 8px 2px 12px;
                min-width: 100px;
                max-width: 160px;
            }

            .annee-selector .annee-label {
                display: none;
            }

            .annee-selector select {
                font-size: 0.7rem;
                min-width: 80px;
                max-width: 120px;
                padding: 4px 2px;
            }

            .app-main {
                padding: 15px;
                padding-bottom: 80px;
            }

            .table-striped {
                min-width: 650px;
            }

            .table-striped.wide {
                min-width: 850px;
            }

            .table-striped.medium {
                min-width: 650px;
            }

            .table-striped thead th,
            .table-striped tbody td {
                padding: 0.6rem 0.8rem;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            :root {
                --header-height: 60px;
            }

            .app-header {
                padding: 6px 8px;
            }

            .logo-image {
                width: 32px;
                height: 32px;
            }

            .header-title h1 {
                font-size: 0.75rem;
            }

            .user-info {
                padding: 4px;
            }

            .user-info .user-avatar {
                width: 28px;
                height: 28px;
                font-size: 0.75rem;
            }

            .annee-selector {
                padding: 2px 6px 2px 8px;
                min-width: 80px;
                max-width: 120px;
            }

            .annee-selector select {
                font-size: 0.6rem;
                min-width: 60px;
                max-width: 90px;
                padding: 3px 2px;
            }

            .annee-selector .select-arrow {
                display: none;
            }

            .app-main {
                padding: 10px;
                padding-bottom: 70px;
            }

            .toggle-btn {
                padding: 6px 9px;
                font-size: 0.9rem;
            }

            .table-striped {
                min-width: 500px;
            }

            .table-striped.wide {
                min-width: 700px;
            }

            .table-striped.medium {
                min-width: 500px;
            }

            .table-striped thead th,
            .table-striped tbody td {
                padding: 0.4rem 0.6rem;
                font-size: 0.7rem;
            }

            .table-striped .badge,
            .table-striped .status-badge,
            .table-striped .role-badge {
                font-size: 0.6rem !important;
                padding: 0.15rem 0.4rem !important;
            }
        }

        @media (max-width: 380px) {
            .header-title h1 {
                font-size: 0.65rem;
            }

            .logo-image {
                width: 28px;
                height: 28px;
            }

            .annee-selector {
                min-width: 65px;
                max-width: 90px;
            }

            .annee-selector select {
                font-size: 0.55rem;
                min-width: 50px;
                max-width: 70px;
            }

            .table-striped {
                min-width: 400px;
            }

            .table-striped thead th,
            .table-striped tbody td {
                padding: 0.3rem 0.4rem;
                font-size: 0.65rem;
            }
        }

        /* Accessibilité : réduction des animations */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Impression */
        @media print {

            .app-header,
            .app-sidebar,
            .toggle-btn,
            .sidebar-overlay {
                display: none !important;
            }

            .app-main {
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    @php
        $currentUser = Auth::user();
        $selectedAnneeId = session('annee_id') ?? $currentUser?->annee_id;
        $employe = $currentUser ? \App\Models\employe::where('user_id', $currentUser->id)->first() : null;
        $lecturesQuery = $employe
            ? \App\Models\lecture::where('employe_id', $employe->id)
            : \App\Models\lecture::whereRaw('1 = 0');
        $totalLectures = (clone $lecturesQuery)->count();
        $nonLus = (clone $lecturesQuery)->where('lu', false)->count();
    @endphp

    {{-- ============================================
         EN-TÊTE
         ============================================ --}}
    <header class="app-header" role="banner">
        {{-- Logo + Titre --}}
        <div class="header-left">
            <img src="{{ asset('image/logo.jpeg') }}" alt="Logo ARSP" class="logo-image" width="55" height="55">
            <div class="header-title">
                <h1>ARSP</h1>
                <p>Autorité de Régulation de la Sous-traitance dans le Secteur Privé</p>
            </div>
        </div>

        {{-- Centre : Sélecteur Année --}}
        <div class="header-center">
            @php
                $les_annees = \App\Models\annee::orderBy('annee', 'desc')->get();
            @endphp

            @if ($les_annees->count() > 0)
                <form action="{{ route('switcher_annee') }}" method="POST" class="annee-selector" role="form">
                    @csrf
                    @method('PUT')
                    <label for="annee_id" class="annee-label">
                        <i class="fas fa-calendar-alt"></i> Année
                    </label>
                    <select name="annee_id" id="annee_id" onchange="this.form.submit()">
                        <option value="">Sélectionnez</option>
                        @foreach ($les_annees as $annee)
                            <option value="{{ $annee->id }}"
                                {{ $selectedAnneeId == $annee->id ? 'selected' : ($selectedAnneeId === null && $annee->statut === 'active' ? 'selected' : '') }}>
                                {{ $annee->annee }}
                            </option>
                        @endforeach
                    </select>
                    <span class="select-arrow" aria-hidden="true">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </form>
            @else
                <span class="text-white-50 small">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Aucune année
                </span>
            @endif
        </div>

        {{-- Droite : Profil + Toggle --}}
        <div class="header-right">
            <a href="{{ route('profile_emp') }}" class="user-info text-decoration-none" aria-label="Mon profil">
                <span class="user-avatar">
                    <i class="fas fa-user"></i>
                </span>
                <span class="user-details">
                    <span class="user-name">{{ Auth::user()->name ?? 'Invité' }}</span>
                    <span class="role-badge">{{ Auth::user()->role ?? '—' }}</span>
                </span>
            </a>

            <button class="toggle-btn" id="sidebarToggle" aria-label="Basculer la navigation" aria-expanded="false"
                aria-controls="appSidebar">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    {{-- ============================================
         SIDEBAR DE NAVIGATION
         ============================================ --}}
    <aside class="app-sidebar" id="appSidebar" role="navigation" aria-label="Navigation principale">
        <div class="nav-section">
            <div class="nav-section-title">Menu principal</div>
            <a href="{{ route('accueil_employe') }}"
                class="nav-link {{ Route::is('accueil_employe') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Accueil</span>
            </a>
            <a href="{{ route('mes_conges') }}" class="nav-link {{ Route::is('mes_conges') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i>
                <span>Congés</span>
            </a>
            <a href="{{ route('mes_presences') }}" class="nav-link {{ Route::is('mes_presences') ? 'active' : '' }}">
                <i class="fas fa-user-clock"></i>
                <span>Présences</span>
            </a>
            <a href="{{ route('mes_disciplines') }}"
                class="nav-link {{ Route::is('mes_disciplines') ? 'active' : '' }}">
                <i class="fas fa-gavel"></i>
                <span>Discipline</span>
            </a>
            <a href="{{ route('mes_communiques') }}"
                class="nav-link {{ Route::is('mes_communiques') ? 'active' : '' }}">

                <i class="fas fa-bullhorn"></i>

                <span>Communiqués</span>

                {{-- Nombre total de communiqués destinés à l'employé --}}
                <span class="badge bg-primary rounded-5 text-light">
                    {{ $totalLectures }}
                </span>

                {{-- Nombre de communiqués non lus --}}
                @if ($nonLus > 0)
                    <span class="badge bg-danger rounded-5 text-light">
                        {{ $nonLus }}
                    </span>
                @endif

            </a>

        </div>

        <div class="logout-wrapper">
            <form method="POST" action="{{ route('logout') }}"
                onsubmit="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Se déconnecter</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay mobile --}}
    <div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

    {{-- ============================================
         CONTENU PRINCIPAL
         ============================================ --}}
    <main class="app-main" id="mainContent" role="main">
        @include('layouts.alerts')
        @yield('content')
    </main>

    {{-- ============================================
         SCRIPTS
         ============================================ --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('appSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const body = document.body;

            if (!toggleBtn || !sidebar) return;

            function openSidebar() {
                sidebar.classList.add('open');
                overlay?.classList.add('active');
                body.classList.add('no-scroll');
                toggleBtn.setAttribute('aria-expanded', 'true');
                toggleBtn.innerHTML = '<i class="fas fa-times"></i>';
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay?.classList.remove('active');
                body.classList.remove('no-scroll');
                toggleBtn.setAttribute('aria-expanded', 'false');
                toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
            }

            toggleBtn.addEventListener('click', function() {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });

            overlay?.addEventListener('click', closeSidebar);

            // Fermer au clavier (Échap)
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                    closeSidebar();
                }
            });

            // Fermer lors du redimensionnement vers desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992 && sidebar.classList.contains('open')) {
                    closeSidebar();
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
