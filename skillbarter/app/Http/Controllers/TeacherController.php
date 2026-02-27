<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // List all teachers with basic filters
   public function index()
    {
        $query = User::where('role', 'teacher')
            ->where('is_teacher_approved', true)
            ->where('is_active', true);

        // apply name/skill search when a query parameter is provided
        if ($search = request('q')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('userSkills.skill', function($q2) use ($search) {
                      $q2->where('title', 'like', "%{$search}%");
                  });
            });
        }

        $teachers = $query->with('userSkills.skill')->paginate(10);
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
