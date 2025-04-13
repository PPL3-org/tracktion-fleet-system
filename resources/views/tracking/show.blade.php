@extends('layouts.guest')

@section('title', 'Tracking')

@section('content')
    <!-- Danger Alert -->
    <div id="error-alert" class="fixed max-w-3xl top-0 left-1/2 transform -translate-x-1/2 -translate-y-full transition-all duration-500 flex items-center p-4 text-xs text-red-800 rounded-lg bg-red-50 z-50" role="alert">
        <svg class="shrink-0 inline w-4 h-4 me-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
        <span class="font-medium">Gagal mengambil lokasi!</span> Pastikan GPS perangkat anda aktif dan izin lokasi diberikan.
        </div>
    </div>
    
    {{-- Loading Skeleton --}}
    <div id="loading-overlay" class="flex flex-col items-center justify-center relative hidden">
        <div class="absolute w-32 h-32 rounded-full bg-amber-200 opacity-30 animate-ping"></div>
        
        <div class="w-16 h-16 rounded-full bg-amber-500 animate-pulse" style="animation-duration: 2s;"></div>
        
        <p class="mt-4 text-lg font-medium text-white z-10 italic">Mohon tunggu...</p>
    </div>
    
    <div id="main-content" class="flex flex-col max-w-xl mx-auto px-4 sm:px-6 mt-10 space-y-6">
        <!-- Judul dan deskripsi -->
        <div class="text-center space-y-2">
            <h1 class="text-white text-2xl sm:text-3xl font-bold">Siap Memulai Pengiriman Anda?</h1>
            <p class="text-white text-sm sm:text-base font-medium">
                Optimalkan perjalanan Anda dengan informasi terkini dan proses pengiriman yang efisien.
            </p>
        </div>

        <!-- Informasi Truck & Pengemudi -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg space-y-2 relative">
            <div class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-2">
                <p class="text-sm font-medium text-[var(--color-primary)]">Nomor Plat</p>
                <p class="text-sm font-medium text-gray-800">:&nbsp;&nbsp;&nbsp;{{ $truck->plate_number }}</p>
        
                <p class="text-sm font-medium text-[var(--color-primary)]">Pengemudi</p>
                <p class="text-sm font-medium text-gray-800">:&nbsp;&nbsp;&nbsp;-</p>
        
                <p class="text-sm font-medium text-[var(--color-primary)]">Kendaraan</p>
                <p class="text-sm font-medium text-gray-800">:&nbsp;&nbsp;&nbsp;{{ ucwords($truck->model) }}</p>
            </div>
        
            <!-- Tombol aksi -->
            <form id="start-tracking-form" class="pt-4">
                <div class="flex flex-col sm:flex-row justify-between gap-4">
                    <button 
                        type="button" 
                        onclick="startTracking()" 
                        class="w-full px-6 py-2 bg-[var(--color-primary)] hover:opacity-90 text-white text-sm font-medium rounded-full transition"
                    >
                        Mulai
                    </button>
                </div>
            </form>
        </div>  
    </div>        
    <script>
        window.truckId = "{{ $truck->id }}";
    </script>
@endsection