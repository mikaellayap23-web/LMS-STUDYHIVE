<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
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
            $query->orderBy('order')->with(['topics', 'quizzes.attempts' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }]);
        }]);

        // Calculate progress and unlock status for each lesson
        $lessonProgress = $this->calculateLessonProgress($module, $user);
        $totalLessons = $module->lessons->count();
        $completedLessons = collect($lessonProgress)->where('completed', true)->count();
        $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        // Get previous/next modules
        $allModules = $course->modules()->ordered()->get();
        $currentIndex = $allModules->search(fn($m) => $m->id === $module->id);
        $previousModule = $currentIndex > 0 ? $allModules[$currentIndex - 1] : null;
        $nextModule = $currentIndex < $allModules->count() - 1 ? $allModules[$currentIndex + 1] : null;

        return view('modules.show', compact(
            'course',
            'module',
            'lessonProgress',
            'totalLessons',
            'completedLessons',
            'progressPercentage',
            'previousModule',
            'nextModule'
        ));
    }

    /**
     * Calculate progress and unlock status for each lesson in a module.
     */
    private function calculateLessonProgress(Module $module, $user): array
    {
        $progress = [];
        $previousCompleted = true; // First lesson is always unlocked

        foreach ($module->lessons as $lesson) {
            // Check if the lesson's required quizzes have been passed
            $lessonCompleted = $this->isLessonCompleted($lesson, $user);

            $progress[$lesson->id] = [
                'unlocked' => $previousCompleted,
                'completed' => $lessonCompleted,
                'quiz_passed' => $lessonCompleted,
            ];

            // For next lesson to be unlocked, this lesson must be completed
            $previousCompleted = $lessonCompleted;
        }

        return $progress;
    }

    /**
     * Check if a lesson is completed (all required quizzes passed).
     */
    private function isLessonCompleted(Lesson $lesson, $user): bool
    {
        // If no quizzes, consider lesson completed when accessed (for now, always true)
        if ($lesson->quizzes->isEmpty()) {
            return true;
        }

        // Check if any quiz in this lesson has been passed
        foreach ($lesson->quizzes as $quiz) {
            $passedAttempt = $quiz->attempts->where('passed', true)->first();
            if ($passedAttempt) {
                return true;
            }
        }

        return false;
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
