@extends('admin.layouts.admin')

@section('title', 'Kelola Pendaftaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                Kelola Pendaftaran
            </h1>
            <p class="text-gray-600 mt-2">Kelola semua pendaftaran event GSJA Kairos Manado</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu Konfirmasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $registrations->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Dikonfirmasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $registrations->where('status', 'confirmed')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-pink-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Dibatalkan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $registrations->where('status', 'cancelled')->count() }}</p>
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
                        onclick="return confirm('⚠️ PERHATIAN!\n\nAnda yakin ingin menghapus semua peserta yang dipilih?\n\nTindakan ini tidak dapat dibatalkan dan akan mengembalikan seat ke event terkait.')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span>Hapus yang Dipilih</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Registrations List -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-purple-50 to-pink-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Peserta
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Event
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Gereja & Pelayanan
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Kontak
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Tanggal Daftar
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($registrations as $registration)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <input type="checkbox" name="selected_registrations[]" value="{{ $registration->id }}" 
                                       class="registration-checkbox rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-white font-bold text-sm">{{ strtoupper(substr($registration->name, 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $registration->name }}</div>
                                        @if($registration->notes)
                                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($registration->notes, 30) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $registration->event->title }}</div>
                                <div class="text-sm text-gray-500">{{ $registration->event->start_date->format('d M Y, H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $registration->church ?? 'Tidak diisi' }}</div>
                                <div class="text-sm text-gray-500">{{ $registration->ministry ?? 'Tidak diisi' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $registration->phone }}</div>
                                <div class="text-sm text-gray-500">WhatsApp</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $registration->created_at->format('d M Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $registration->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($registration->status === 'confirmed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Dikonfirmasi
                                    </span>
                                @elseif($registration->status === 'cancelled')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Dibatalkan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.registrations.edit', $registration->id) }}" 
                                       class="text-cyan-600 hover:text-cyan-700 transition-colors duration-200 flex items-center" 
                                       title="Edit Pendaftaran">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    @if($registration->status === 'pending')
                                        <form method="POST" action="{{ route('admin.registrations.confirm', $registration->id) }}" class="inline flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:text-green-700 transition-colors duration-200 flex items-center" 
                                                    title="Konfirmasi Pendaftaran">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.registrations.cancel', $registration->id) }}" class="inline flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-600 hover:text-red-700 transition-colors duration-200 flex items-center" 
                                                    title="Batalkan Pendaftaran">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.registrations.destroy', $registration->id) }}" class="inline flex items-center" 
                                          onsubmit="return confirm('⚠️ PERHATIAN!\n\nAnda yakin ingin menghapus pendaftaran {{ $registration->name }}?\n\nTindakan ini tidak dapat dibatalkan dan akan mengembalikan seat ke event {{ $registration->event->title }}.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 transition-colors duration-200 flex items-center" 
                                                title="Hapus Pendaftaran">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada pendaftaran</p>
                                    <p class="text-sm">Pendaftaran akan muncul di sini ketika ada peserta yang mendaftar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($registrations->hasPages())
        <div class="flex items-center justify-center">
            {{ $registrations->links() }}
        </div>
    @endif
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const registrationCheckboxes = document.querySelectorAll('.registration-checkbox');
    const bulkActionsBar = document.getElementById('bulk-actions-bar');
    const selectedCountSpan = document.getElementById('selected-count');
    const deselectAllButton = document.getElementById('deselect-all');
    const selectedRegistrationsInput = document.getElementById('selected-registrations-input');
    const bulkDeleteForm = document.getElementById('bulk-delete-form');

    // Select All functionality
    selectAllCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        registrationCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        updateBulkActionsBar();
    });

    // Individual checkbox functionality
    registrationCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllCheckbox();
            updateBulkActionsBar();
        });
    });

    // Deselect All functionality
    deselectAllButton.addEventListener('click', function() {
        selectAllCheckbox.checked = false;
        registrationCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateBulkActionsBar();
    });

    // Update Select All checkbox state
    function updateSelectAllCheckbox() {
        const checkedCount = document.querySelectorAll('.registration-checkbox:checked').length;
        const totalCount = registrationCheckboxes.length;
        
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
        const checkedCheckboxes = document.querySelectorAll('.registration-checkbox:checked');
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
        const checkedCheckboxes = document.querySelectorAll('.registration-checkbox:checked');
        if (checkedCheckboxes.length === 0) {
            e.preventDefault();
            alert('Pilih setidaknya satu peserta untuk dihapus.');
            return false;
        }
    });
});
</script>
