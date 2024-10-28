
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Actas')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
 
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('actas.create') }}">Crear Acta</a></li>
              
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Tu Organización. Todos los derechos reservados.</p>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
  
</body>
</html>
