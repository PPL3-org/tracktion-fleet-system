@extends('layouts.tracking')

@section('title', 'Tracking | Inspection')

@section('content')
{{-- Loading Skeleton --}}
<div id="loading-overlay" class="loader hidden">
    <span class="loader-text">Memproses</span>
    <span class="load"></span>
</div>

<div id="main-content" class="flex flex-col w-full max-w-xl mx-auto px-4 sm:px-6 mt-10 space-y-6">
    {{-- Create Report Section --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg space-y-4 relative">
        <div class="mx-[-24px] px-6 pb-4 border-b border-gray-200">
            <h2 class="text-base font-medium text-gray-900">Buat data pemeriksaan kendaraan</h2>
        </div>

        {{-- Inspection Form --}}
        <form method="POST" action="{{ route('inspections.store', ['truck' => $truck->id]) }}"
            class="space-y-6 pt-2">
            @csrf

            <input id="report-latitude" type="hidden" name="latitude">
            <input id="report-longitude" type="hidden" name="longitude">

            {{-- Insepctions Type Dropdown --}}
            <div class="w-full">
                <label for="spare_tire_available" class="block text-xs font-medium text-gray-700 mb-1">Ketersediaan ban cadangan</label>
                <select name="spare_tire_available"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)] text-xs">
                    <option value="tersedia">Tersedia</option>
                    <option value="tidak tersedia">Tidak tersedia</option>
                </select>
            </div>
            <div class="w-full">
                <label for="main_tire_condition" class="block text-xs font-medium text-gray-700 mb-1">Kondisi ban utama</label>
                <select name="main_tire_condition"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)] text-xs">
                    <option value="layak">Layak</option>
                    <option value="tidak layak">Tidak Layak</option>
                </select>
            </div>
            <div class="w-full">
                <label for="tire_pressure_condition" class="block text-xs font-medium text-gray-700 mb-1">Tekanan angin ban</label>
                <select name="tire_pressure_condition"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)] text-xs">
                    <option value="rendah">Rendah</option>
                    <option value="normal">Normal</option>
                    <option value="tinggi">Tinggi</option>
                </select>
            </div>
            <div class="w-full">
                <label for="brakes_condition" class="block text-xs font-medium text-gray-700 mb-1">Tekanan angin ban</label>
                <select name="brakes_condition"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)] text-xs">
                    <option value="terdapat kerusakan">Terdapat Kerusakan</option>
                    <option value="berfungsi">Berfungsi</option>
                </select>
            </div>

            {{-- Issue Description Textbox --}}
            <div class="w-full">
                <label for="description" class="block text-xs font-medium text-gray-700 mb-1">Deskripsi Inspeksi</label>
                <textarea id="description" name="problem_description" rows="6"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)] text-xs"
                    placeholder="Jelaskan keadaan kendaraan secara menyeluruh..."></textarea>
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
                <a href="{{ route('tracking.start-tracking', ['truck' => $truck->id]) }}"
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