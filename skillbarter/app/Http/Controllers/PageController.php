<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\User;

class PageController extends Controller
{
    // HOME PAGE
   public function home()
    {
        $data = [
            'totalUsers' => \App\Models\User::count(),
            'totalSkills' => \App\Models\Skill::count(),
            'popularSkills' => \App\Models\Skill::withCount('users')
                ->orderBy('users_count', 'desc')
                ->take(6)
                ->get(),
        ];

        if (auth()->check()) {
            $user = auth()->user();
            if ($user->isStudent()) {
                $data['enrolledSkills'] = $user->learnSkills()->take(3)->get();
                $data['recentRequests'] = $user->requestsMade()->latest()->take(3)->get();
            } elseif ($user->isTeacher()) {
                $data['teachingSkills'] = $user->teachSkills()->take(3)->get();
                $data['pendingRequests'] = $user->requestsReceived()->where('status', 'pending')->latest()->take(3)->get();
            }
        }

        return view('home', $data);
    }



    // ABOUT PAGE
    public function about()
    {
        return view('about');
    }

    // SERVICE PAGE
    public function service()
    {
        return view('service', [
            'serviceCount' => Skill::distinct('category')->count('category')
        ]);
    }

    // CONTACT PAGE
    public function contact()
    {
        return view('contact');
    }

    // PRIVACY POLICY PAGE
    public function privacy()
    {
        return view('privacy-policy');
    }

    // HELP CENTER
    public function helpCenter()
    {
        return view('help-center');
    }

    // TERMS OF USE
    public function terms()
    {
        return view('terms-of-use');
    }
}
