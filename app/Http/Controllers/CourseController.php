<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index()
    {
        $user = Auth::user();

        // Admin sees all courses
        if ($user->isAdmin()) {
            $courses = Course::with('instructor')
                ->withCount('modules')
                ->ordered()
                ->paginate(12);
        }
        // Teacher sees only their assigned courses
        elseif ($user->isTeacher()) {
            $courses = Course::with('instructor')
                ->withCount('modules')
                ->byInstructor($user->id)
                ->ordered()
                ->paginate(12);
        }
        // Student sees only active courses
        else {
            $courses = Course::with('instructor')
                ->withCount('modules')
                ->active()
                ->ordered()
                ->paginate(12);
        }

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $user = Auth::user();

        // Only admin can create courses
        if (!$user->isAdmin()) {
            return redirect()->route('courses.index')
                ->with('error', 'Only administrators can create courses.');
        }

        $instructors = User::where('role', 'teacher')->get();

        return view('courses.create', compact('instructors'));
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Only admin can create courses
        if (!$user->isAdmin()) {
            return redirect()->route('courses.index')
                ->with('error', 'Only administrators can create courses.');
        }

        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50|unique:courses,course_code',
            'description' => 'nullable|string',
            'sector' => 'nullable|string|max:255',
            'instructor_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = Course::max('order') + 1;

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $user = Auth::user();

        // Check access for students (only active courses)
        if ($user->isStudent() && !$course->is_active) {
            return redirect()->route('courses.index')
                ->with('error', 'This course is not available.');
        }

        // Check access for teachers (only their courses)
        if ($user->isTeacher() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.index')
                ->with('error', 'You do not have access to this course.');
        }

        $course->load(['instructor', 'modules' => function ($query) use ($user) {
            if ($user->isStudent()) {
                $query->where('is_active', true);
            }
            $query->orderBy('order')->with('lessons');
        }]);

        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        $user = Auth::user();

        // Only admin or assigned instructor can edit
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.index')
                ->with('error', 'You do not have permission to edit this course.');
        }

        $instructors = User::where('role', 'teacher')->get();

        return view('courses.edit', compact('course', 'instructors'));
    }

    /**
     * Update the specified course.
     */
    public function update(Request $request, Course $course)
    {
        $user = Auth::user();

        // Only admin or assigned instructor can update
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.index')
                ->with('error', 'You do not have permission to update this course.');
        }

        $rules = [
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50|unique:courses,course_code,' . $course->id,
            'description' => 'nullable|string',
            'sector' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];

        // Only admin can change instructor
        if ($user->isAdmin()) {
            $rules['instructor_id'] = 'nullable|exists:users,id';
        }

        $validated = $request->validate($rules);
        $validated['is_active'] = $request->has('is_active');

        $course->update($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course.
     */
    public function destroy(Course $course)
    {
        $user = Auth::user();

        // Only admin can delete courses
        if (!$user->isAdmin()) {
            return redirect()->route('courses.index')
                ->with('error', 'Only administrators can delete courses.');
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
