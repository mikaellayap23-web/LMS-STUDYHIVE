<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Show the form for creating a new quiz.
     */
    public function create(Lesson $lesson)
    {
        $user = Auth::user();
        $module = $lesson->module;
        $course = $module->course;

        // Only admin or course instructor can create quizzes
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to create quizzes.');
        }

        $nextOrder = $lesson->quizzes()->max('order') + 1;
        $nextQuizNumber = 'Q-' . str_pad($lesson->quizzes()->count() + 1, 2, '0', STR_PAD_LEFT);

        return view('quizzes.create', compact('lesson', 'module', 'course', 'nextOrder', 'nextQuizNumber'));
    }

    /**
     * Store a newly created quiz.
     */
    public function store(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        $module = $lesson->module;
        $course = $module->course;

        // Only admin or course instructor can create quizzes
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to create quizzes.');
        }

        $validated = $request->validate([
            'quiz_number' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        $validated['lesson_id'] = $lesson->id;
        $validated['is_active'] = $request->has('is_active');

        $quiz = Quiz::create($validated);

        return redirect()->route('quizzes.edit', $quiz)
            ->with('success', 'Quiz created successfully. Now add questions.');
    }

    /**
     * Display the specified quiz (for taking).
     */
    public function show(Quiz $quiz)
    {
        $user = Auth::user();
        $lesson = $quiz->lesson;
        $module = $lesson->module;
        $course = $module->course;

        // Check access for students
        if ($user->isStudent() && (!$course->is_active || !$module->is_active || !$lesson->is_active || !$quiz->is_active)) {
            return redirect()->route('courses.index')
                ->with('error', 'This quiz is not available.');
        }

        // Check access for teachers
        if ($user->isTeacher() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.index')
                ->with('error', 'You do not have access to this quiz.');
        }

        $quiz->load('questions');

        // Get user's attempts
        $attempts = $quiz->attempts()->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('quizzes.show', compact('quiz', 'lesson', 'module', 'course', 'attempts'));
    }

    /**
     * Show the form for editing the specified quiz.
     */
    public function edit(Quiz $quiz)
    {
        $user = Auth::user();
        $lesson = $quiz->lesson;
        $module = $lesson->module;
        $course = $module->course;

        // Only admin or course instructor can edit quizzes
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to edit this quiz.');
        }

        $quiz->load('questions');

        return view('quizzes.edit', compact('quiz', 'lesson', 'module', 'course'));
    }

    /**
     * Update the specified quiz.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $user = Auth::user();
        $lesson = $quiz->lesson;
        $module = $lesson->module;
        $course = $module->course;

        // Only admin or course instructor can update quizzes
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to update this quiz.');
        }

        $validated = $request->validate([
            'quiz_number' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $quiz->update($validated);

        return redirect()->route('quizzes.edit', $quiz)
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified quiz.
     */
    public function destroy(Quiz $quiz)
    {
        $user = Auth::user();
        $lesson = $quiz->lesson;
        $module = $lesson->module;
        $course = $module->course;

        // Only admin or course instructor can delete quizzes
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to delete this quiz.');
        }

        $quiz->delete();

        return redirect()->route('courses.modules.show', [$course, $module])
            ->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Start a quiz attempt.
     */
    public function start(Quiz $quiz)
    {
        $user = Auth::user();
        $lesson = $quiz->lesson;
        $module = $lesson->module;
        $course = $module->course;

        // Check if quiz is available
        if (!$quiz->is_active || !$lesson->is_active || !$module->is_active || !$course->is_active) {
            return redirect()->route('quizzes.show', $quiz)
                ->with('error', 'This quiz is not available.');
        }

        // Create new attempt
        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'started_at' => now(),
            'total_points' => $quiz->total_points,
        ]);

        return redirect()->route('quizzes.take', ['quiz' => $quiz, 'attempt' => $attempt]);
    }

    /**
     * Take the quiz.
     */
    public function take(Quiz $quiz, QuizAttempt $attempt)
    {
        $user = Auth::user();

        // Check if this is the user's attempt
        if ($attempt->user_id !== $user->id) {
            return redirect()->route('quizzes.show', $quiz)
                ->with('error', 'Invalid attempt.');
        }

        // Check if already completed
        if ($attempt->completed_at) {
            return redirect()->route('quizzes.result', ['quiz' => $quiz, 'attempt' => $attempt]);
        }

        $quiz->load('questions');
        $lesson = $quiz->lesson;
        $module = $lesson->module;
        $course = $module->course;

        return view('quizzes.take', compact('quiz', 'attempt', 'lesson', 'module', 'course'));
    }

    /**
     * Submit quiz answers.
     */
    public function submit(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        $user = Auth::user();

        // Check if this is the user's attempt
        if ($attempt->user_id !== $user->id) {
            return redirect()->route('quizzes.show', $quiz)
                ->with('error', 'Invalid attempt.');
        }

        // Check if already completed
        if ($attempt->completed_at) {
            return redirect()->route('quizzes.result', ['quiz' => $quiz, 'attempt' => $attempt]);
        }

        $quiz->load('questions');

        $answers = $request->input('answers', []);
        $score = 0;
        $totalPoints = 0;

        foreach ($quiz->questions as $question) {
            $totalPoints += $question->points;
            $userAnswer = $answers[$question->id] ?? '';

            if ($question->isCorrect($userAnswer)) {
                $score += $question->points;
            }
        }

        $percentage = $totalPoints > 0 ? ($score / $totalPoints) * 100 : 0;
        $passed = $percentage >= $quiz->passing_score;

        $attempt->update([
            'answers' => $answers,
            'score' => $score,
            'total_points' => $totalPoints,
            'percentage' => $percentage,
            'passed' => $passed,
            'completed_at' => now(),
        ]);

        return redirect()->route('quizzes.result', ['quiz' => $quiz, 'attempt' => $attempt]);
    }

    /**
     * Show quiz result.
     */
    public function result(Quiz $quiz, QuizAttempt $attempt)
    {
        $user = Auth::user();
        $lesson = $quiz->lesson;
        $module = $lesson->module;
        $course = $module->course;

        // Check if this is the user's attempt or if admin/teacher
        if ($attempt->user_id !== $user->id && !$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('quizzes.show', $quiz)
                ->with('error', 'Invalid attempt.');
        }

        $quiz->load('questions');

        return view('quizzes.result', compact('quiz', 'attempt', 'lesson', 'module', 'course'));
    }

    /**
     * Add a question to the quiz.
     */
    public function addQuestion(Request $request, Quiz $quiz)
    {
        $user = Auth::user();
        $lesson = $quiz->lesson;
        $module = $lesson->module;
        $course = $module->course;

        // Only admin or course instructor can add questions
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('quizzes.edit', $quiz)
                ->with('error', 'You do not have permission to add questions.');
        }

        $validated = $request->validate([
            'question_type' => 'required|in:multiple_choice,true_false,short_answer',
            'question' => 'required|string',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string',
            'correct_answer' => 'required|string',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1',
        ]);

        $validated['quiz_id'] = $quiz->id;
        $validated['order'] = $quiz->questions()->max('order') + 1;

        // Filter empty options
        if (isset($validated['options'])) {
            $validated['options'] = array_values(array_filter($validated['options']));
        }

        $quiz->questions()->create($validated);

        return redirect()->route('quizzes.edit', $quiz)
            ->with('success', 'Question added successfully.');
    }

    /**
     * Remove a question from the quiz.
     */
    public function removeQuestion(Quiz $quiz, $questionId)
    {
        $user = Auth::user();
        $lesson = $quiz->lesson;
        $module = $lesson->module;
        $course = $module->course;

        // Only admin or course instructor can remove questions
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('quizzes.edit', $quiz)
                ->with('error', 'You do not have permission to remove questions.');
        }

        $quiz->questions()->where('id', $questionId)->delete();

        return redirect()->route('quizzes.edit', $quiz)
            ->with('success', 'Question removed successfully.');
    }
}
