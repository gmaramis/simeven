<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckinController extends Controller
{
    /**
     * Display check-in page for events
     */
    public function index()
    {
        $events = Event::where('status', 'published')
            ->where('start_date', '>=', now()->subDays(1))
            ->orderBy('start_date', 'asc')
            ->get();

        return view('admin.checkin.index', compact('events'));
    }

    /**
     * Display check-in interface for specific event
     */
    public function event($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        // Get confirmed registrations
        $registrations = Registration::where('event_id', $eventId)
            ->where('status', 'confirmed')
            ->orderBy('created_at', 'asc')
            ->get();

        $stats = [
            'total' => $registrations->count(),
            'checked_in' => $registrations->where('checked_in_at', '!=', null)->count(),
            'not_checked_in' => $registrations->where('checked_in_at', null)->count(),
        ];

        return view('admin.checkin.event', compact('event', 'registrations', 'stats'));
    }

    /**
     * Search participant by phone number
     */
    public function search(Request $request, $eventId)
    {
        $request->validate([
            'phone' => 'required|string|max:20'
        ]);

        $event = Event::findOrFail($eventId);
        
        $registration = Registration::where('event_id', $eventId)
            ->where('phone', $request->phone)
            ->where('status', 'confirmed')
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta tidak ditemukan atau belum terdaftar untuk event ini.'
            ]);
        }

        return response()->json([
            'success' => true,
            'participant' => [
                'id' => $registration->id,
                'name' => $registration->name,
                'phone' => $registration->phone,
                'email' => $registration->email,
                'church' => $registration->church,
                'ministry' => $registration->ministry,
                'checked_in_at' => $registration->checked_in_at,
                'checked_in_by' => $registration->checked_in_by,
                'is_checked_in' => $registration->isCheckedIn()
            ]
        ]);
    }

    /**
     * Check-in participant
     */
    public function checkIn(Request $request, $eventId)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id'
        ]);

        $registration = Registration::where('event_id', $eventId)
            ->where('id', $request->registration_id)
            ->where('status', 'confirmed')
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran tidak ditemukan.'
            ]);
        }

        if ($registration->isCheckedIn()) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta sudah check-in sebelumnya.'
            ]);
        }

        $adminName = Auth::user()->name;
        $registration->checkIn($adminName);

        // Get updated stats
        $registrations = Registration::where('event_id', $eventId)
            ->where('status', 'confirmed')
            ->get();

        $stats = [
            'total' => $registrations->count(),
            'checked_in' => $registrations->where('checked_in_at', '!=', null)->count(),
            'not_checked_in' => $registrations->where('checked_in_at', null)->count(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil!',
            'participant' => [
                'name' => $registration->name,
                'checked_in_at' => $registration->checked_in_at->format('H:i'),
                'checked_in_by' => $registration->checked_in_by
            ],
            'stats' => $stats
        ]);
    }

    /**
     * Get real-time stats for event
     */
    public function stats($eventId)
    {
        $registrations = Registration::where('event_id', $eventId)
            ->where('status', 'confirmed')
            ->get();

        $stats = [
            'total' => $registrations->count(),
            'checked_in' => $registrations->where('checked_in_at', '!=', null)->count(),
            'not_checked_in' => $registrations->where('checked_in_at', null)->count(),
        ];

        return response()->json($stats);
    }
}
