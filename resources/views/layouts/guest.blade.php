<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @vite('resources/css/app.css')

    <link rel="icon" href="{{ asset('favlogo.ico')}}" type="image/x-icon">

    <title>@yield('title', config('app.name'))</title>
</head>
<body class="bg-cover bg-center" style="background-image: url('/images/tracking-background.png')">

    <div class="flex items-center justify-center min-h-screen bg-black/40">
        @yield('content')
    </div>
    
    <script src="{{ asset('js/tracking.js') }}" defer></script>
</body>
</html>