@extends('admin.layouts.admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">📱 WhatsApp - {{ $event->title }}</h1>
                <p class="text-gray-600">Kelola pesan WhatsApp untuk event ini</p>
            </div>
            <a href="{{ route('admin.whatsapp.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                ← Kembali
            </a>
        </div>
    </div>

    <!-- Event Info -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">📅 Detail Event</h3>
                <p class="text-gray-600">{{ $event->start_date->format('d M Y H:i') }}</p>
                <p class="text-gray-600">{{ $event->location }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">👥 Peserta</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $event->registrations->count() }}</p>
                <p class="text-sm text-gray-500">Total terdaftar</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">📊 Statistik Pesan</h3>
                <div class="grid grid-cols-3 gap-2 text-sm">
                    <div class="text-center">
                        <p class="font-bold text-green-600">{{ $stats['sent'] }}</p>
                        <p class="text-gray-500">Terkirim</p>
                    </div>
                    <div class="text-center">
                        <p class="font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                        <p class="text-gray-500">Menunggu</p>
                    </div>
                    <div class="text-center">
                        <p class="font-bold text-red-600">{{ $stats['failed'] }}</p>
                        <p class="text-gray-500">Gagal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-2xl shadow-xl">
            <h3 class="text-lg font-bold mb-4">✅ Kirim Konfirmasi</h3>
            <p class="text-green-100 mb-4">Kirim konfirmasi pendaftaran ke semua peserta yang belum dikonfirmasi</p>
            <button onclick="sendConfirmations()" 
                    class="bg-white text-green-600 px-4 py-2 rounded-lg font-medium hover:bg-green-50 transition-colors">
                Kirim Konfirmasi
            </button>
        </div>

        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-2xl shadow-xl">
            <h3 class="text-lg font-bold mb-4">⏰ Reminder H-1</h3>
            <p class="text-blue-100 mb-4">Kirim reminder sehari sebelum event</p>
            <button onclick="sendReminders('reminder_h1')" 
                    class="bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                Kirim Reminder H-1
            </button>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-2xl shadow-xl">
            <h3 class="text-lg font-bold mb-4">🌅 Reminder H-0</h3>
            <p class="text-purple-100 mb-4">Kirim reminder pagi hari event</p>
            <button onclick="sendReminders('reminder_h0')" 
                    class="bg-white text-purple-600 px-4 py-2 rounded-lg font-medium hover:bg-purple-50 transition-colors">
                Kirim Reminder H-0
            </button>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">📱 Riwayat Pesan</h3>
        </div>
        
        @if($messages->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Peserta
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipe Pesan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Waktu
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($messages as $message)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $message->registration->name ?? 'Unknown' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $message->phone_number }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($message->message_type === 'confirmation') bg-blue-100 text-blue-800
                                    @elseif($message->message_type === 'reminder_h1') bg-yellow-100 text-yellow-800
                                    @else bg-purple-100 text-purple-800 @endif">
                                    {{ $message->getMessageTypeLabel() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($message->status === 'sent') bg-green-100 text-green-800
                                    @elseif($message->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $message->getStatusLabel() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $message->created_at->format('d M Y H:i') }}
                                @if($message->sent_at)
                                    <br><span class="text-xs">Terkirim: {{ $message->sent_at->format('H:i') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($message->status === 'failed')
                                    <button onclick="retryMessage({{ $message->id }})" 
                                            class="text-blue-600 hover:text-blue-900">
                                        Ulangi
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $messages->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <p class="text-gray-500">Belum ada pesan terkirim untuk event ini</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function sendConfirmations() {
    if (!confirm('Kirim konfirmasi ke semua peserta yang belum dikonfirmasi?')) return;
    
    // Get all unconfirmed registrations
    const registrations = @json($event->registrations->where('is_confirmed', false));
    
    if (registrations.length === 0) {
        alert('Tidak ada peserta yang perlu dikonfirmasi');
        return;
    }
    
    let sentCount = 0;
    let failedCount = 0;
    
    registrations.forEach(registration => {
        fetch(`/admin/whatsapp/registration/${registration.id}/confirm`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                sentCount++;
            } else {
                failedCount++;
            }
            
            if (sentCount + failedCount === registrations.length) {
                alert(`Selesai! ${sentCount} berhasil, ${failedCount} gagal`);
                location.reload();
            }
        })
        .catch(error => {
            failedCount++;
            console.error('Error:', error);
        });
    });
}

function sendReminders(type) {
    const typeLabel = type === 'reminder_h1' ? 'Reminder H-1' : 'Reminder H-0';
    if (!confirm(`Kirim ${typeLabel} ke semua peserta yang sudah dikonfirmasi?`)) return;
    
    fetch(`/admin/whatsapp/event/{{ $event->id }}/reminders`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ type: type })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim reminder');
    });
}

function retryMessage(messageId) {
    if (!confirm('Ulangi pengiriman pesan ini?')) return;
    
    fetch(`/admin/whatsapp/message/${messageId}/retry`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengulang pesan');
    });
}
</script>
@endpush
@endsection
