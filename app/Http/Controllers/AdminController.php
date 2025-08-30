<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $totalEvents = Event::count();
        $publishedEvents = Event::where('status', 'published')->count();
        $draftEvents = Event::where('status', 'draft')->count();
        $totalRegistrations = Registration::count();
        $confirmedRegistrations = Registration::where('status', 'confirmed')->count();
        $pendingRegistrations = Registration::where('status', 'pending')->count();
        $totalUsers = User::count();

        $recentEvents = Event::latest()->take(5)->get();
        $recentRegistrations = Registration::with('event')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalEvents',
            'publishedEvents',
            'draftEvents',
            'totalRegistrations',
            'confirmedRegistrations',
            'pendingRegistrations',
            'totalUsers',
            'recentEvents',
            'recentRegistrations'
        ));
    }

    /**
     * Display all events for admin
     */
    public function events()
    {
        $events = Event::withCount('registrations')->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Display all registrations for admin
     */
    public function registrations()
    {
        $registrations = Registration::with('event')->latest()->paginate(10);
        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Display participants for a specific event
     */
    public function eventParticipants($eventId)
    {
        $event = Event::findOrFail($eventId);
        $participants = Registration::where('event_id', $eventId)
            ->where('status', 'confirmed')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.events.participants', compact('event', 'participants'));
    }

    /**
     * Print participants list for a specific event
     */
    public function printParticipants($eventId)
    {
        $event = Event::findOrFail($eventId);
        $participants = Registration::where('event_id', $eventId)
            ->where('status', 'confirmed')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.events.print-participants', compact('event', 'participants'));
    }
}
