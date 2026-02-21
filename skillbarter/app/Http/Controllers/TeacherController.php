<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // List all teachers with basic filters
    public function index(Request $request)
    {
        $query = User::query()->whereJsonContains('role', 'teacher');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $teachers = $query->with(['userSkills.skill'])->paginate(12);

        return view('teachers.index', compact('teachers'));
    }

    public function show(User $teacher)
    {
        if (! $teacher->isTeacher()) {
            abort(404);
        }

        $teacher->load(['userSkills.skill']);

        return view('teachers.show', compact('teacher'));
    }
}
