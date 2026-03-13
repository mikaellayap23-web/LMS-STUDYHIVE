<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard with stats.
     */
    public function admin()
    {
        $stats = $this->getAdminStats();
        $announcements = $this->getDashboardAnnouncements();
        return view('admin.admin-dashboard', ['stats' => $stats, 'announcements' => $announcements]);
    }

    /**
     * Display teacher dashboard with stats.
     */
    public function teacher()
    {
        $stats = $this->getTeacherStats();
        $announcements = $this->getDashboardAnnouncements();
        return view('teacher.teacher-dashboard', ['stats' => $stats, 'announcements' => $announcements]);
    }

    /**
     * Display student dashboard with stats.
     */
    public function student()
    {
        $stats = $this->getStudentStats();
        $announcements = $this->getDashboardAnnouncements();
        return view('student.student-dashboard', ['stats' => $stats, 'announcements' => $announcements]);
    }

    /**
     * Get admin stats as JSON.
     */
    public function adminStats(): JsonResponse
    {
        return response()->json($this->getAdminStats());
    }

    /**
     * Get teacher stats as JSON.
     */
    public function teacherStats(): JsonResponse
    {
        return response()->json($this->getTeacherStats());
    }

    /**
     * Get student stats as JSON.
     */
    public function studentStats(): JsonResponse
    {
        return response()->json($this->getStudentStats());
    }

    /**
     * Calculate admin statistics.
     */
    private function getAdminStats(): array
    {
        return [
            'total_users' => User::count(),
            'pending_approvals' => User::where('status', 'pending')->count(),
            'active_courses' => 0, // Will be implemented when courses are added
            'total_enrollments' => 0, // Will be implemented when enrollments are added
        ];
    }

    /**
     * Calculate teacher statistics.
     */
    private function getTeacherStats(): array
    {
        $teacherId = auth()->id();
        
        return [
            'total_students' => User::where('role', 'student')->count(),
            'my_modules' => 0, // Will be implemented when modules are added
            'active_assessments' => 0, // Will be implemented when assessments are added
            'average_score' => 0, // Will be implemented when grades are added
        ];
    }

    /**
     * Calculate student statistics.
     */
    private function getStudentStats(): array
    {
        return [
            'my_modules' => 0, // Will be implemented when enrollments are added
            'completed' => 0, // Will be implemented when completions are tracked
            'in_progress' => 0, // Will be implemented when progress is tracked
            'average_grade' => 0, // Will be implemented when grades are added
        ];
    }

    /**
     * Get announcements for dashboard display.
     */
    private function getDashboardAnnouncements(): array
    {
        $user = auth()->user();
        
        return Announcement::query()
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
            ->limit(5)
            ->get()
            ->toArray();
    }
}
