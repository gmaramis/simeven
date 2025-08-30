@extends('admin.layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Edit Pendaftaran</h2>
                    <p class="text-gray-600 mt-2">Edit informasi pendaftar "{{ $registration->name }}"</p>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                        <div class="font-medium">Terjadi kesalahan:</div>
                        <ul class="mt-1 list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Edit Registration Form -->
                <form method="POST" action="{{ route('admin.registrations.update', $registration->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="event_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Event <span class="text-red-500">*</span>
                            </label>
                            <select name="event_id" id="event_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('event_id') border-red-500 @enderror">
                                <option value="">Pilih Event</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" 
                                            {{ old('event_id', $registration->event_id) == $event->id ? 'selected' : '' }}
                                            {{ $event->isFull() && $event->id != $registration->event_id ? 'disabled' : '' }}>
                                        {{ $event->title }} 
                                        ({{ $event->start_date->format('d M Y, H:i') }})
                                        @if($event->isFull() && $event->id != $registration->event_id)
                                            - PENUH
                                        @else
                                            - {{ $event->available_seats }} seat tersisa
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('event_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                                <option value="pending" {{ old('status', $registration->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status', $registration->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ old('status', $registration->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $registration->name) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                   placeholder="Masukkan nama lengkap">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $registration->phone) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                               placeholder="081234567890">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Tambahan
                        </label>
                        <textarea name="notes" id="notes" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror"
                                  placeholder="Catatan tambahan (opsional)">{{ old('notes', $registration->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-yellow-900 mb-1">Perhatian</h4>
                                <ul class="text-sm text-yellow-800 space-y-1">
                                    <li>• Jika mengubah event, pastikan event baru masih memiliki seat tersedia</li>
                                    <li>• Perubahan status akan mempengaruhi seat availability</li>
                                    <li>• Pastikan semua informasi sudah benar sebelum menyimpan</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.registrations.index') }}" 
                               class="text-gray-600 hover:text-gray-800 font-medium">
                                ← Kembali ke Daftar Pendaftar
                            </a>
                            <form method="POST" action="{{ route('admin.registrations.destroy', $registration->id) }}" class="inline" 
                                  onsubmit="return confirm('⚠️ PERHATIAN!\n\nAnda yakin ingin menghapus pendaftaran {{ $registration->name }}?\n\nTindakan ini tidak dapat dibatalkan dan akan mengembalikan seat ke event {{ $registration->event->title }}.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-300 font-semibold">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300 font-semibold">
                            Update Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
