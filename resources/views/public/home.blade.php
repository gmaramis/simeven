@extends('layouts.public')

@section('title', 'Beranda - GSJA Kairos Manado')

@section('content')
<!-- Hero Section with Bright Modern Design -->
<div class="relative overflow-hidden bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-600">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-bounce"></div>
        <div class="absolute top-20 right-20 w-16 h-16 bg-white/10 rounded-full animate-pulse"></div>
        <div class="absolute bottom-20 left-20 w-12 h-12 bg-white/10 rounded-full animate-spin"></div>
        <div class="absolute bottom-10 right-10 w-24 h-24 bg-white/10 rounded-full animate-ping"></div>
    </div>
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <div class="text-center">
            <!-- Animated Church Badge -->
            <div class="inline-flex items-center px-6 py-3 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-white text-sm font-medium mb-8 animate-pulse hover:scale-105 transition-transform duration-300">
                <svg class="w-5 h-5 mr-3 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                Gereja Sidang Jemaat Allah Kairos Manado
            </div>
            
            <h1 class="text-6xl md:text-8xl font-bold mb-6 bg-gradient-to-r from-white via-yellow-200 to-orange-200 bg-clip-text text-transparent leading-tight animate-fade-in-up">
                Event GSJA Kairos
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-white max-w-3xl mx-auto leading-relaxed animate-fade-in-up animation-delay-200">
                Daftar event rohani GSJA Kairos Manado dengan mudah dan cepat. 
                Bergabunglah dalam persekutuan yang penuh makna dan pertumbuhan iman.
            </p>
            
            <!-- Modern CTA Buttons with Hover Effects -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center animate-fade-in-up animation-delay-400">
                <a href="{{ route('events') }}" 
                   class="group relative px-10 py-5 bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-2xl font-bold hover:from-yellow-500 hover:to-orange-600 transition-all duration-500 transform hover:scale-110 hover:shadow-2xl shadow-lg">
                    <span class="relative z-10 flex items-center">
                        Lihat Event Kami
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </a>
                <a href="{{ route('contact') }}" 
                   class="group px-10 py-5 border-2 border-white/40 text-white rounded-2xl font-bold hover:bg-white/20 backdrop-blur-sm transition-all duration-500 transform hover:scale-110 hover:shadow-2xl">
                    <span class="flex items-center">
                        Hubungi Kami
                        <svg class="w-5 h-5 ml-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </span>
                </a>
            </div>
            
            <!-- Animated Stats -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-3xl mx-auto animate-fade-in-up animation-delay-600">
                <div class="text-center group">
                    <div class="text-4xl font-bold text-white mb-2 group-hover:scale-110 transition-transform duration-300">{{ $events->count() }}+</div>
                    <div class="text-yellow-200 text-sm font-medium">Event Rohani</div>
                </div>
                <div class="text-center group">
                    <div class="text-4xl font-bold text-white mb-2 group-hover:scale-110 transition-transform duration-300">100%</div>
                    <div class="text-yellow-200 text-sm font-medium">Gratis</div>
                </div>
                <div class="text-center group">
                    <div class="text-4xl font-bold text-white mb-2 group-hover:scale-110 transition-transform duration-300">Manado</div>
                    <div class="text-yellow-200 text-sm font-medium">Lokasi</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Animated Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="w-full h-20 text-white animate-wave" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".3" fill="currentColor"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".6" fill="currentColor"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="currentColor"></path>
        </svg>
    </div>
</div>

