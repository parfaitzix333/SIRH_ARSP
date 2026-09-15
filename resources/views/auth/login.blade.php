<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>
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
            <h3>Connexion</h3>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror" required autofocus
                    autocomplete="username">
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" required
                    autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label">Se souvenir de moi</label>
            </div>

            <div class="d-grid gap-2">
                @if (Route::has('password.request'))
                    <a class="text-decoration-none text-center small" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                @endif

                <button type="submit" class="btn btn-primary w-100">
                    Se connecter
                </button>
            </div>
        </form>
    </div>
</body>

</html>
