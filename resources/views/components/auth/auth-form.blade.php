<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('favlogo.ico')}}" type="image/x-icon">
</head>

<body class="min-h-screen">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Background Image (visible only on small screens) -->
        <div class="fixed inset-0 block md:hidden bg-cover bg-center"
            style="background-image: url('{{ asset('images/login-register-cover.png') }}');">
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <!-- Left Side: Image (visible only on medium screens and above) -->
        <div class="hidden md:block md:w-1/2 bg-cover bg-center"
            style="background-image: url('{{ asset('images/login-register-cover.png') }}');"></div>

        <!-- Form Container (centered, works for all screen sizes) -->
        <div class="relative flex-1 md:w-1/2 flex items-center justify-center p-4 md:p-10">
            {{ $slot }}
        </div>
    </div>
</body>

</html>