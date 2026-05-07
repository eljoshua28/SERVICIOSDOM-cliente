<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SERVICIOSDOM</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

@if(session('usuario'))
<nav class="bg-blue-700 p-4 flex justify-between items-center">
    <div class="flex items-center gap-4">
        <h1 class="text-white text-xl font-bold">SERVICIOSDOM</h1>
        <a href="{{ route('catalogo') }}" class="bg-white text-blue-700 px-3 py-1 rounded font-semibold hover:bg-blue-100"> Catálogo</a>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-white text-sm">Hola, {{ session('usuario')->nombre }}</span>
        <a href="{{ route('perfil') }}" class="bg-white text-blue-700 px-3 py-1 rounded font-semibold hover:bg-blue-100">👤 Mi Perfil</a>
        <a href="{{ route('carrito') }}" class="bg-white text-blue-700 px-3 py-1 rounded font-semibold hover:bg-blue-100">🛒 Carrito</a>
        <a href="{{ route('mis.pedidos') }}" class="bg-white text-blue-700 px-3 py-1 rounded font-semibold hover:bg-blue-100">📋 Mis Pedidos</a>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Salir</button>
        </form>
    </div>
</nav>
@endif

<main class="max-w-7xl mx-auto p-6 flex-grow w-full">
    @yield('content')
</main>

@if(session('usuario'))
<footer class="bg-blue-800 text-white py-10 mt-auto">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

        <div>
            <h3 class="text-lg font-bold mb-3">Nosotros</h3>
            <p class="text-sm text-blue-200">Somos una empresa dedicada a brindarte los mejores servicios a domicilio, con técnicos certificados y atención personalizada.</p>
        </div>

        <div>
            <h3 class="text-lg font-bold mb-3">Servicios</h3>
            <ul class="text-sm text-blue-200 space-y-1">
                <li><a href="{{ route('catalogo') }}" class="hover:text-white">Ver Catálogo</a></li>
                <li><a href="{{ route('mis.pedidos') }}" class="hover:text-white">Mis Pedidos</a></li>
                <li><a href="{{ route('carrito') }}" class="hover:text-white">Mi Carrito</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-lg font-bold mb-3">Contacto</h3>
            <ul class="text-sm text-blue-200 space-y-1">
                <li>📞 33 1234 5678</li>
                <li>✉️ contacto@serviciosdom.mx</li>
                <li>📍 Guadalajara, Jalisco</li>
            </ul>
        </div>

        <div>
            <h3 class="text-lg font-bold mb-3">Síguenos</h3>
            <div class="flex gap-4 text-blue-200">
                <a href="#" class="hover:text-white text-2xl">📘</a>
                <a href="#" class="hover:text-white text-2xl">📸</a>
                <a href="#" class="hover:text-white text-2xl">💬</a>
            </div>
            <p class="text-xs text-blue-300 mt-4">© 2026 SERVICIOSDOM. Todos los derechos reservados.</p>
        </div>

    </div>
</footer>
@endif

<script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
</body>
</html>
