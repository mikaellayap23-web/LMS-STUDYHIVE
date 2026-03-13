<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    /**
     * Show the form for creating a new topic.
     */
    public function create(Lesson $lesson)
    {
        $user = Auth::user();
        $module = $lesson->module;
        $course = $module->course;

        // Only admin or course instructor can create topics
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to create topics.');
        }

        $nextOrder = $lesson->topics()->max('order') + 1;
        $nextTopicNumber = 'T-' . str_pad($lesson->topics()->count() + 1, 2, '0', STR_PAD_LEFT);

        return view('topics.create', compact('lesson', 'module', 'course', 'nextOrder', 'nextTopicNumber'));
    }

    /**
     * Store a newly created topic.
     */
    public function store(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        $module = $lesson->module;
        $course = $module->course;

        // Only admin or course instructor can create topics
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to create topics.');
        }

        $validated = $request->validate([
            'topic_number' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        $validated['lesson_id'] = $lesson->id;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('topics', $filename, 'public');
            $validated['file_path'] = $path;
            $validated['original_filename'] = $file->getClientOriginalName();
        }

        Topic::create($validated);

        return redirect()->route('courses.modules.show', [$course, $module])
            ->with('success', 'Topic created successfully.');
    }

    /**
     * Display the specified topic.
     */
    public function show(Topic $topic)
    {
        $user = Auth::user();
        $lesson = $topic->lesson;
        $module = $lesson->module;
        $course = $module->course;

        // Check access for students
        if ($user->isStudent() && (!$course->is_active || !$module->is_active || !$lesson->is_active)) {
            return redirect()->route('courses.index')
                ->with('error', 'This content is not available.');
        }

        // Check access for teachers
        if ($user->isTeacher() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.index')
                ->with('error', 'You do not have access to this content.');
        }

        $previousTopic = $topic->getPreviousTopic();
        $nextTopic = $topic->getNextTopic();

        return view('topics.show', compact('topic', 'lesson', 'module', 'course', 'previousTopic', 'nextTopic'));
    }

    /**
     * Show the form for editing the specified topic.
     */
    public function edit(Topic $topic)
    {
        $user = Auth::user();
        $lesson = $topic->lesson;
        $module = $lesson->module;
        $course = $module->course;

        // Only admin or course instructor can edit topics
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to edit this topic.');
        }

        return view('topics.edit', compact('topic', 'lesson', 'module', 'course'));
    }

    /**
     * Update the specified topic.
     */
    public function update(Request $request, Topic $topic)
    {
        $user = Auth::user();
        $lesson = $topic->lesson;
        $module = $lesson->module;
        $course = $module->course;

        // Only admin or course instructor can update topics
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to update this topic.');
        }

        $validated = $request->validate([
            'topic_number' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($topic->file_path) {
                Storage::disk('public')->delete($topic->file_path);
            }

            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('topics', $filename, 'public');
            $validated['file_path'] = $path;
            $validated['original_filename'] = $file->getClientOriginalName();
        }

        $topic->update($validated);

        return redirect()->route('topics.show', $topic)
            ->with('success', 'Topic updated successfully.');
    }

    /**
     * Remove the specified topic.
     */
    public function destroy(Topic $topic)
    {
        $user = Auth::user();
        $lesson = $topic->lesson;
        $module = $lesson->module;
        $course = $module->course;

        // Only admin or course instructor can delete topics
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to delete this topic.');
        }

        // Delete file if exists
        if ($topic->file_path) {
            Storage::disk('public')->delete($topic->file_path);
        }

        $topic->delete();

        return redirect()->route('courses.modules.show', [$course, $module])
            ->with('success', 'Topic deleted successfully.');
    }

    /**
     * Download the attached file.
     */
    public function download(Topic $topic)
    {
        if (!$topic->file_path || !Storage::disk('public')->exists($topic->file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download(
            $topic->file_path,
            $topic->original_filename ?? basename($topic->file_path)
        );
    }
}
