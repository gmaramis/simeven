<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'total_seats' => 'required|integer|min:1',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'status' => 'required|in:draft,published',
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // 2MB
                'min:50', // 50KB minimum
                'dimensions:min_width=600,min_height=400' // Minimum dimensions
            ]
        ], [
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'image.min' => 'Ukuran gambar minimal 50KB.',
            'image.dimensions' => 'Ukuran gambar minimal 600x400 pixel. Direkomendasikan 1200x800 pixel.',
            'image.mimes' => 'Format gambar harus JPG, PNG, atau GIF.',
            'image.image' => 'File harus berupa gambar.',
            'start_date.after' => 'Tanggal mulai harus setelah hari ini.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'total_seats.min' => 'Kapasitas minimal 1 peserta.',
            'status.in' => 'Status harus Draft atau Published.'
        ]);

        $data = $request->all();
        $data['available_seats'] = $request->total_seats;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($data);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'total_seats' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'status' => 'required|in:draft,published',
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // 2MB
                'min:50', // 50KB minimum
                'dimensions:min_width=600,min_height=400' // Minimum dimensions
            ]
        ], [
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'image.min' => 'Ukuran gambar minimal 50KB.',
            'image.dimensions' => 'Ukuran gambar minimal 600x400 pixel. Direkomendasikan 1200x800 pixel.',
            'image.mimes' => 'Format gambar harus JPG, PNG, atau GIF.',
            'image.image' => 'File harus berupa gambar.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'total_seats.min' => 'Kapasitas minimal 1 peserta.',
            'status.in' => 'Status harus Draft atau Published.'
        ]);

        $data = $request->all();

        // Update available seats if total seats changed
        if ($request->total_seats != $event->total_seats) {
            $registeredCount = $event->registrations()->count();
            $data['available_seats'] = $request->total_seats - $registeredCount;
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus!');
    }

    /**
     * Publish event
     */
    public function publish(string $id)
    {
        $event = Event::findOrFail($id);
        $event->update(['status' => 'published']);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dipublish!');
    }

    /**
     * Unpublish event
     */
    public function unpublish(string $id)
    {
        $event = Event::findOrFail($id);
        $event->update(['status' => 'draft']);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diunpublish!');
    }
}
