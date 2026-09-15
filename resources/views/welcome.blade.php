<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ARSP</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>

    <header>
        <nav class="container d-flex">
            @auth
                <a href="{{ url('/dashboard') }}">
                    Dashboard
                </a>
            @else
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-3">
                        Log in
                    </a>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary w-100 mb-3">
                        Register
                    </a>
                @endif
            @endauth

            {{-- Employee authentication --}}
            @if (Route::has('form_employe_register'))
                <a href="{{ route('form_employe_register') }}" class="btn btn-secondary w-100 mb-3">
                    Employee Register
                </a>
            @endif

            @if (Route::has('form_employe_login'))
                <a href="{{ route('form_employe_login') }}" class="btn btn-secondary w-100 mb-3">
                    Employee Login
                </a>
            @endif
        </nav>
    </header>

</body>

</html>
