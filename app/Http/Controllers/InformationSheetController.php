<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\InformationSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InformationSheetController extends Controller
{
    /**
     * Show the form for creating a new information sheet.
     */
    public function create(Course $course, Module $module)
    {
        $user = Auth::user();

        // Only admin or course instructor can create sheets
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to create content for this module.');
        }

        $nextOrder = $module->informationSheets()->max('order') + 1;
        $nextSheetNumber = 'IS-' . str_pad($module->informationSheets()->count() + 1, 2, '0', STR_PAD_LEFT);

        return view('information-sheets.create', compact('course', 'module', 'nextOrder', 'nextSheetNumber'));
    }

    /**
     * Store a newly created information sheet.
     */
    public function store(Request $request, Course $course, Module $module)
    {
        $user = Auth::user();

        // Only admin or course instructor can create sheets
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to create content for this module.');
        }

        $validated = $request->validate([
            'sheet_number' => 'required|string|max:50',
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
            $path = $file->storeAs('information-sheets', $filename, 'public');
            $validated['file_path'] = $path;
            $validated['original_filename'] = $file->getClientOriginalName();
        }

        InformationSheet::create($validated);

        return redirect()->route('courses.modules.show', [$course, $module])
            ->with('success', 'Information sheet created successfully.');
    }

    /**
     * Show the form for editing the specified information sheet.
     */
    public function edit(Course $course, Module $module, InformationSheet $sheet)
    {
        $user = Auth::user();

        // Only admin or course instructor can edit sheets
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to edit this content.');
        }

        return view('information-sheets.edit', compact('course', 'module', 'sheet'));
    }

    /**
     * Update the specified information sheet.
     */
    public function update(Request $request, Course $course, Module $module, InformationSheet $sheet)
    {
        $user = Auth::user();

        // Only admin or course instructor can update sheets
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to update this content.');
        }

        $validated = $request->validate([
            'sheet_number' => 'required|string|max:50',
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
            if ($sheet->file_path) {
                Storage::disk('public')->delete($sheet->file_path);
            }

            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('information-sheets', $filename, 'public');
            $validated['file_path'] = $path;
            $validated['original_filename'] = $file->getClientOriginalName();
        }

        $sheet->update($validated);

        return redirect()->route('courses.modules.show', [$course, $module])
            ->with('success', 'Information sheet updated successfully.');
    }

    /**
     * Remove the specified information sheet.
     */
    public function destroy(Course $course, Module $module, InformationSheet $sheet)
    {
        $user = Auth::user();

        // Only admin or course instructor can delete sheets
        if (!$user->isAdmin() && $course->instructor_id !== $user->id) {
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('error', 'You do not have permission to delete this content.');
        }

        // Delete file if exists
        if ($sheet->file_path) {
            Storage::disk('public')->delete($sheet->file_path);
        }

        $sheet->delete();

        return redirect()->route('courses.modules.show', [$course, $module])
            ->with('success', 'Information sheet deleted successfully.');
    }

    /**
     * Download the attached file.
     */
    public function download(Course $course, Module $module, InformationSheet $sheet)
    {
        if (!$sheet->file_path || !Storage::disk('public')->exists($sheet->file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download(
            $sheet->file_path,
            $sheet->original_filename ?? basename($sheet->file_path)
        );
    }
}
