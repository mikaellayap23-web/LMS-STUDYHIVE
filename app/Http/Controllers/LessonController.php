<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    /**
     * Show the form for creating a new lesson.
     */
    public function create(Course $course, Module $module)
    {
        $user = Auth::user();

        // Only admin or course instructor can create lessons
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to create content for this module.');
        }

        $nextOrder = $module->lessons()->max('order') + 1;
        $nextLessonNumber = 'L-' . str_pad($module->lessons()->count() + 1, 2, '0', STR_PAD_LEFT);

        return view('lessons.create', compact('course', 'module', 'nextOrder', 'nextLessonNumber'));
    }

    /**
     * Store a newly created lesson.
     */
    public function store(Request $request, Course $course, Module $module)
    {
        $user = Auth::user();

        // Only admin or course instructor can create lessons
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to create content for this module.');
        }

        $validated = $request->validate([
            'lesson_number' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        $validated['module_id'] = $module->id;
        $validated['is_active'] = $request->has('is_active');

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('lessons', $filename, 'public');
            $validated['file_path'] = $path;
            $validated['original_filename'] = $file->getClientOriginalName();
        }

        Lesson::create($validated);

        return redirect()->route('courses.modules.show', [$course, $module])
            ->with('success', 'Lesson created successfully.');
    }

    /**
     * Show the form for editing the specified lesson.
     */
    public function edit(Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();

        // Only admin or course instructor can edit lessons
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to edit this content.');
        }

        return view('lessons.edit', compact('course', 'module', 'lesson'));
    }

    /**
     * Update the specified lesson.
     */
    public function update(Request $request, Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();

        // Only admin or course instructor can update lessons
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to update this content.');
        }

        $validated = $request->validate([
            'lesson_number' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($lesson->file_path) {
                Storage::disk('public')->delete($lesson->file_path);
            }

            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('lessons', $filename, 'public');
            $validated['file_path'] = $path;
            $validated['original_filename'] = $file->getClientOriginalName();
        }

        $lesson->update($validated);

        return redirect()->route('courses.modules.show', [$course, $module])
            ->with('success', 'Lesson updated successfully.');
    }

    /**
     * Remove the specified lesson.
     */
    public function destroy(Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();

        // Only admin or course instructor can delete lessons
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to delete this content.');
        }

        // Delete file if exists
        if ($lesson->file_path) {
            Storage::disk('public')->delete($lesson->file_path);
        }

        $lesson->delete();

        return redirect()->route('courses.modules.show', [$course, $module])
            ->with('success', 'Lesson deleted successfully.');
    }

    /**
     * Download the attached file.
     */
    public function download(Course $course, Module $module, Lesson $lesson)
    {
        if (!$lesson->file_path || !Storage::disk('public')->exists($lesson->file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download(
            $lesson->file_path,
            $lesson->original_filename ?? basename($lesson->file_path)
        );
    }
}
