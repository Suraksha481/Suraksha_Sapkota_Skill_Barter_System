<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    public function run()
    {
        // Added the local file path (e.g. 'Images/skills/web_development.png') directly inline.
        // You just need to place your own real .png images inside the public/Images/skills folder.
        $skills = [
            // Technology
            ['Python Programming', 'Learn Python from beginner to advanced.', 'Technology', 'Images/skills/python.png'],
            ['Web Development', 'HTML, CSS, JavaScript, PHP basics.', 'Technology', 'Images/skills/web_development.png'],
            ['Laravel Framework', 'Build modern web apps using Laravel.', 'Technology', 'Images/skills/laravel.png'],
            ['React.js', 'Frontend development with React.', 'Technology', 'Images/skills/react.png'],
            ['Node.js', 'Backend development using Node.js.', 'Technology', 'Images/skills/node.png'],
            ['Database Design', 'MySQL and relational database concepts.', 'Technology', 'Images/skills/database.png'],
            ['API Development', 'Build and consume REST APIs.', 'Technology', 'Images/skills/api.png'],
            ['Cybersecurity Basics', 'Learn security fundamentals.', 'Technology', 'Images/skills/cybersecurity.png'],
            ['Git & GitHub', 'Version control and collaboration.', 'Technology', 'Images/skills/git.png'],
            ['Linux Basics', 'Command line and Linux fundamentals.', 'Technology', 'Images/skills/linux.png'],

            // Design
            ['Figma UI Design', 'Design modern UI using Figma.', 'Design', 'Images/skills/figma.png'],
            ['Graphic Design', 'Posters, banners, and logos.', 'Design', 'Images/skills/graphic_design.png'],
            ['UX Research', 'User research and usability testing.', 'Design', 'Images/skills/ux.png'],
            ['Adobe Photoshop', 'Photo editing and manipulation.', 'Design', 'Images/skills/photoshop.png'],
            ['Adobe Illustrator', 'Vector graphics and illustrations.', 'Design', 'Images/skills/illustrator.png'],
            ['Canva Design', 'Quick designs using Canva.', 'Design', 'Images/skills/canva.png'],
            ['Brand Identity Design', 'Logos and brand systems.', 'Design', 'Images/skills/branding.png'],
            ['Motion Graphics', 'Animated visuals and videos.', 'Design', 'Images/skills/motion.png'],

            // Business
            ['Entrepreneurship', 'Start and manage a business.', 'Business', 'Images/skills/entrepreneurship.png'],
            ['Startup Planning', 'Idea validation and planning.', 'Business', 'Images/skills/startup.png'],
            ['Project Management', 'Manage tasks and teams.', 'Business', 'Images/skills/project.png'],
            ['Business Analytics', 'Data-driven decision making.', 'Business', 'Images/skills/business_analytics.png'],
            ['Finance Basics', 'Personal and business finance.', 'Business', 'Images/skills/finance.png'],
            ['Marketing Strategy', 'Planning marketing campaigns.', 'Business', 'Images/skills/strategy.png'],

            // Marketing
            ['Digital Marketing', 'Online marketing fundamentals.', 'Marketing', 'Images/skills/marketing.png'],
            ['SEO Optimization', 'Search engine optimization.', 'Marketing', 'Images/skills/seo.png'],
            ['Social Media Marketing', 'Grow audience on social platforms.', 'Marketing', 'Images/skills/social.png'],
            ['Content Marketing', 'Content creation strategies.', 'Marketing', 'Images/skills/content.png'],
            ['Email Marketing', 'Email campaigns and automation.', 'Marketing', 'Images/skills/email.png'],
            ['Affiliate Marketing', 'Performance-based marketing.', 'Marketing', 'Images/skills/affiliate.png'],

            // Language & Soft Skills
            ['English Speaking', 'Improve spoken English.', 'Language', 'Images/skills/english.png'],
            ['Public Speaking', 'Confidence and presentation skills.', 'Language', 'Images/skills/language.png'],
            ['Business Communication', 'Professional communication.', 'Language', 'Images/skills/language.png'],
            ['Creative Writing', 'Storytelling and writing skills.', 'Language', 'Images/skills/writing.png'],
            ['Technical Writing', 'Write documentation clearly.', 'Language', 'Images/skills/technical_writing.png'],
            ['Leadership Skills', 'Lead teams effectively.', 'Soft Skills', 'Images/skills/leadership.png'],
            ['Time Management', 'Productivity and focus.', 'Soft Skills', 'Images/skills/time_management.png'],
            ['Critical Thinking', 'Problem solving techniques.', 'Soft Skills', 'Images/skills/soft_skills.png'],
            ['Emotional Intelligence', 'Understand emotions better.', 'Soft Skills', 'Images/skills/emotional_intelligence.png'],
            ['Team Collaboration', 'Work effectively in teams.', 'Soft Skills', 'Images/skills/team_collaboration.png'],

            // Data & AI
            ['Data Analysis', 'Analyze data for insights.', 'Data', 'Images/skills/data.png'],
            ['Machine Learning Basics', 'Intro to ML concepts.', 'Data', 'Images/skills/machine_learning.png'],
            ['AI Fundamentals', 'Understanding AI systems.', 'Data', 'Images/skills/ai.png'],
            ['Excel for Data', 'Excel for analysis and reporting.', 'Data', 'Images/skills/excel.png'],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
            ['slug' => Str::slug($skill[0])],
            [
                'title' => $skill[0],
                'description' => $skill[1],
                'category' => $skill[2],
                'image' => $skill[3] ?? null
            ]
            );
        }
    }
}
