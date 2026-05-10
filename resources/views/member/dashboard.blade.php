<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pendaftaran saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-gray-600 mb-6">Riwayat event yang Anda daftarkan saat login.</p>

                    @if($registrations->isEmpty())
                        <p class="text-gray-500">Belum ada pendaftaran.</p>
                        <a href="{{ route('events') }}" class="inline-block mt-4 text-cyan-600 font-medium hover:underline">Lihat event</a>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b text-left">
                                        <th class="py-2 pr-4">Event</th>
                                        <th class="py-2 pr-4">Tanggal</th>
                                        <th class="py-2 pr-4">Status</th>
                                        <th class="py-2 pr-4">Pembayaran</th>
                                        <th class="py-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registrations as $r)
                                        <tr class="border-b border-gray-100">
                                            <td class="py-3 pr-4 font-medium">{{ $r->event?->title ?? '-' }}</td>
                                            <td class="py-3 pr-4">{{ $r->event?->start_date?->format('d M Y H:i') ?? '-' }}</td>
                                            <td class="py-3 pr-4">{{ ucfirst($r->status) }}</td>
                                            <td class="py-3 pr-4">
                                                @if($r->event?->isFree())
                                                    <span class="text-gray-500">—</span>
                                                @elseif($r->payment_status === \App\Models\Registration::PAYMENT_PAID)
                                                    <span class="text-green-700">Lunas</span>
                                                @elseif($r->payment_status === \App\Models\Registration::PAYMENT_PENDING)
                                                    <span class="text-amber-700">Menunggu bayar</span>
                                                @else
                                                    <span class="text-gray-600">{{ $r->payment_status }}</span>
                                                @endif
                                            </td>
                                            <td class="py-3 text-right">
                                                @if($r->event?->isPaid() && $r->payment_status === \App\Models\Registration::PAYMENT_PENDING)
                                                    <a href="{{ \Illuminate\Support\Facades\URL::temporarySignedRoute('payments.checkout', now()->addDays(7), ['registration' => $r->id]) }}"
                                                       class="inline-flex items-center px-3 py-1.5 rounded-lg bg-cyan-600 text-white text-xs font-semibold hover:bg-cyan-700">
                                                        Bayar
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">{{ $registrations->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
