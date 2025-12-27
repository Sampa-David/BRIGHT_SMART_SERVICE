@extends('layouts.app')

@section('title', isset($title) ? $title . ' - ' . config('app.name') : 'Administration - ' . config('app.name'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endpush

@section('content')
    <div class="admin-container">
        @yield('admin-content')
    </div>
@endsection
