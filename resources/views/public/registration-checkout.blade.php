@extends('layouts.public')

@section('title', 'Selesaikan Pembayaran - GSJA Kairos Manado')

@section('slot')
<div class="min-h-screen bg-gradient-to-br from-cyan-50 via-blue-50 to-purple-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Checkout Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-8 text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Selesaikan Pembayaran</h1>
                <p class="text-cyan-100 text-lg">Tinggal satu langkah lagi untuk mengonfirmasi registrasi Anda</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Event Info -->
                <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-200 rounded-2xl p-6 mb-8">
                    <div class="flex items-center mb-4">
                        @if($event->image)
                            <img class="w-16 h-16 rounded-xl object-cover mr-4" src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}">
                        @else
                            <div class="w-16 h-16 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $event->title ?? 'Event tidak tersedia' }}</h2>
                            <p class="text-gray-600">{{ $event->start_date ? $event->start_date->format('d M Y, H:i') : 'Tanggal tidak tersedia' }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-cyan-100 pt-4 mt-4">
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-600 font-medium">{{ $event->location ?? 'Lokasi tidak tersedia' }}</span>
                        </div>
                        
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-gray-600 font-medium">{{ $registration->name ?? 'Nama tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Price Detail -->
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 mb-8">
                    <h3 class="text-gray-800 font-bold text-lg mb-4">Rincian Tagihan</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Harga Tiket Event</span>
                            <span>Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Layanan / Admin</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="flex justify-between text-gray-900 font-bold text-xl border-t border-gray-200 pt-3">
                            <span>Total Pembayaran</span>
                            <span class="text-blue-600">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="space-y-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-bold text-blue-800 mb-2">Instruksi Pembayaran</h3>
                                <p class="text-blue-700">Setelah menekan tombol pembayaran, jendela aman Midtrans akan terbuka. Anda dapat membayar menggunakan Transfer Bank (Virtual Account), Kartu Kredit, E-Wallet (Gopay/ShopeePay), atau QRIS.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <button id="pay-button"
                            class="flex-1 bg-gradient-to-r from-emerald-500 to-green-600 text-white text-center py-4 px-6 rounded-xl font-bold hover:from-emerald-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <span class="flex items-center justify-center text-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Bayar Sekarang
                        </span>
                    </button>
                    
                    <a href="{{ route('home') }}" 
                       class="flex-1 bg-gradient-to-r from-gray-500 to-gray-600 text-white text-center py-4 px-6 rounded-xl font-bold hover:from-gray-600 hover:to-gray-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <span class="flex items-center justify-center">
                            Kembali ke Beranda
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-gray-600">Sistem Pembayaran Aman GSJA Kairos Manado didukung oleh Midtrans</p>
        </div>
    </div>
</div>

<!-- Midtrans Snap Script -->
<script src="{{ config('services.midtrans.production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Trigger snap popup
        window.snap.pay('{{ $registration->snap_token }}', {
            onSuccess: function(result){
                /* You may add your own implementation here */
                window.location.href = "{{ $successUrl }}";
            },
            onPending: function(result){
                /* You may add your own implementation here */
                window.location.href = "{{ $pendingUrl }}";
            },
            onError: function(result){
                /* You may add your own implementation here */
                alert("Pembayaran gagal, silakan coba beberapa saat lagi.");
            },
            onClose: function(){
                /* You may add your own implementation here */
                alert('Anda menutup popup pembayaran sebelum menyelesaikan transaksi.');
            }
        });
    });
</script>
@endsection
