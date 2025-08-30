@extends('admin.layouts.admin')

@section('title', 'Check-in - ' . $event->title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                Check-in Event
            </h1>
            <p class="text-gray-600 mt-2">{{ $event->title }}</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.checkin.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-bold transition-all duration-300 transform hover:scale-105 shadow-lg">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </span>
            </a>
        </div>
    </div>

    <!-- Event Info & Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Event Info -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
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
                    <h3 class="text-lg font-bold text-gray-900">{{ $event->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $event->start_date->format('d M Y, H:i') }}</p>
                </div>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-gray-600">{{ $event->location }}</span>
                </div>
                
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-gray-600">{{ $stats['total'] }} peserta terdaftar</span>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Total Participants -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Peserta</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-participants">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Checked In -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Sudah Hadir</p>
                        <p class="text-2xl font-bold text-gray-900" id="checked-in">{{ $stats['checked_in'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Not Checked In -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Belum Hadir</p>
                        <p class="text-2xl font-bold text-gray-900" id="not-checked-in">{{ $stats['not_checked_in'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Check-in Interface -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Search & Check-in Form -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Check-in Peserta</h2>
            
            <!-- Search Form -->
            <div class="space-y-4">
                <div>
                    <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">
                        Nomor HP / WhatsApp
                    </label>
                    <div class="flex space-x-2">
                        <input type="tel" id="phone" name="phone" 
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300"
                               placeholder="081234567890">
                        <button type="button" id="search-btn"
                                class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:from-cyan-600 hover:to-blue-700 transition-all duration-300">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Participant Info -->
            <div id="participant-info" class="hidden mt-6">
                <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-200 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg" id="participant-initials"></span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900" id="participant-name"></h3>
                            <p class="text-sm text-gray-600" id="participant-phone"></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Asal Gereja</p>
                            <p class="text-sm font-medium text-gray-900" id="participant-church"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Bidang Pelayanan</p>
                            <p class="text-sm font-medium text-gray-900" id="participant-ministry"></p>
                        </div>
                    </div>
                    
                    <div id="checkin-status" class="mb-4">
                        <!-- Status will be populated by JavaScript -->
                    </div>
                    
                    <button type="button" id="checkin-btn" 
                            class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 px-6 rounded-xl font-bold hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Check-in Peserta
                        </span>
                    </button>
                </div>
            </div>

            <!-- Error Message -->
            <div id="error-message" class="hidden mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span id="error-text"></span>
                </div>
            </div>
        </div>

        <!-- Recent Check-ins -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Check-in Terbaru</h2>
            
            <div id="recent-checkins" class="space-y-4">
                @foreach($registrations->where('checked_in_at', '!=', null)->take(10) as $registration)
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($registration->name, 0, 2)) }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $registration->name }}</p>
                            <p class="text-sm text-gray-500">{{ $registration->checked_in_at->format('H:i') }} • {{ $registration->checked_in_by }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Hadir
                            </span>
                        </div>
                    </div>
                @endforeach
                
                @if($registrations->where('checked_in_at', '!=', null)->count() == 0)
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-sm">Belum ada peserta yang check-in</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('phone');
    const searchBtn = document.getElementById('search-btn');
    const participantInfo = document.getElementById('participant-info');
    const errorMessage = document.getElementById('error-message');
    const checkinBtn = document.getElementById('checkin-btn');
    
    let currentParticipant = null;

    // Search participant
    searchBtn.addEventListener('click', function() {
        const phone = phoneInput.value.trim();
        if (!phone) {
            showError('Masukkan nomor HP peserta');
            return;
        }

        searchParticipant(phone);
    });

    // Enter key to search
    phoneInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchBtn.click();
        }
    });

    // Check-in participant
    checkinBtn.addEventListener('click', function() {
        if (!currentParticipant) return;
        
        checkInParticipant(currentParticipant.id);
    });

    function searchParticipant(phone) {
        fetch(`{{ route('admin.checkin.search', $event->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ phone: phone })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showParticipantInfo(data.participant);
                hideError();
            } else {
                showError(data.message);
                hideParticipantInfo();
            }
        })
        .catch(error => {
            showError('Terjadi kesalahan saat mencari peserta');
            hideParticipantInfo();
        });
    }

    function showParticipantInfo(participant) {
        currentParticipant = participant;
        
        document.getElementById('participant-initials').textContent = participant.name.substring(0, 2).toUpperCase();
        document.getElementById('participant-name').textContent = participant.name;
        document.getElementById('participant-phone').textContent = participant.phone;
        document.getElementById('participant-church').textContent = participant.church || 'Tidak diisi';
        document.getElementById('participant-ministry').textContent = participant.ministry || 'Tidak diisi';
        
        const statusDiv = document.getElementById('checkin-status');
        const checkinBtn = document.getElementById('checkin-btn');
        
        if (participant.is_checked_in) {
            statusDiv.innerHTML = `
                <div class="flex items-center p-3 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-800 font-medium">Sudah check-in pada ${participant.checked_in_at}</span>
                </div>
            `;
            checkinBtn.disabled = true;
            checkinBtn.classList.add('opacity-50', 'cursor-not-allowed');
            checkinBtn.innerHTML = `
                <span class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Sudah Check-in
                </span>
            `;
        } else {
            statusDiv.innerHTML = `
                <div class="flex items-center p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-yellow-800 font-medium">Belum check-in</span>
                </div>
            `;
            checkinBtn.disabled = false;
            checkinBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            checkinBtn.innerHTML = `
                <span class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Check-in Peserta
                </span>
            `;
        }
        
        participantInfo.classList.remove('hidden');
    }

    function hideParticipantInfo() {
        participantInfo.classList.add('hidden');
        currentParticipant = null;
    }

    function showError(message) {
        document.getElementById('error-text').textContent = message;
        errorMessage.classList.remove('hidden');
    }

    function hideError() {
        errorMessage.classList.add('hidden');
    }

    function checkInParticipant(registrationId) {
        fetch(`{{ route('admin.checkin.checkin', $event->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ registration_id: registrationId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update stats
                updateStats(data.stats);
                
                // Show success message
                showSuccessMessage(data.message);
                
                // Update participant info
                if (currentParticipant) {
                    currentParticipant.is_checked_in = true;
                    currentParticipant.checked_in_at = data.participant.checked_in_at;
                    showParticipantInfo(currentParticipant);
                }
                
                // Clear phone input
                phoneInput.value = '';
                phoneInput.focus();
                
                // Reload page after 2 seconds to update recent check-ins
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            showError('Terjadi kesalahan saat check-in');
        });
    }

    function updateStats(stats) {
        document.getElementById('total-participants').textContent = stats.total;
        document.getElementById('checked-in').textContent = stats.checked_in;
        document.getElementById('not-checked-in').textContent = stats.not_checked_in;
    }

    function showSuccessMessage(message) {
        // Create success notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg z-50';
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Auto-refresh stats every 30 seconds
    setInterval(() => {
        fetch(`{{ route('admin.checkin.stats', $event->id) }}`)
        .then(response => response.json())
        .then(stats => {
            updateStats(stats);
        })
        .catch(error => {
            console.error('Error updating stats:', error);
        });
    }, 30000);
});
</script>
@endsection
