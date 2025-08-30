@extends('layouts.public')

@section('title', 'Daftar Event - ' . $event->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-cyan-50 via-blue-50 to-purple-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-cyan-600 transition-colors duration-300">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('events') }}" class="ml-1 text-gray-700 hover:text-cyan-600 transition-colors duration-300 md:ml-2">Event</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('events.show', $event->id) }}" class="ml-1 text-gray-700 hover:text-cyan-600 transition-colors duration-300 md:ml-2">{{ Str::limit($event->title, 30) }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-500 md:ml-2">Daftar</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Registration Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2 bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">Daftar Event</h1>
                        <p class="text-gray-600">Isi form di bawah ini untuk mendaftar event "{{ $event->title }}"</p>
                    </div>

                    @if($errors->any())
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6">
                            <div class="font-bold mb-2">Terjadi kesalahan:</div>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('events.register.store', $event->id) }}" class="space-y-6">
                        @csrf
                        
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 @error('name') border-red-500 @enderror"
                                   placeholder="Masukkan nama lengkap Anda">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>



                        <!-- Nomor HP/WA -->
                        <div>
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">
                                Nomor HP / WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 @error('phone') border-red-500 @enderror"
                                   placeholder="081234567890">
                            <p class="mt-2 text-sm text-amber-600 font-medium">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <strong>PENTING:</strong> Pastikan nomor WhatsApp valid! Bukti pendaftaran dan informasi penting akan dikirim ke nomor ini.
                            </p>
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Asal Gereja -->
                        <div>
                            <label for="church" class="block text-sm font-bold text-gray-700 mb-2">
                                Asal Gereja <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="church" id="church" value="{{ old('church') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 @error('church') border-red-500 @enderror"
                                   placeholder="Contoh: GSJA Kairos Manado">
                            @error('church')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bidang Pelayanan -->
                        <div>
                            <label for="ministry" class="block text-sm font-bold text-gray-700 mb-2">
                                Bidang Pelayanan <span class="text-red-500">*</span>
                            </label>
                            <select name="ministry" id="ministry" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 @error('ministry') border-red-500 @enderror">
                                <option value="">Pilih bidang pelayanan</option>
                                <option value="Gembala Sidang" {{ old('ministry') == 'Gembala Sidang' ? 'selected' : '' }}>Gembala Sidang</option>
                                <option value="Pengerja" {{ old('ministry') == 'Pengerja' ? 'selected' : '' }}>Pengerja</option>
                                <option value="Worship Leader" {{ old('ministry') == 'Worship Leader' ? 'selected' : '' }}>Worship Leader</option>
                                <option value="Singers" {{ old('ministry') == 'Singers' ? 'selected' : '' }}>Singers</option>
                                <option value="Tim Musik" {{ old('ministry') == 'Tim Musik' ? 'selected' : '' }}>Tim Musik</option>
                            </select>
                            @error('ministry')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan Tambahan -->
                        <div>
                            <label for="notes" class="block text-sm font-bold text-gray-700 mb-2">
                                Catatan Tambahan <span class="text-gray-500 text-xs">(Opsional)</span>
                            </label>
                            <textarea name="notes" id="notes" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 @error('notes') border-red-500 @enderror"
                                      placeholder="Catatan tambahan atau informasi khusus (opsional)">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Informasi Penting -->
                        <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-200 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-cyan-900 mb-3">Informasi Penting</h4>
                                    <ul class="text-sm text-cyan-800 space-y-2">
                                        <li class="flex items-start">
                                            <svg class="w-4 h-4 text-cyan-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Pendaftaran ini bersifat gratis
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-4 h-4 text-cyan-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Pastikan data yang diisi benar dan lengkap
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-4 h-4 text-cyan-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Bukti pendaftaran akan dikirim via WhatsApp
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-4 h-4 text-cyan-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Informasi penting akan dikirim via WhatsApp
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-4 h-4 text-cyan-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Harap hadir tepat waktu sesuai jadwal event
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('events.show', $event->id) }}" 
                               class="text-gray-600 hover:text-cyan-600 font-medium transition-colors duration-300">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Kembali ke Detail Event
                                </span>
                            </a>
                            <button type="submit" 
                                    class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Daftar Event
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Event Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sticky top-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-5 h-5 text-cyan-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Detail Event
                    </h3>
                    
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">{{ $event->title }}</h4>
                            <p class="text-sm text-gray-600">{{ Str::limit($event->description, 120) }}</p>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                                <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Tanggal & Waktu</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $event->start_date->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Lokasi</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $event->location }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-xl flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Sisa Kursi</p>
                                    <p class="text-lg font-bold text-purple-600">{{ $event->available_seats }} seat tersisa</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-t pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Status Event:</span>
                                @if($event->isFull())
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Penuh</span>
                                @else
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Tersedia</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('phone');
    const submitButton = document.querySelector('button[type="submit"]');
    
    // Format phone number as user types
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
        
        // Ensure it starts with 08 for Indonesian mobile numbers
        if (value.length > 0 && !value.startsWith('08')) {
            value = '08' + value.replace(/^08/, '');
        }
        
        // Limit to 13 digits (08xxxxxxxxxx)
        if (value.length > 13) {
            value = value.substring(0, 13);
        }
        
        e.target.value = value;
        
        // Validate phone number format
        validatePhoneNumber(value);
    });
    
    function validatePhoneNumber(phone) {
        const phoneRegex = /^08[0-9]{8,11}$/;
        const isValid = phoneRegex.test(phone);
        
        // Update visual feedback
        if (phone.length > 0) {
            if (isValid) {
                phoneInput.classList.remove('border-red-500');
                phoneInput.classList.add('border-green-500');
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                phoneInput.classList.remove('border-green-500');
                phoneInput.classList.add('border-red-500');
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        } else {
            phoneInput.classList.remove('border-red-500', 'border-green-500');
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
    
    // Form submission validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const phone = phoneInput.value;
        const phoneRegex = /^08[0-9]{8,11}$/;
        
        if (!phoneRegex.test(phone)) {
            e.preventDefault();
            alert('⚠️ PENTING: Pastikan nomor WhatsApp valid (format: 08xxxxxxxxxx)!\n\nBukti pendaftaran dan informasi penting akan dikirim ke nomor ini.');
            phoneInput.focus();
            return false;
        }
    });
});
</script>
