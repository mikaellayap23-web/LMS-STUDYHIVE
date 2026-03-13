<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AnnouncementController extends Controller
{
    /**
     * Display announcements for the current user.
     */
    public function index(): View
    {
        $user = auth()->user();
        
        $announcements = Announcement::query()
            ->where('is_active', true)
            ->where(function ($query) use ($user) {
                $query->where('target_audience', 'all')
                      ->orWhere('target_audience', $user->role);
            })
            ->where(function ($query) {
                $query->whereNull('published_at')
                      ->orWhere('published_at', '<=', now());
            })
            ->with('creator')
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new announcement.
     */
    public function create(): View
    {
        return view('announcements.create');
    }

    /**
     * Store a newly created announcement in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|in:all,student,teacher,admin',
            'published_at' => 'nullable|date',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_active'] = true;

        Announcement::create($validated);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    /**
     * Display the specified announcement.
     */
    public function show(Announcement $announcement): View
    {
        return view('announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified announcement.
     */
    public function edit(Announcement $announcement): View
    {
        return view('announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified announcement in storage.
     */
    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|in:all,student,teacher,admin',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $announcement->update($validated);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    /**
     * Remove the specified announcement from storage.
     */
    public function destroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
