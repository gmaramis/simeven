@extends('admin.layouts.admin')

@section('title', 'Daftar Peserta - ' . $event->title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                Daftar Peserta Event
            </h1>
            <p class="text-gray-600 mt-2">{{ $event->title }}</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.events.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-bold transition-all duration-300 transform hover:scale-105 shadow-lg">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </span>
            </a>
            <a href="{{ route('admin.events.participants.print', $event->id) }}" 
               target="_blank"
               class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Daftar
                </span>
            </a>
        </div>
    </div>

    <!-- Event Info -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-center p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-xl">
                <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tanggal & Waktu</p>
                    <p class="font-bold text-gray-900">{{ $event->start_date->format('d M Y, H:i') }}</p>
                </div>
            </div>
            
            <div class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Peserta</p>
                    <p class="font-bold text-gray-900">{{ $participants->count() }} orang</p>
                </div>
            </div>
            
            <div class="flex items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl">
                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Lokasi</p>
                    <p class="font-bold text-gray-900">{{ $event->location }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions Bar -->
    <div id="bulk-actions-bar" class="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-4 mb-6 hidden">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-red-800">
                    <span id="selected-count">0</span> peserta dipilih
                </span>
                <button type="button" id="deselect-all" class="text-red-600 hover:text-red-800 text-sm font-medium">
                    Batalkan Pilihan
                </button>
            </div>
            <form method="POST" action="{{ route('admin.registrations.bulk-delete') }}" id="bulk-delete-form" class="inline">
                @csrf
                @method('DELETE')
                <input type="hidden" name="selected_registrations" id="selected-registrations-input">
                <button type="submit" 
                        class="bg-red-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-700 transition-all duration-300 flex items-center space-x-2"
                        onclick="return confirm('⚠️ PERHATIAN!\n\nAnda yakin ingin menghapus semua peserta yang dipilih?\n\nTindakan ini tidak dapat dibatalkan dan akan mengembalikan seat ke event {{ $event->title }}.')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span>Hapus yang Dipilih</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Participants List -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Daftar Peserta Terkonfirmasi</h2>
            <p class="text-sm text-gray-600 mt-1">Peserta yang sudah dikonfirmasi untuk event ini</p>
        </div>
        
        @if($participants->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            No.
                        </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Nama Lengkap
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Asal Gereja
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Bidang Pelayanan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Kontak
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Tanggal Daftar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($participants as $index => $participant)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="selected_participants[]" value="{{ $participant->id }}" 
                                           class="participant-checkbox rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center mr-4">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($participant->name, 0, 2)) }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $participant->name }}</div>
                                            @if($participant->notes)
                                                <div class="text-xs text-gray-500 mt-1">{{ Str::limit($participant->notes, 30) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $participant->church ?? 'Tidak diisi' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-cyan-100 text-cyan-800">
                                        {{ $participant->ministry ?? 'Tidak diisi' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $participant->phone }}</div>
                                    <div class="text-sm text-gray-500">{{ $participant->email ?? 'Tidak diisi' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $participant->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.registrations.edit', $participant->id) }}" 
                                           class="text-cyan-600 hover:text-cyan-700 transition-colors duration-200" 
                                           title="Edit Pendaftaran">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.registrations.destroy', $participant->id) }}" class="inline" 
                                              onsubmit="return confirm('⚠️ PERHATIAN!\n\nAnda yakin ingin menghapus pendaftaran {{ $participant->name }}?\n\nTindakan ini tidak dapat dibatalkan dan akan mengembalikan seat ke event {{ $event->title }}.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 transition-colors duration-200" 
                                                    title="Hapus Pendaftaran">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <div class="text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p class="text-lg font-medium">Belum ada peserta terkonfirmasi</p>
                    <p class="text-sm">Peserta akan muncul di sini setelah pendaftaran dikonfirmasi</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const participantCheckboxes = document.querySelectorAll('.participant-checkbox');
    const bulkActionsBar = document.getElementById('bulk-actions-bar');
    const selectedCountSpan = document.getElementById('selected-count');
    const deselectAllButton = document.getElementById('deselect-all');
    const selectedRegistrationsInput = document.getElementById('selected-registrations-input');
    const bulkDeleteForm = document.getElementById('bulk-delete-form');

    // Select All functionality
    selectAllCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        participantCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        updateBulkActionsBar();
    });

    // Individual checkbox functionality
    participantCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllCheckbox();
            updateBulkActionsBar();
        });
    });

    // Deselect All functionality
    deselectAllButton.addEventListener('click', function() {
        selectAllCheckbox.checked = false;
        participantCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateBulkActionsBar();
    });

    // Update Select All checkbox state
    function updateSelectAllCheckbox() {
        const checkedCount = document.querySelectorAll('.participant-checkbox:checked').length;
        const totalCount = participantCheckboxes.length;
        
        if (checkedCount === 0) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        } else if (checkedCount === totalCount) {
            selectAllCheckbox.checked = true;
            selectAllCheckbox.indeterminate = false;
        } else {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = true;
        }
    }

    // Update Bulk Actions Bar
    function updateBulkActionsBar() {
        const checkedCheckboxes = document.querySelectorAll('.participant-checkbox:checked');
        const selectedCount = checkedCheckboxes.length;
        
        if (selectedCount > 0) {
            bulkActionsBar.classList.remove('hidden');
            selectedCountSpan.textContent = selectedCount;
            
            // Update hidden input with selected registration IDs
            const selectedIds = Array.from(checkedCheckboxes).map(checkbox => checkbox.value);
            selectedRegistrationsInput.value = JSON.stringify(selectedIds);
        } else {
            bulkActionsBar.classList.add('hidden');
            selectedRegistrationsInput.value = '';
        }
    }

    // Bulk Delete Form Submit
    bulkDeleteForm.addEventListener('submit', function(e) {
        const checkedCheckboxes = document.querySelectorAll('.participant-checkbox:checked');
        if (checkedCheckboxes.length === 0) {
            e.preventDefault();
            alert('Pilih setidaknya satu peserta untuk dihapus.');
            return false;
        }
    });
});
</script>
