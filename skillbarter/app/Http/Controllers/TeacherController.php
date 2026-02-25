<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // List all teachers with basic filters
   public function index()
    {
        $teachers = User::where('role', 'teacher')
            ->where('is_teacher_approved', true)
            ->where('is_active', true)
            ->paginate(10);

        return view('teachers.index', compact('teachers'));
    }

    public function show(User $teacher)
    {
        if (! $teacher->isTeacher()) {
            abort(404);
        }

        $teacher->load(['userSkills.skill']);

        return view('teacher.show', compact('teacher'));
    }
}
