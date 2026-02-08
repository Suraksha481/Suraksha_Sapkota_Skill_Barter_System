<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    public function run()
    {
        $skills = [
            // Technology
            ['Python Programming', 'Learn Python from beginner to advanced.', 'Technology'],
            ['Web Development', 'HTML, CSS, JavaScript, PHP basics.', 'Technology'],
            ['Laravel Framework', 'Build modern web apps using Laravel.', 'Technology'],
            ['React.js', 'Frontend development with React.', 'Technology'],
            ['Node.js', 'Backend development using Node.js.', 'Technology'],
            ['Database Design', 'MySQL and relational database concepts.', 'Technology'],
            ['API Development', 'Build and consume REST APIs.', 'Technology'],
            ['Cybersecurity Basics', 'Learn security fundamentals.', 'Technology'],
            ['Git & GitHub', 'Version control and collaboration.', 'Technology'],
            ['Linux Basics', 'Command line and Linux fundamentals.', 'Technology'],

            // Design
            ['Figma UI Design', 'Design modern UI using Figma.', 'Design'],
            ['Graphic Design', 'Posters, banners, and logos.', 'Design'],
            ['UX Research', 'User research and usability testing.', 'Design'],
            ['Adobe Photoshop', 'Photo editing and manipulation.', 'Design'],
            ['Adobe Illustrator', 'Vector graphics and illustrations.', 'Design'],
            ['Canva Design', 'Quick designs using Canva.', 'Design'],
            ['Brand Identity Design', 'Logos and brand systems.', 'Design'],
            ['Motion Graphics', 'Animated visuals and videos.', 'Design'],

            // Business
            ['Entrepreneurship', 'Start and manage a business.', 'Business'],
            ['Startup Planning', 'Idea validation and planning.', 'Business'],
            ['Project Management', 'Manage tasks and teams.', 'Business'],
            ['Business Analytics', 'Data-driven decision making.', 'Business'],
            ['Finance Basics', 'Personal and business finance.', 'Business'],
            ['Marketing Strategy', 'Planning marketing campaigns.', 'Business'],

            // Marketing
            ['Digital Marketing', 'Online marketing fundamentals.', 'Marketing'],
            ['SEO Optimization', 'Search engine optimization.', 'Marketing'],
            ['Social Media Marketing', 'Grow audience on social platforms.', 'Marketing'],
            ['Content Marketing', 'Content creation strategies.', 'Marketing'],
            ['Email Marketing', 'Email campaigns and automation.', 'Marketing'],
            ['Affiliate Marketing', 'Performance-based marketing.', 'Marketing'],

            // Language & Soft Skills
            ['English Speaking', 'Improve spoken English.', 'Language'],
            ['Public Speaking', 'Confidence and presentation skills.', 'Language'],
            ['Business Communication', 'Professional communication.', 'Language'],
            ['Creative Writing', 'Storytelling and writing skills.', 'Language'],
            ['Technical Writing', 'Write documentation clearly.', 'Language'],
            ['Leadership Skills', 'Lead teams effectively.', 'Soft Skills'],
            ['Time Management', 'Productivity and focus.', 'Soft Skills'],
            ['Critical Thinking', 'Problem solving techniques.', 'Soft Skills'],
            ['Emotional Intelligence', 'Understand emotions better.', 'Soft Skills'],
            ['Team Collaboration', 'Work effectively in teams.', 'Soft Skills'],

            // Data & AI
            ['Data Analysis', 'Analyze data for insights.', 'Data'],
            ['Machine Learning Basics', 'Intro to ML concepts.', 'Data'],
            ['AI Fundamentals', 'Understanding AI systems.', 'Data'],
            ['Excel for Data', 'Excel for analysis and reporting.', 'Data'],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['slug' => Str::slug($skill[0])],
                [
                    'title' => $skill[0],
                    'description' => $skill[1],
                    'category' => $skill[2],
                ]
            );
        }
    }
}
