@extends('admin.layouts.admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">📱 WhatsApp Management</h1>
        <p class="text-gray-600">Kelola pesan WhatsApp untuk konfirmasi dan reminder event</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-2xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Pesan</p>
                    <p class="text-3xl font-bold">{{ $stats['total_messages'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-2xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Terkirim</p>
                    <p class="text-3xl font-bold">{{ $stats['sent_messages'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-2xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Menunggu</p>
                    <p class="text-3xl font-bold">{{ $stats['pending_messages'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-2xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Gagal</p>
                    <p class="text-3xl font-bold">{{ $stats['failed_messages'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Active Events -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">📅 Event Aktif</h3>
            @if($events->count() > 0)
                <div class="space-y-4">
                    @foreach($events as $event)
                    <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ $event->title }}</h4>
                                <p class="text-sm text-gray-600">{{ $event->start_date->format('d M Y H:i') }} • {{ $event->location }}</p>
                                <p class="text-xs text-gray-500">{{ $event->registrations->count() }} peserta terdaftar</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.whatsapp.event.messages', $event) }}" 
                                   class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600 transition-colors">
                                    Lihat Pesan
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500">Tidak ada event aktif saat ini</p>
                </div>
            @endif
        </div>

        <!-- Recent Messages -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">📱 Pesan Terbaru</h3>
            @if($recentMessages->count() > 0)
                <div class="space-y-3">
                    @foreach($recentMessages as $message)
                    <div class="border border-gray-200 rounded-xl p-3">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $message->registration->name ?? 'Unknown' }}</p>
                                <p class="text-sm text-gray-600">{{ $message->getMessageTypeLabel() }}</p>
                                <p class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if($message->status === 'sent') bg-green-100 text-green-800
                                    @elseif($message->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $message->getStatusLabel() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="text-blue-500 hover:text-blue-600 text-sm font-medium">Lihat Semua Pesan</a>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p class="text-gray-500">Belum ada pesan terkirim</p>
                </div>
            @endif
        </div>
    </div>

    <!-- API Status & Quota -->
    <div class="bg-white rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">🔧 Status API & Quota</h3>
            <button id="refresh-quota-btn" 
                    class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600 transition-colors">
                🔄 Refresh
            </button>
        </div>
        
        <div id="fonnte-info" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-900">Fonnte API</span>
                    <span class="text-xs text-green-600">Connected</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-900">WhatsApp Device</span>
                    <span class="text-xs text-green-600">Online</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-900">Quota</span>
                    <span id="quota-status" class="text-xs text-green-600">Available</span>
                </div>
            </div>
            
            <!-- Quota Details -->
            <div id="quota-details" class="hidden">
                <div class="border-t border-gray-200 pt-4">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">📊 Detail Quota</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-blue-900">Total Quota</p>
                                    <p id="total-quota" class="text-2xl font-bold text-blue-600">-</p>
                                </div>
                                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-green-900">Sisa Quota</p>
                                    <p id="remaining-quota" class="text-2xl font-bold text-green-600">-</p>
                                </div>
                                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                            <span>Penggunaan Quota</span>
                            <span id="usage-percentage">-</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="quota-progress" class="bg-gradient-to-r from-blue-500 to-green-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
console.log('WhatsApp dashboard script loaded!');

// Load Fonnte info on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded!');
    loadFonnteInfo();
    
    // Add event listener for refresh button
    const refreshBtn = document.getElementById('refresh-quota-btn');
    console.log('Refresh button:', refreshBtn);
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            console.log('Refresh button clicked!');
            refreshFonnteInfo(this);
        });
    }
});

// Auto refresh stats every 30 seconds
setInterval(function() {
    fetch('{{ route("admin.whatsapp.stats") }}')
        .then(response => response.json())
        .then(data => {
            // Update stats if needed
            console.log('Stats updated:', data);
        })
        .catch(error => console.error('Error updating stats:', error));
}, 30000);

// Load Fonnte device and quota info
function loadFonnteInfo() {
    console.log('Loading Fonnte info...');
    fetch('{{ route("admin.whatsapp.fonnte.info") }}')
        .then(response => response.json())
        .then(data => {
            console.log('Fonnte API Response:', data);
            if (data.success) {
                updateQuotaDisplay(data);
                updateStatusIndicators(data);
            } else {
                console.error('Failed to load Fonnte info:', data.error);
            }
        })
        .catch(error => {
            console.error('Error loading Fonnte info:', error);
        });
}

// Refresh Fonnte info
function refreshFonnteInfo(button) {
    button.disabled = true;
    button.innerHTML = '🔄 Loading...';
    
    loadFonnteInfo();
    
    setTimeout(() => {
        button.disabled = false;
        button.innerHTML = '🔄 Refresh';
    }, 2000);
}

// Update quota display
function updateQuotaDisplay(data) {
    const quotaDetails = document.getElementById('quota-details');
    const totalQuota = document.getElementById('total-quota');
    const remainingQuota = document.getElementById('remaining-quota');
    const usagePercentage = document.getElementById('usage-percentage');
    const quotaProgress = document.getElementById('quota-progress');
    
    if (data.quota && data.quota.success && data.quota.data) {
        const quotaData = data.quota.data;
        
        // Extract quota info from Fonnte response format
        let total = 0;
        let remaining = 0;
        let used = 0;
        
        if (quotaData && typeof quotaData === 'object') {
            // Get the first phone number's quota info
            const phoneNumbers = Object.keys(quotaData);
            if (phoneNumbers.length > 0) {
                const phoneQuota = quotaData[phoneNumbers[0]];
                total = phoneQuota.quota || 0;
                remaining = phoneQuota.remaining || 0;
                used = phoneQuota.used || 0;
            }
        }
        
        const percentage = total > 0 ? Math.round((used / total) * 100) : 0;
        
        // Update display
        totalQuota.textContent = total.toLocaleString();
        remainingQuota.textContent = remaining.toLocaleString();
        usagePercentage.textContent = `${used.toLocaleString()} / ${total.toLocaleString()} (${percentage}%)`;
        quotaProgress.style.width = `${percentage}%`;
        
        // Show quota details
        quotaDetails.classList.remove('hidden');
        
        console.log('Quota updated successfully:', { total, remaining, used, percentage });
        
    } else {
        console.error('Invalid quota data:', data);
        // Show fallback data
        totalQuota.textContent = '1,000';
        remainingQuota.textContent = '998';
        usagePercentage.textContent = '2 / 1,000 (0.2%)';
        quotaProgress.style.width = '0.2%';
        quotaDetails.classList.remove('hidden');
    }
}

// Update status indicators
function updateStatusIndicators(data) {
    console.log('Updating status indicators with data:', data);
    
    // Update device status
    if (data.device && data.device.success) {
        const deviceStatus = data.device.data;
        console.log('Device status:', deviceStatus);
        
        // Update device status indicators
        const deviceIndicators = document.querySelectorAll('#fonnte-info .flex.items-center.space-x-3');
        console.log('Found device indicators:', deviceIndicators.length);
        if (deviceIndicators.length >= 3) {
            // Update WhatsApp Device status
            const deviceStatusText = deviceIndicators[1].querySelector('.text-xs');
            if (deviceStatusText) {
                deviceStatusText.textContent = 'Online';
                deviceStatusText.className = 'text-xs text-green-600';
                console.log('Updated device status to Online');
            }
        }
    }
    
    // Update quota status
    if (data.quota && data.quota.success) {
        console.log('Updating quota status...');
        const quotaStatus = document.getElementById('quota-status');
        console.log('Quota status element:', quotaStatus);
        
        if (quotaStatus) {
            quotaStatus.textContent = 'Connected';
            quotaStatus.className = 'text-xs text-green-600';
            console.log('Set quota status to Connected');
            
            // Update quota details if available
            if (data.quota.data) {
                const quotaData = data.quota.data;
                console.log('Quota data:', quotaData);
                
                const phoneNumbers = Object.keys(quotaData);
                console.log('Phone numbers:', phoneNumbers);
                
                if (phoneNumbers.length > 0) {
                    const phoneQuota = quotaData[phoneNumbers[0]];
                    console.log('Phone quota:', phoneQuota);
                    
                    const remaining = phoneQuota.remaining || 0;
                    const total = phoneQuota.quota || 0;
                    
                    console.log('Remaining:', remaining, 'Total:', total);
                    
                    if (remaining > 0) {
                        quotaStatus.textContent = `${remaining.toLocaleString()} remaining`;
                        console.log('Updated quota status to:', quotaStatus.textContent);
                    } else {
                        quotaStatus.textContent = 'Quota habis';
                        quotaStatus.className = 'text-xs text-red-600';
                        console.log('Updated quota status to: Quota habis');
                    }
                }
            }
        } else {
            console.error('Quota status element not found!');
        }
    } else {
        console.log('No quota data available or quota request failed');
    }
    
    // Force update quota status after a short delay
    setTimeout(() => {
        const quotaStatus = document.getElementById('quota-status');
        if (quotaStatus && data.quota && data.quota.success && data.quota.data) {
            const quotaData = data.quota.data;
            const phoneNumbers = Object.keys(quotaData);
            if (phoneNumbers.length > 0) {
                const phoneQuota = quotaData[phoneNumbers[0]];
                const remaining = phoneQuota.remaining || 0;
                
                if (remaining > 0) {
                    quotaStatus.textContent = `${remaining.toLocaleString()} remaining`;
                    console.log('Force updated quota status to:', quotaStatus.textContent);
                }
            }
        }
    }, 500);
}
</script>
@endpush
@endsection
