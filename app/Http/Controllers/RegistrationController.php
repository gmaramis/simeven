<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = Registration::with('event')->latest()->paginate(20);
        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::where('status', 'published')->get();
        return view('admin.registrations.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^08[0-9]{8,11}$/',
            'notes' => 'nullable|string'
        ], [
            'phone.regex' => 'Format nomor WhatsApp tidak valid. Gunakan format: 08xxxxxxxxxx'
        ]);

        $event = Event::findOrFail($request->event_id);

        // Check if event is published
        if (!$event->isPublished()) {
            return back()->withErrors(['event_id' => 'Event tidak tersedia untuk pendaftaran.']);
        }

        // Check if event is full
        if ($event->isFull()) {
            return back()->withErrors(['event_id' => 'Event sudah penuh.']);
        }

        // Check if user already registered
        $existingRegistration = Registration::where('event_id', $request->event_id)
            ->where('phone', $request->phone)
            ->first();

        if ($existingRegistration) {
            return back()->withErrors(['phone' => 'Nomor telepon ini sudah terdaftar untuk event ini.']);
        }

        // Create registration
        $registration = Registration::create($request->all());

        // Update available seats
        $event->decrement('available_seats');

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Pendaftaran berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $registration = Registration::with('event')->findOrFail($id);
        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $registration = Registration::findOrFail($id);
        $events = Event::where('status', 'published')->get();
        return view('admin.registrations.edit', compact('registration', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $registration = Registration::findOrFail($id);
        $oldEventId = $registration->event_id;

        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^08[0-9]{8,11}$/',
            'notes' => 'nullable|string'
        ], [
            'phone.regex' => 'Format nomor WhatsApp tidak valid. Gunakan format: 08xxxxxxxxxx'
        ]);

        // Check if phone already exists for different registration in same event
        $existingRegistration = Registration::where('event_id', $request->event_id)
            ->where('phone', $request->phone)
            ->where('id', '!=', $id)
            ->first();

        if ($existingRegistration) {
            return back()->withErrors(['phone' => 'Nomor telepon ini sudah terdaftar untuk event ini.']);
        }

        $registration->update($request->all());

        // Handle seat management if event changed
        if ($oldEventId != $request->event_id) {
            // Increment seats for old event
            Event::find($oldEventId)->increment('available_seats');
            
            // Decrement seats for new event
            Event::find($request->event_id)->decrement('available_seats');
        }

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Pendaftaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registration = Registration::findOrFail($id);
        $eventId = $registration->event_id;

        $registration->delete();

        // Increment available seats
        Event::find($eventId)->increment('available_seats');

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Pendaftaran berhasil dihapus!');
    }

    /**
     * Confirm registration
     */
    public function confirm(string $id)
    {
        $registration = Registration::findOrFail($id);
        $registration->update(['status' => 'confirmed']);

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Pendaftaran berhasil dikonfirmasi!');
    }

    /**
     * Cancel registration
     */
    public function cancel(string $id)
    {
        $registration = Registration::findOrFail($id);
        $registration->update(['status' => 'cancelled']);

        // Increment available seats if registration was confirmed
        if ($registration->status === 'confirmed') {
            $registration->event->increment('available_seats');
        }

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Pendaftaran berhasil dibatalkan!');
    }

    /**
     * Public registration form
     */
    public function register($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        if (!$event->isPublished()) {
            abort(404);
        }

        return view('events.register', compact('event'));
    }

    /**
     * Store public registration
     */
    public function storePublic(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^08[0-9]{8,11}$/',
            'church' => 'required|string|max:255',
            'ministry' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor HP/WA wajib diisi.',
            'phone.regex' => 'Format nomor WhatsApp tidak valid. Gunakan format: 08xxxxxxxxxx',
            'church.required' => 'Asal gereja wajib diisi.',
            'ministry.required' => 'Bidang pelayanan wajib dipilih.',
            'phone.max' => 'Nomor telepon terlalu panjang.'
        ]);

        // Check if event is published
        if (!$event->isPublished()) {
            return back()->withErrors(['error' => 'Event tidak tersedia untuk pendaftaran.']);
        }

        // Check if event is full
        if ($event->isFull()) {
            return back()->withErrors(['error' => 'Event sudah penuh.']);
        }

        // Check if user already registered (by phone number)
        $existingRegistration = Registration::where('event_id', $eventId)
            ->where('phone', $request->phone)
            ->first();

        if ($existingRegistration) {
            return back()->withErrors(['phone' => 'Nomor HP/WA ini sudah terdaftar untuk event ini.']);
        }

        // Create registration
        $registration = Registration::create([
            'event_id' => $eventId,
            'name' => $request->name,
            'phone' => $request->phone,
            'church' => $request->church,
            'ministry' => $request->ministry,
            'notes' => $request->notes,
            'status' => 'confirmed' // Auto confirm for public registrations
        ]);

        // Update available seats
        $event->decrement('available_seats');

        // Auto send WhatsApp confirmation if enabled
        if (config('services.fonnte.enabled', false)) {
            try {
                $whatsappService = app(\App\Services\WhatsAppService::class);
                
                // Create WhatsApp message record
                $whatsappMessage = \App\Models\WhatsAppMessage::create([
                    'registration_id' => $registration->id,
                    'message_type' => 'confirmation',
                    'phone_number' => $registration->phone,
                    'message_content' => '', // Will be set by service
                    'status' => 'pending'
                ]);

                // Send the message
                $whatsappService->sendConfirmationMessage($whatsappMessage);
                
                Log::info('Auto WhatsApp confirmation sent', [
                    'registration_id' => $registration->id,
                    'phone' => $registration->phone
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send auto WhatsApp confirmation', [
                    'registration_id' => $registration->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return redirect()->route('registration.success', $registration->id);
    }

    /**
     * Show registration success page
     */
    public function success($registrationId)
    {
        try {
            $registration = Registration::with('event')->findOrFail($registrationId);
            
            // Check if event exists
            if (!$registration->event) {
                abort(404, 'Event tidak ditemukan');
            }
            
            $event = $registration->event;
            
            return view('public.registration-success', compact('registration', 'event'));
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Registration success page error: ' . $e->getMessage(), [
                'registration_id' => $registrationId,
                'trace' => $e->getTraceAsString()
            ]);
            
            abort(404, 'Pendaftaran tidak ditemukan');
        }
    }

    /**
     * Bulk delete registrations
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected_registrations' => 'required|string'
        ]);

        try {
            $selectedIds = json_decode($request->selected_registrations, true);
            
            if (!is_array($selectedIds) || empty($selectedIds)) {
                return back()->withErrors(['error' => 'Tidak ada peserta yang dipilih untuk dihapus.']);
            }

            $registrations = Registration::whereIn('id', $selectedIds)->get();
            $deletedCount = 0;
            $eventsToUpdate = [];

            foreach ($registrations as $registration) {
                // Store event ID for seat update
                $eventsToUpdate[$registration->event_id] = ($eventsToUpdate[$registration->event_id] ?? 0) + 1;
                
                // Delete related WhatsApp messages first
                $registration->whatsappMessages()->delete();
                
                // Delete the registration
                $registration->delete();
                $deletedCount++;
            }

            // Update available seats for affected events
            foreach ($eventsToUpdate as $eventId => $count) {
                Event::find($eventId)->increment('available_seats', $count);
            }

            $message = $deletedCount === 1 
                ? '1 peserta berhasil dihapus!' 
                : "{$deletedCount} peserta berhasil dihapus!";

            return redirect()->route('admin.registrations.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Bulk delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus peserta. Silakan coba lagi.']);
        }
    }
}
