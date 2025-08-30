@extends('admin.layouts.admin')

@section('title', 'Tambah Event Baru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">
                Tambah Event Baru
            </h1>
            <p class="text-gray-600 mt-2">Buat event rohani baru untuk GSJA Kairos Manado</p>
        </div>
        <a href="{{ route('admin.events.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-bold transition-all duration-300 transform hover:scale-105 shadow-lg">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </span>
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">
                        Judul Event <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300"
                           placeholder="Masukkan judul event"
                           required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                        Deskripsi Event <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300"
                              placeholder="Jelaskan detail event ini"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-bold text-gray-700 mb-2">
                        Tanggal & Waktu Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" 
                           name="start_date" 
                           id="start_date" 
                           value="{{ old('start_date') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300"
                           required>
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-bold text-gray-700 mb-2">
                        Tanggal & Waktu Selesai <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" 
                           name="end_date" 
                           id="end_date" 
                           value="{{ old('end_date') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300"
                           required>
                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-bold text-gray-700 mb-2">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="location" 
                           id="location" 
                           value="{{ old('location') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300"
                           placeholder="Contoh: GSJA Kairos Manado"
                           required>
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total Seats -->
                <div>
                    <label for="total_seats" class="block text-sm font-bold text-gray-700 mb-2">
                        Kapasitas Maksimal <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="total_seats" 
                           id="total_seats" 
                           value="{{ old('total_seats') }}" 
                           min="1"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300"
                           placeholder="Contoh: 100"
                           required>
                    @error('total_seats')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-bold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" 
                            id="status" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300"
                            required>
                        <option value="">Pilih status</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload with Specifications -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-bold text-gray-700 mb-2">
                        Gambar Event (Opsional)
                    </label>
                    
                    <!-- Image Specifications -->
                    <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-200 rounded-xl p-4 mb-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-cyan-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="text-sm font-bold text-cyan-900 mb-2">Spesifikasi Gambar Event</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-cyan-800">
                                    <div>
                                        <p class="font-semibold mb-1">📏 Ukuran yang Direkomendasikan:</p>
                                        <ul class="space-y-1 ml-4">
                                            <li>• <strong>1200 x 800 pixel</strong> (Rasio 3:2)</li>
                                            <li>• <strong>800 x 600 pixel</strong> (Rasio 4:3)</li>
                                            <li>• <strong>Minimal: 600 x 400 pixel</strong></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <p class="font-semibold mb-1">📁 Format & Ukuran File:</p>
                                        <ul class="space-y-1 ml-4">
                                            <li>• <strong>Format:</strong> JPG, PNG, GIF</li>
                                            <li>• <strong>Maksimal:</strong> 2 MB</li>
                                            <li>• <strong>Minimal:</strong> 50 KB</li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="text-xs text-cyan-700 mt-2 italic">
                                    💡 Tips: Gunakan gambar dengan rasio landscape (mendatar) untuk tampilan yang optimal di website
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Upload Area -->
                    <div class="flex items-center justify-center w-full">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all duration-300">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500">
                                    <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                </p>
                                <p class="text-xs text-gray-500">JPG, PNG, GIF (MAX. 2MB) • 1200x800px direkomendasikan</p>
                            </div>
                            <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                        </label>
                    </div>
                    
                    <!-- Preview Area -->
                    <div id="image-preview" class="hidden mt-4">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm font-semibold text-gray-700 mb-2">Preview Gambar:</p>
                            <div class="flex items-center space-x-4">
                                <img id="preview-img" class="w-24 h-16 object-cover rounded-lg border border-gray-200" src="" alt="Preview">
                                <div>
                                    <p id="file-info" class="text-sm text-gray-600"></p>
                                    <button type="button" id="remove-image" class="text-red-600 hover:text-red-700 text-sm font-medium mt-1">
                                        Hapus gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.events.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition-all duration-300">
                    Batal
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-xl font-bold hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Event
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-fill end date when start date changes
document.getElementById('start_date').addEventListener('change', function() {
    const startDate = this.value;
    if (startDate) {
        // Set end date to start date + 2 hours by default
        const startDateTime = new Date(startDate);
        startDateTime.setHours(startDateTime.getHours() + 2);
        
        const endDateInput = document.getElementById('end_date');
        endDateInput.value = startDateTime.toISOString().slice(0, 16);
    }
});

// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const fileInfo = document.getElementById('file-info');
    
    if (file) {
        // Check file size (2MB = 2 * 1024 * 1024 bytes)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB.');
            this.value = '';
            return;
        }
        
        // Check file type
        if (!file.type.match('image.*')) {
            alert('File harus berupa gambar!');
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
            
            // Display file info
            const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
            fileInfo.textContent = `${file.name} (${sizeInMB} MB)`;
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
});

// Remove image
document.getElementById('remove-image').addEventListener('click', function() {
    document.getElementById('image').value = '';
    document.getElementById('image-preview').classList.add('hidden');
});
</script>
@endsection
