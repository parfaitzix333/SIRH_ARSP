<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Création de compte employé</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        #backButton {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1000 ! important;
        }
    </style>
</head>

<body>
    <a class="btn rounded-circle btn-primary btn-sm" id="backButton" href="{{ url('/') }}"
        aria-label="Retour à l'accueil">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
    </a>
    <div class="login-card">
        <div class="brand">
            <img src="{{ asset('image/logo.jpeg') }}" alt="Logo ARSP">
            <h3>Création de compte employé</h3>
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

        <form action="{{ route('employe_register') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="matricule" class="form-label">Matricule</label>
                <input type="text" name="matricule" id="matricule"
                    class="form-control @error('matricule') is-invalid @enderror" value="{{ old('matricule') }}"
                    placeholder="Entrez votre matricule" required autofocus>
                @error('matricule')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                    placeholder="exemple@domaine.com" required>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="Minimum 6 caractères"
                    required>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirmation mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    placeholder="Retaper votre mot de passe" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Enregistrer
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('form_employe_login') }}" class="text-decoration-none">
                Déjà un compte ? Se connecter
            </a>
        </div>
    </div>
</body>

</html>
