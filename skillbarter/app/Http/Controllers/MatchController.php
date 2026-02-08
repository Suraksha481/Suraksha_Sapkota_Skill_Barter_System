<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;

class MatchController extends Controller
{
    // Show all skills
    public function index()
    {
        $skills = Skill::all(); // fetch all skills from database
        return view('find-skill', compact('skills'));
    }

    // Show skill detail
    public function show(Skill $skill)
    {
        return view('skill-detail', compact('skill'));
    }
}
