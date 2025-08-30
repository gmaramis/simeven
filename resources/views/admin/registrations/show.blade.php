@extends('admin.layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Detail Pendaftaran</h2>
                    <p class="text-gray-600 mt-1">Informasi lengkap pendaftar</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.registrations.edit', $registration->id) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Pendaftaran
                    </a>
                    <a href="{{ route('admin.registrations.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Registration Details -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pendaftar</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $registration->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <p class="text-lg text-gray-900">{{ $registration->email }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <p class="text-lg text-gray-900">{{ $registration->phone }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <div class="mt-1">
                                    @if($registration->status === 'confirmed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            Confirmed
                                        </span>
                                    @elseif($registration->status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            Cancelled
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($registration->notes)
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-md">{{ $registration->notes }}</p>
                            </div>
                        @endif

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Daftar</label>
                                    <p class="text-gray-900">{{ $registration->created_at->format('d M Y, H:i') }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Update</label>
                                    <p class="text-gray-900">{{ $registration->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Event</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Event</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $registration->event->title }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                <p class="text-lg text-gray-900">{{ $registration->event->location }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu</label>
                                <p class="text-lg text-gray-900">
                                    {{ $registration->event->start_date->format('d M Y, H:i') }} - 
                                    {{ $registration->event->end_date->format('H:i') }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas Event</label>
                                <p class="text-lg text-gray-900">
                                    {{ $registration->event->available_seats }} tersisa dari {{ $registration->event->total_seats }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Event</label>
                            <p class="text-gray-900 bg-gray-50 p-3 rounded-md">{{ $registration->event->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                        
                        <div class="space-y-3">
                            @if($registration->status === 'pending')
                                <form method="POST" action="{{ route('admin.registrations.confirm', $registration->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition duration-300">
                                        Konfirmasi Pendaftaran
                                    </button>
                                </form>
                            @endif

                            @if($registration->status !== 'cancelled')
                                <form method="POST" action="{{ route('admin.registrations.cancel', $registration->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition duration-300"
                                            onclick="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini?')">
                                        Batalkan Pendaftaran
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('admin.events.show', $registration->event->id) }}" 
                               class="block w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 text-center">
                                Lihat Detail Event
                            </a>

                            <a href="{{ route('admin.registrations.index') }}?event_id={{ $registration->event->id }}" 
                               class="block w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 transition duration-300 text-center">
                                Lihat Pendaftar Lainnya
                            </a>
                            
                            <form method="POST" action="{{ route('admin.registrations.destroy', $registration->id) }}" 
                                  onsubmit="return confirm('⚠️ PERHATIAN!\n\nAnda yakin ingin menghapus pendaftaran {{ $registration->name }}?\n\nTindakan ini tidak dapat dibatalkan dan akan mengembalikan seat ke event {{ $registration->event->title }}.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition duration-300">
                                    🗑️ Hapus Pendaftaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Registration Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pendaftaran</h3>
                        
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Pendaftaran:</span>
                                <span class="text-gray-900">#{{ $registration->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Event:</span>
                                <span class="text-gray-900">#{{ $registration->event->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Event:</span>
                                <span class="text-gray-900">
                                    @if($registration->event->status === 'published')
                                        <span class="text-green-600">Published</span>
                                    @elseif($registration->event->status === 'draft')
                                        <span class="text-gray-600">Draft</span>
                                    @elseif($registration->event->status === 'ongoing')
                                        <span class="text-blue-600">Ongoing</span>
                                    @else
                                        <span class="text-red-600">Completed</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Kontak Pendaftar</h3>
                        
                        <div class="space-y-3">
                            <a href="mailto:{{ $registration->email }}" 
                               class="block w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 text-center">
                                Kirim Email
                            </a>
                            <a href="tel:{{ $registration->phone }}" 
                               class="block w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition duration-300 text-center">
                                Telepon
                            </a>
                            <a href="https://wa.me/{{ $registration->phone }}" 
                               target="_blank"
                               class="block w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 transition duration-300 text-center">
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
