<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::truncate();

        $services = [
            // TEACHER SPECIFIC
            [
                'title' => 'Teaching Dashboard',
                'description' => 'Manage your student requests and upcoming teaching sessions.',
                'role' => 'teacher',
                'teacher_route' => 'teacher.dashboard',
                'student_route' => null,
            ],
            [
                'title' => 'Resource Hub',
                'description' => 'Upload and manage materials for your students.',
                'role' => 'teacher',
                'teacher_route' => 'teacher.resources.index',
                'student_route' => null,
            ],
            [
                'title' => 'Teaching Analytics',
                'description' => 'Track your ratings and teaching performance.',
                'role' => 'teacher',
                'teacher_route' => 'teacher.analytics',
                'student_route' => null,
            ],

            // STUDENT SPECIFIC
            [
                'title' => 'Search for Mentors',
                'description' => 'Connect with experts to learn new skills or broaden your knowledge.',
                'role' => 'student',
                'teacher_route' => null,
                'student_route' => 'teachers.index',
            ],
            [
                'title' => 'Learning Roadmap',
                'description' => 'Track your progress through your personalized learning path.',
                'role' => 'student',
                'teacher_route' => null,
                'student_route' => 'student.learning-path',
            ],
            [
                'title' => 'My Rewards',
                'description' => 'View your earned badges and community points.',
                'role' => 'student',
                'teacher_route' => null,
                'student_route' => 'rewards.index',
            ],

            // BOTH ROLES (Teachers can also search for mentors)
          
            [
                'title' => 'Active Sessions',
                'description' => 'Manage your ongoing skill-swapping classes.',
                'role' => 'both',
                'teacher_route' => 'sessions.index',
                'student_route' => 'sessions.index',
            ],

            // GUEST
            [
                'title' => 'Join the Community',
                'description' => 'Create an account to start your skill-bartering journey.',
                'role' => 'guest',
                'teacher_route' => null,
                'student_route' => 'register',
            ],
            [
                'title' => 'Explore Skills',
                'description' => 'Browse the skills shared by our amazing community.',
                'role' => 'guest',
                'teacher_route' => null,
                'student_route' => 'find-skill',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
