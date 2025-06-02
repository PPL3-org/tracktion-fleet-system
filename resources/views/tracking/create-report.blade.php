@extends('layouts.tracking')

@section('title', 'Tracking')

@section('content')
<!-- Danger Alert -->
<div id="error-alert"
    class="fixed min-w-xs top-0 left-1/2 transform -translate-x-1/2 -translate-y-full transition-all duration-500 flex items-center p-4 text-xs text-red-800 rounded-lg bg-red-50 z-50"
    role="alert">
    <svg class="shrink-0 inline w-4 h-4 me-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <span class="sr-only">Info</span>
    <div>
        <span class="font-medium">Gagal mengambil lokasi!</span> Pastikan GPS perangkat anda aktif dan izin lokasi
        diberikan.
    </div>
</div>

{{-- Getting Location Alert --}}
<div id="getting-location-alert"
    class="fixed min-w-xs top-0 left-1/2 transform -translate-x-1/2 -translate-y-full transition-all duration-500 flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 gap-2"
    role="alert">
    <div role="status">
        <svg aria-hidden="true" class="w-5 h-5 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101"
            fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                fill="currentColor" />
            <path
                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                fill="currentFill" />
        </svg>
    </div>
    <div>
        <span class="font-medium text-xs">Mendapatkan lokasi...
    </div>
</div>

{{-- Success Location Alert --}}
<div id="success-location-alert"
    class="fixed min-w-xs top-0 left-1/2 transform -translate-x-1/2 -translate-y-full transition-all duration-500 flex items-center gap-2 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50"
    role="alert">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    </svg>
    <span class="font-medium text-xs">Berhasil mendapatkan lokasi !</span>
</div>

{{-- Loading Skeleton --}}
<div id="loading-overlay" class="loader hidden">
    <span class="loader-text">Memproses</span>
    <span class="load"></span>
</div>

<div id="main-content" class="flex flex-col w-full max-w-xl mx-auto px-4 sm:px-6 mt-10 space-y-6">
    {{-- Create Report Section --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg space-y-4 relative">
        <div class="mx-[-24px] px-6 pb-4 border-b border-gray-200">
            <h2 class="text-base font-medium text-gray-900">Lapor Kendala Pengiriman</h2>
        </div>

        {{-- Report Form --}}
        <form method="POST" action="{{ route('tracking.store-report', ['truck' => $truck->id]) }}"
            class="space-y-6 pt-2">
            @csrf

            <input id="report-latitude" type="hidden" name="latitude">
            <input id="report-longitude" type="hidden" name="longitude">

            {{-- Issue Type Dropdown --}}
            <div class="w-full">
                <label for="issue_type" class="block text-xs font-medium text-gray-700 mb-1">Tipe Kendala</label>
                <select id="issue_type" name="problem_type"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)] text-xs">
                    <option value="">Pilih tipe kendala</option>
                    <option value="masalah kendaraan">Kendala Mekanis</option>
                    <option value="kemacetan">Kendala Lalu Lintas</option>
                    <option value="kecelakaan">Kecelakaan</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            {{-- Issue Description Textbox --}}
            <div class="w-full">
                <label for="description" class="block text-xs font-medium text-gray-700 mb-1">Deskripsi Kendala</label>
                <textarea id="description" name="problem_description" rows="6"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)] text-xs"
                    placeholder="Jelaskan kendala yang dialami..."></textarea>
            </div>

            @if ($errors->any())
            @php
            $lastErrorMessage = collect($errors->all())->last();
            @endphp
            <p class="mt-3 text-xs text-center text-red-600 my-2 font-medium">
                {{ $lastErrorMessage }}
            </p>
            @endif

            {{-- Action Buttons --}}
            <div class="flex justify-between pt-2">
                <a href="{{ route('tracking.on-going', ['truck' => $truck->id]) }}"
                    class="px-6 py-2 bg-white border-1 border-[var(--color-primary)] text-[var(--color-primary)] text-xs font-medium rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200">
                    Kembali
                </a>
                <button type="submit" onclick="showLoading()"
                    class="px-6 py-2 bg-[var(--color-primary)] text-white text-xs font-medium rounded-md hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary)]">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    window.truckId = "{{ $truck->id }}";
</script>
@vite('resources/js/tracking.js')
@endsection