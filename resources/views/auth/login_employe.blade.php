<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion employé</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a4b7a, #032e5a);
            font-family: Arial, sans-serif;
        }

        .login-card {
            width: min(100%, 430px);
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.18);
            padding: 2rem;
        }

        .brand {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .brand img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .brand h3 {
            margin: 0;
            color: #0a4b7a;
            font-weight: 700;
        }

        .form-label {
            font-weight: 600;
            color: #1f2937;
        }

        .btn-primary {
            background: #0a4b7a;
            border: none;
        }

        .btn-primary:hover {
            background: #083d67;
        }

        .alert-danger {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    @include('auth.btn_retour')
    <div class="login-card">
        <div class="brand">
            <img src="{{ asset('image/logo.jpeg') }}" alt="Logo ARSP">
            <h3>Connexion employé</h3>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('employe_login') }}">
            @csrf

            <div class="mb-3">
                <label for="matricule" class="form-label">Matricule</label>
                <input id="matricule" type="text" name="matricule" value="{{ old('matricule') }}"
                    class="form-control @error('matricule') is-invalid @enderror" placeholder="Entrez votre matricule"
                    required autofocus>
                @error('matricule')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="Entrez votre mot de passe"
                    required>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Se souvenir de moi
                </label>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Se connecter
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('form_employe_register') }}" class="text-decoration-none">
                Créer un compte employé
            </a>
        </div>
    </div>
</body>

</html>
