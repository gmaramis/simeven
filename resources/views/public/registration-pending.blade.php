@extends('layouts.public')

@section('title', 'Pembayaran Tertunda - GSJA Kairos Manado')

@section('slot')
<div class="min-h-screen bg-gradient-to-br from-cyan-50 via-blue-50 to-purple-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Pending Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
            <!-- Header with Gradient (Yellow/Amber indicating pending state) -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-8 text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Pendaftaran Belum Lunas</h1>
                <p class="text-orange-100 text-lg">Seat Anda telah dipesan, segera selesaikan pembayaran</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Event Info -->
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-orange-200 rounded-2xl p-6 mb-8">
                    <div class="flex items-center mb-4">
                        @if($event->image)
                        <img class="w-16 h-16 rounded-xl object-cover mr-4" src="{{ Storage::url($event->image) }}"
                            alt="{{ $event->title }}">
                        @else
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        @endif
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $event->title ?? 'Event tidak tersedia' }}
                            </h2>
                            <p class="text-gray-600">{{ $event->start_date ? $event->start_date->format('d M Y, H:i') :
                                'Tanggal tidak tersedia' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-orange-100 pt-4 mt-4">
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-600 font-medium">{{ $event->location ?? 'Lokasi tidak tersedia'
                                }}</span>
                        </div>

                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-gray-600 font-medium">{{ $registration->name ?? 'Nama tidak tersedia'
                                }}</span>
                        </div>
                    </div>
                </div>

                <!-- Price Detail -->
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 mb-8">
                    <h3 class="text-gray-800 font-bold text-lg mb-4">Rincian Pembayaran</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Nomor Tagihan (Order ID)</span>
                            <span class="font-mono text-gray-800">{{ $registration->midtrans_order_id }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Status</span>
                            <span class="text-orange-600 font-bold">MENUNGGU PEMBAYARAN</span>
                        </div>
                        <div class="flex justify-between text-gray-900 font-bold text-xl border-t border-gray-200 pt-3">
                            <span>Total Pembayaran</span>
                            <span class="text-orange-600">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Alert Information -->
                <div class="space-y-6">
                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-bold text-amber-800 mb-2">Penting untuk Diperhatikan</h3>
                                @if(isset($paymentInfo))
                                    @php
                                        $paymentType = $paymentInfo['payment_type'] ?? '';
                                        $vaNumber = null;
                                        $bank = null;
                                        if (isset($paymentInfo['va_numbers']) && count($paymentInfo['va_numbers']) > 0) {
                                            $vaNumber = $paymentInfo['va_numbers'][0]['va_number'];
                                            $bank = strtoupper($paymentInfo['va_numbers'][0]['bank']);
                                        } elseif (isset($paymentInfo['permata_va_number'])) {
                                            $vaNumber = $paymentInfo['permata_va_number'];
                                            $bank = 'PERMATA';
                                        } elseif ($paymentType === 'echannel') {
                                            $billerCode = $paymentInfo['biller_code'] ?? '';
                                            $billKey = $paymentInfo['bill_key'] ?? '';
                                            $vaNumber = $billerCode . ' / ' . $billKey;
                                            $bank = 'MANDIRI';
                                        }
                                    @endphp

                                    @if($vaNumber)
                                        <div class="mt-2 mb-3 bg-white bg-opacity-60 rounded-xl p-4 border border-amber-300">
                                            <p class="text-sm text-amber-800 font-semibold mb-1">Bank: {{ $bank }}</p>
                                            <p class="text-xs text-amber-700 mb-1">Nomor Virtual Account:</p>
                                            <div class="flex items-center justify-between">
                                                <span class="font-mono text-lg font-bold text-amber-900">{{ $vaNumber }}</span>
                                            </div>
                                        </div>
                                    @elseif($paymentType === 'qris' || $paymentType === 'gopay')
                                        <div class="mt-2 mb-3 bg-white bg-opacity-60 rounded-xl p-4 border border-amber-300">
                                            <p class="text-sm text-amber-800 font-semibold mb-1">Metode: QRIS / E-Wallet</p>
                                            <p class="text-xs text-amber-700">Jika barcode QR sudah tertutup atau kadaluarsa, silakan klik tombol "Ganti Metode" untuk membuat ulang pembayarannya.</p>
                                        </div>
                                    @endif
                                @endif

                                <ul class="list-disc pl-5 text-amber-700 space-y-1 text-sm mt-3">
                                    <li>Pembayaran harus diselesaikan sesuai instruksi metode pembayaran pilihan Anda.</li>
                                    <li>Jika Anda telah melakukan pembayaran namun halaman ini tidak berubah, silakan klik tombol "Cek Status Pembayaran" di bawah.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <button id="check-status-button"
                        class="flex-1 bg-gradient-to-r from-blue-500 to-cyan-600 text-white text-center py-3 px-4 rounded-xl font-bold hover:from-blue-600 hover:to-cyan-700 transition-all duration-300 transform hover:scale-105 shadow-lg text-sm md:text-base">
                        <span class="flex items-center justify-center" id="check-status-text">
                            <svg class="w-5 h-5 mr-1 md:w-6 md:h-6 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Cek Status
                        </span>
                    </button>
                    
                    <form action="{{ URL::temporarySignedRoute('registration.change-payment', now()->addDays(7), ['registrationId' => $registration->id]) }}" method="POST" class="flex-1 flex" id="form-change-payment">
                        @csrf
                        <button type="submit" onclick="return confirm('Anda yakin ingin membatalkan metode pembayaran sebelumnya dan memilih metode baru?');"
                            class="w-full bg-gradient-to-r from-gray-500 to-gray-600 text-white text-center py-3 px-4 rounded-xl font-bold hover:from-gray-600 hover:to-gray-700 transition-all duration-300 transform hover:scale-105 shadow-lg text-sm md:text-base">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-1 md:w-6 md:h-6 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                Ganti
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-gray-600">Sistem Pembayaran GSJA Kairos Manado didukung oleh Midtrans</p>
        </div>
    </div>
</div>

<script>
    document.getElementById('check-status-button').addEventListener('click', async function() {
        const btn = this;
        const textSpan = document.getElementById('check-status-text');
        
        btn.disabled = true;
        textSpan.innerHTML = '<svg class="animate-spin w-5 h-5 mr-1 md:w-6 md:h-6 md:mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengecek...';
        
        try {
            const url = {!! json_encode(URL::temporarySignedRoute('registration.check-status-api', now()->addDays(7), ['registrationId' => $registration->id])) !!};
            const response = await fetch(url);
            const data = await response.json();
            
            if (data.success && data.status === 'paid') {
                window.location.href = {!! json_encode($successUrl) !!};
            } else {
                alert('Pembayaran belum diterima. Silakan selesaikan pembayaran terlebih dahulu.');
            }
        } catch (e) {
            alert('Gagal mengecek status pembayaran. Silakan coba lagi.');
        } finally {
            btn.disabled = false;
            textSpan.innerHTML = '<svg class="w-5 h-5 mr-1 md:w-6 md:h-6 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Cek Status';
        }
    });
</script>
@endsection