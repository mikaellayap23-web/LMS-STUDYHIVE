<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    /**
     * Show the form for creating a new module.
     */
    public function create(Course $course)
    {
        $user = Auth::user();

        // Only admin or course instructor can create modules
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You do not have permission to create modules for this course.');
        }

        $nextOrder = $course->modules()->max('order') + 1;

        return view('modules.create', compact('course', 'nextOrder'));
    }

    /**
     * Store a newly created module.
     */
    public function store(Request $request, Course $course)
    {
        $user = Auth::user();

        // Only admin or course instructor can create modules
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You do not have permission to create modules for this course.');
        }

        $validated = $request->validate([
            'module_title' => 'required|string|max:255',
            'module_number' => 'required|string|max:50',
            'description' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        $validated['course_id'] = $course->id;
        $validated['is_active'] = $request->has('is_active');

        Module::create($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Module created successfully.');
    }

    /**
     * Display the specified module.
     */
    public function show(Course $course, Module $module)
    {
        $user = Auth::user();

        // Check access for students (only active modules)
        if ($user->isStudent() && (!$course->is_active || !$module->is_active)) {
            return redirect()->route('courses.index')
                ->with('error', 'This module is not available.');
        }

        // Check access for teachers (only their courses)
        if ($user->isTeacher() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.index')
                ->with('error', 'You do not have access to this module.');
        }

        $module->load(['lessons' => function ($query) use ($user) {
            if ($user->isStudent()) {
                $query->where('is_active', true);
            }
            $query->orderBy('order')->with(['topics', 'quizzes']);
        }]);

        return view('modules.show', compact('course', 'module'));
    }

    /**
     * Show the form for editing the specified module.
     */
    public function edit(Course $course, Module $module)
    {
        $user = Auth::user();

        // Only admin or course instructor can edit modules
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You do not have permission to edit this module.');
        }

        return view('modules.edit', compact('course', 'module'));
    }

    /**
     * Update the specified module.
     */
    public function update(Request $request, Course $course, Module $module)
    {
        $user = Auth::user();

        // Only admin or course instructor can update modules
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You do not have permission to update this module.');
        }

        $validated = $request->validate([
            'module_title' => 'required|string|max:255',
            'module_number' => 'required|string|max:50',
            'description' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $module->update($validated);

        return redirect()->route('courses.modules.show', [$course, $module])
            ->with('success', 'Module updated successfully.');
    }

    /**
     * Remove the specified module.
     */
    public function destroy(Course $course, Module $module)
    {
        $user = Auth::user();

        // Only admin or course instructor can delete modules
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You do not have permission to delete this module.');
        }

        $module->delete();

        return redirect()->route('courses.show', $course)
            ->with('success', 'Module deleted successfully.');
    }
}
