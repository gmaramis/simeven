@extends('layouts.public')

@section('title', 'Pembayaran - Simeven')

@section('content')
<div class="max-w-lg mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 text-center">
        <h1 class="text-xl font-bold text-gray-900 mb-2">Selesaikan pembayaran</h1>
        <p class="text-gray-600 text-sm mb-6">{{ $registration->event->title }} — Rp {{ number_format((float) $registration->event->price, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-500 mb-6">Jendela pembayaran akan terbuka. Jika tidak muncul, aktifkan pop-up untuk situs ini.</p>
        <div id="snap-container"></div>
    </div>
</div>

<script type="text/javascript" src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}"></script>
<script type="text/javascript">
    window.snap.pay({!! json_encode($snapToken) !!}, {
        onSuccess: function () {
            window.location.href = @json(route('registration.success', $registration->id));
        },
        onPending: function () {
            window.location.href = @json(route('registration.success', $registration->id));
        },
        onError: function () {
            alert('Pembayaran gagal atau dibatalkan.');
            window.location.href = @json(route('registration.success', $registration->id));
        },
        onClose: function () {
            window.location.href = @json(route('registration.success', $registration->id));
        }
    });
</script>
@endsection
