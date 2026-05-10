@extends('layouts.public')

@section('title', 'Pembayaran')

@section('content')
<div class="max-w-lg mx-auto px-4 py-12 text-center">
    <div class="bg-white rounded-2xl shadow border p-8">
        <h1 class="text-lg font-bold text-gray-900 mb-2">Tidak dapat memulai pembayaran</h1>
        <p class="text-gray-600 text-sm mb-6">{{ $message ?? 'Silakan coba lagi atau hubungi panitia.' }}</p>
        <a href="{{ route('registration.success', $registration->id) }}" class="text-cyan-600 font-medium hover:underline">Kembali</a>
    </div>
</div>
@endsection
