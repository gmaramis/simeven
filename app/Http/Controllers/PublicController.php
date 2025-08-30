<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the home page with published events
     */
    public function home()
    {
        $events = Event::where('status', 'published')
            ->where('start_date', '>', now())
            ->orderBy('start_date')
            ->get();

        return view('public.home', compact('events'));
    }

    /**
     * Display all published events
     */
    public function events()
    {
        $events = Event::where('status', 'published')
            ->orderBy('start_date')
            ->paginate(12);

        return view('public.events', compact('events'));
    }

    /**
     * Display specific event details
     */
    public function showEvent($id)
    {
        $event = Event::findOrFail($id);
        
        if (!$event->isPublished()) {
            abort(404);
        }

        return view('public.event-detail', compact('event'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        return view('public.contact');
    }
}
