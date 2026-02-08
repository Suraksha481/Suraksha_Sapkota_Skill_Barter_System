<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherProfile;
use App\Models\StudentProfile;

class RoleController extends Controller
{
    public function show()
    {
        return view('choose-role');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|array',
        ]);

        $user = auth()->user();

        if (in_array('teacher', $request->role)) {
            TeacherProfile::firstOrCreate([
                'user_id' => $user->id,
            ]);
        }

        if (in_array('student', $request->role)) {
            StudentProfile::firstOrCreate([
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('dashboard');
    }
}
