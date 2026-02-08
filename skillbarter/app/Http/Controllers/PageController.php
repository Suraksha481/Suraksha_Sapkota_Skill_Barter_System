<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\User;

class PageController extends Controller
{
    // HOME PAGE
   public function home()
    {
        return view('home', [
            'totalUsers' => \App\Models\User::count(),
            'totalSkills' => \App\Models\Skill::count(),
            'popularSkills' => \App\Models\Skill::withCount('users')
                ->orderBy('users_count', 'desc')
                ->take(6)
                ->get(),
        ]);
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

    // BLOG PAGE (STATIC CONTENT, DYNAMIC STRUCTURE)
    public function blogs()
    {
        $blogs = [
            [
                'title' => 'Top 10 Tech Skills to Learn in 2025',
                'desc'  => 'Future-proof your career with high-demand skills.',
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475'
            ],
            [
                'title' => 'How to Become a Graphic Designer',
                'desc'  => 'Learn design fundamentals step by step.',
                'image' => 'https://images.unsplash.com/photo-1526498460520-4c246339dccb'
            ],
            [
                'title' => 'Freelancing Tips for Beginners',
                'desc'  => 'Start your freelancing journey confidently.',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f'
            ],
        ];

        return view('blogs', compact('blogs'));
    }

    // CONTACT PAGE
    public function contact()
    {
        return view('contact');
    }
}
