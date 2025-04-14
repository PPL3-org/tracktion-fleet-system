@extends('layouts.guest')

@section('title', 'Tracking')

@section('content')
    {{-- Shipping success animation --}}
    

    <!-- Danger Alert -->
    

    {{-- Loading Skeleton --}}
    
    {{-- Main Content of On-going page --}}
    <script>
        window.truckId = "{{ $truck->id }}";
    </script>
@endsection