<!-- Upcoming Events Section with Bright Design -->
<div class="py-20 bg-gradient-to-b from-white via-blue-50 to-cyan-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-bold mb-8 animate-bounce">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                </svg>
                Event Mendatang
            </div>
            <h2 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">Event Rohani GSJA Kairos</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Bergabunglah dalam event-event rohani yang akan memperkaya iman dan persekutuan kita di GSJA Kairos Manado</p>
        </div>

        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                    <div class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 overflow-hidden border border-gray-100 animate-fade-in-up">
                        @if($event->image)
                            <div class="relative overflow-hidden h-56">
                                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-125 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            </div>
                        @else
                            <div class="relative h-56 bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-600 flex items-center justify-center overflow-hidden">
                                <div class="absolute inset-0 bg-black/20"></div>
                                <div class="absolute inset-0 bg-gradient-to-r from-cyan-400/50 to-purple-600/50 animate-pulse"></div>
                                <svg class="w-20 h-20 text-white relative z-10 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="p-8">
                            <!-- Event Status Badge -->
                            <div class="flex items-center justify-between mb-6">
                                @if($event->isFull())
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-red-100 text-red-800 animate-pulse">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Penuh
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800 animate-bounce">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Tersedia
                                    </span>
                                @endif
                                <span class="text-sm text-gray-500 font-medium">{{ $event->start_date->diffForHumans() }}</span>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-cyan-600 transition-colors duration-300">{{ $event->title }}</h3>
                            <p class="text-gray-600 mb-6 line-clamp-2">{{ Str::limit($event->description, 120) }}</p>
                            
                            <!-- Event Details with Icons -->
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center text-sm text-gray-500 group-hover:text-cyan-600 transition-colors duration-300">
                                    <svg class="w-5 h-5 mr-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $event->start_date->format('d M Y, H:i') }}
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-500 group-hover:text-cyan-600 transition-colors duration-300">
                                    <svg class="w-5 h-5 mr-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $event->location }}
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-500 group-hover:text-cyan-600 transition-colors duration-300">
                                    <svg class="w-5 h-5 mr-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    {{ $event->available_seats }} seat tersisa
                                </div>
                            </div>
                            
                            <!-- Action Buttons with Gradient -->
                            <div class="flex space-x-4">
                                <a href="{{ route('events.show', $event->id) }}" 
                                   class="flex-1 bg-gray-100 text-gray-700 text-center py-4 px-6 rounded-2xl font-bold hover:bg-gray-200 transition-all duration-300 transform hover:scale-105">
                                    Detail
                                </a>
                                @if(!$event->isFull())
                                    <a href="{{ route('events.register', $event->id) }}" 
                                       class="flex-1 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-center py-4 px-6 rounded-2xl font-bold hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        Daftar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-16">
                <a href="{{ route('events') }}" 
                   class="inline-flex items-center px-10 py-5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl font-bold hover:from-cyan-600 hover:to-blue-700 transition-all duration-500 transform hover:scale-110 shadow-xl hover:shadow-2xl animate-pulse">
                    Lihat Semua Event
                    <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-32 h-32 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
                    <svg class="w-16 h-16 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Belum ada event</h3>
                <p class="text-gray-600 max-w-md mx-auto text-lg">Event akan ditampilkan di sini ketika tersedia. Tetap pantau halaman ini untuk event rohani terbaru dari GSJA Kairos!</p>
            </div>
        @endif
    </div>
</div>

<!-- Features Section with Bright Colors -->
<div class="py-20 bg-gradient-to-br from-cyan-50 via-blue-50 to-purple-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white text-sm font-bold mb-8 animate-pulse">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                </svg>
                Kemudahan Pendaftaran
            </div>
            <h2 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Mengapa Daftar di Sini?</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Platform pendaftaran event yang dirancang khusus untuk memudahkan jemaat GSJA Kairos Manado</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group text-center p-10 bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 border border-gray-100 animate-fade-in-up">
                <div class="w-24 h-24 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-500 animate-bounce">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Pendaftaran Cepat</h3>
                <p class="text-gray-600 leading-relaxed">Daftar event dengan mudah dalam hitungan menit. Proses yang simpel dan tidak ribet.</p>
            </div>
            
            <div class="group text-center p-10 bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 border border-gray-100 animate-fade-in-up animation-delay-200">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-400 to-pink-500 rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-500 animate-pulse">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">100% Terpercaya</h3>
                <p class="text-gray-600 leading-relaxed">Event resmi dari GSJA Kairos Manado. Keamanan dan kepercayaan adalah prioritas kami.</p>
            </div>
            
            <div class="group text-center p-10 bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-4 border border-gray-100 animate-fade-in-up animation-delay-400">
                <div class="w-24 h-24 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-500 animate-spin">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Update Real-time</h3>
                <p class="text-gray-600 leading-relaxed">Informasi event yang selalu up-to-date. Dapatkan notifikasi real-time untuk event terbaru.</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section with Bright Gradient -->
<div class="py-20 bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-32 h-32 bg-white/10 rounded-full animate-bounce"></div>
        <div class="absolute top-20 right-20 w-24 h-24 bg-white/10 rounded-full animate-pulse"></div>
        <div class="absolute bottom-20 left-20 w-20 h-20 bg-white/10 rounded-full animate-spin"></div>
        <div class="absolute bottom-10 right-10 w-28 h-28 bg-white/10 rounded-full animate-ping"></div>
    </div>
    
    <div class="relative max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-5xl md:text-6xl font-bold text-white mb-6 animate-fade-in-up">Siap Bergabung?</h2>
        <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto animate-fade-in-up animation-delay-200">Jangan lewatkan kesempatan untuk terhubung dengan komunitas GSJA Kairos Manado yang penuh kasih dan pertumbuhan rohani.</p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center animate-fade-in-up animation-delay-400">
            <a href="{{ route('events') }}" 
               class="px-10 py-5 bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-2xl font-bold hover:from-yellow-500 hover:to-orange-600 transition-all duration-500 transform hover:scale-110 shadow-xl hover:shadow-2xl">
                Lihat Event Kami
            </a>
            <a href="{{ route('contact') }}" 
               class="px-10 py-5 border-2 border-white/40 text-white rounded-2xl font-bold hover:bg-white/20 backdrop-blur-sm transition-all duration-500 transform hover:scale-110">
                Hubungi Kami
            </a>
        </div>
    </div>
</div>

<style>
@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes wave {
    0%, 100% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(-10px);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
}

.animate-wave {
    animation: wave 3s ease-in-out infinite;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}

.animation-delay-600 {
    animation-delay: 0.6s;
}
</style>
@endsection
