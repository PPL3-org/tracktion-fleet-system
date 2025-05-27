<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')

        <link rel="icon" href="{{ asset('favlogo.ico')}}" type="image/x-icon">

        <title>{{ $title ?? config('app.name') }}</title>
        @livewireStyles {{-- Tambahkan ini jika belum ada, untuk styling Livewire --}}
    </head>
    <body class="flex bg-gray-100">

        {{-- sidebar component --}} 
        <livewire:sidebar />
    
        <div class="flex flex-col w-full">
            {{-- top navbar component --}}
            <livewire:navbar />

            {{-- main content --}}
            <main class="p-4"> {{-- Sebaiknya bungkus $slot dalam tag <main> dan beri padding jika perlu --}}
                {{ $slot }}
            </main>
        </div>
    
        {{-- Komponen Livewire untuk modal profil --}}
        @livewire('profile.index') 
        {{-- atau <livewire:profile.index /> --}}

        @livewireScripts {{-- WAJIB: Untuk fungsionalitas Livewire --}}
        {{-- Jika Anda menggunakan Vite untuk JavaScript bundle Anda, pastikan itu juga di-include --}}
        {{-- Contoh: @vite('resources/js/app.js') --}}
        {{-- Biasanya @livewireScripts ditempatkan sebelum tag </body> --}}
    </body>
</html>