<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class CareerSkillsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();
        $phase8 = Roadmap::where('slug', 'phase-8-professional-skills')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? 1,
            'title' => 'CV & Interview Mastery',
            'description' => 'Master the art of creating outstanding developer CVs, building portfolios, preparing for technical interviews, and landing your dream job.',
            'slug' => 'cv-interview-skills',
            'duration_days' => 14,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 16,
            'prerequisite_roadmap_id' => null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            // Week 1: CV & Portfolio
            [
                'title' => 'Crafting a Developer CV',
                'description' => 'Learn how to create an ATS-friendly developer CV: structure, content, keywords, achievements, and formatting best practices.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Career',
                'learning_objectives' => [],
                'skills_gained' => ['CV Writing', 'Personal Branding', 'Career Marketing'],
                'tags' => ['cv', 'resume', 'career', 'job-search'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=Tt08KmFfIYQ', 'title' => 'freeCodeCamp - How to Write a Resume', 'type' => 'video'],
                    ['url' => 'https://resume.io/resume-examples/developer', 'title' => 'Developer Resume Examples', 'type' => 'article'],
                    ['url' => 'https://zety.com/blog/how-to-make-a-resume', 'title' => 'Resume Writing Guide - Zety', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Portfolio Website Development',
                'description' => 'Build a professional portfolio website showcasing your projects, skills, and achievements. Learn best practices for developer portfolios.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Career',
                'learning_objectives' => [],
                'skills_gained' => ['Portfolio Development', 'Web Design', 'Personal Branding'],
                'tags' => ['portfolio', 'website', 'projects', 'career'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=r_hYR53r61M', 'title' => 'Traversy Media - Portfolio Website', 'type' => 'video'],
                    ['url' => 'https://github.com/topics/portfolio', 'title' => 'Portfolio Examples on GitHub', 'type' => 'article'],
                    ['url' => 'https://dev.to/topics/portfolio', 'title' => 'Portfolio Tips - DEV Community', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'GitHub Profile Optimization',
                'description' => 'Optimize your GitHub profile: README, pinned repos, contribution graph, and creating an impressive developer presence.',
                'estimated_time_minutes' => 90,
                'task_type' => 'exercise',
                'category' => 'Career',
                'learning_objectives' => [],
                'skills_gained' => ['GitHub Optimization', 'Personal Branding'],
                'tags' => ['github', 'profile', 'open-source', 'career'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://github.com/abhisheknaiidu/awesome-github-profile-readme', 'title' => 'Awesome GitHub Profile READMEs', 'type' => 'article'],
                    ['url' => 'https://docs.github.com/en/get-started/writing-on-github', 'title' => 'GitHub Writing Guide', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'LinkedIn Profile for Developers',
                'description' => 'Create a compelling LinkedIn profile: headline, summary, experience, skills, and networking strategies for developers.',
                'estimated_time_minutes' => 90,
                'task_type' => 'exercise',
                'category' => 'Career',
                'learning_objectives' => [],
                'skills_gained' => ['LinkedIn Optimization', 'Professional Networking'],
                'tags' => ['linkedin', 'networking', 'career', 'professional'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://linkedin.com/business/talent/blog/product-tips/LinkedIn-profile-summaries-that-we-love-and-how-to-boost-your-own', 'title' => 'LinkedIn Profile Tips', 'type' => 'article'],
                    ['url' => 'https://enhancv.com/blog/linkedin-profile-tips/', 'title' => 'LinkedIn Optimization Guide', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Building a Tech Blog',
                'description' => 'Start a technical blog: choosing platform (DEV.to, Medium, personal), writing technical content, and building your brand.',
                'estimated_time_minutes' => 120,
                'task_type' => 'exercise',
                'category' => 'Career',
                'learning_objectives' => [],
                'skills_gained' => ['Technical Writing', 'Content Creation', 'Personal Branding'],
                'tags' => ['blog', 'writing', 'content', 'career'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://dev.to/', 'title' => 'DEV Community Platform', 'type' => 'article'],
                    ['url' => 'https://medium.com/', 'title' => 'Medium Publishing Platform', 'type' => 'article'],
                    ['url' => 'https://hashnode.com/', 'title' => 'Hashnode for Developers', 'type' => 'article'],
                ],
            ],

            // Week 2: Interview Preparation
            [
                'title' => 'Understanding Interview Process',
                'description' => 'Learn the complete interview process: phone screens, technical screens, coding challenges, system design, and behavioral interviews.',
                'estimated_time_minutes' => 90,
                'task_type' => 'reading',
                'category' => 'Interview Prep',
                'learning_objectives' => [],
                'skills_gained' => ['Interview Preparation', 'Career Knowledge'],
                'tags' => ['interview', 'process', 'career', 'job-search'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://interviewing.io/guides/hiring-process', 'title' => 'Tech Interview Process Guide', 'type' => 'article'],
                    ['url' => 'https://github.com/yangshun/tech-interview-handbook', 'title' => 'Tech Interview Handbook', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Data Structures & Algorithms Review',
                'description' => 'Review essential DSA concepts for interviews: arrays, linked lists, trees, graphs, sorting, searching, and complexity analysis.',
                'estimated_time_minutes' => 120,
                'task_type' => 'exercise',
                'category' => 'Interview Prep',
                'learning_objectives' => [],
                'skills_gained' => ['DSA', 'Problem Solving', 'Coding Interviews'],
                'tags' => ['algorithms', 'data-structures', 'interview', 'coding'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://neetcode.io/roadmap', 'title' => 'NeetCode Roadmap', 'type' => 'article'],
                    ['url' => 'https://leetcode.com/explore/', 'title' => 'LeetCode Explore', 'type' => 'article'],
                    ['url' => 'https://visualgo.net/', 'title' => 'Algorithm Visualizations', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'LeetCode Practice - Easy Problems',
                'description' => 'Solve 10-15 easy LeetCode problems covering arrays, strings, hash tables, and basic algorithms.',
                'estimated_time_minutes' => 120,
                'task_type' => 'exercise',
                'category' => 'Interview Prep',
                'learning_objectives' => [],
                'skills_gained' => ['Problem Solving', 'Coding Speed', 'Algorithm Implementation'],
                'tags' => ['leetcode', 'coding', 'practice', 'interview'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://leetcode.com/problemset/all/?difficulty=EASY', 'title' => 'LeetCode Easy Problems', 'type' => 'article'],
                    ['url' => 'https://neetcode.io/practice', 'title' => 'NeetCode 150', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'LeetCode Practice - Medium Problems',
                'description' => 'Tackle medium difficulty problems: two pointers, sliding window, DFS/BFS, dynamic programming basics.',
                'estimated_time_minutes' => 120,
                'task_type' => 'exercise',
                'category' => 'Interview Prep',
                'learning_objectives' => [],
                'skills_gained' => ['Advanced Problem Solving', 'Pattern Recognition'],
                'tags' => ['leetcode', 'algorithms', 'practice', 'interview'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://leetcode.com/problemset/all/?difficulty=MEDIUM', 'title' => 'LeetCode Medium Problems', 'type' => 'article'],
                    ['url' => 'https://youtube.com/@NeetCode', 'title' => 'NeetCode YouTube Channel', 'type' => 'video'],
                ],
            ],
            [
                'title' => 'System Design Fundamentals',
                'description' => 'Learn system design basics: scalability, load balancing, caching, databases, microservices, and design patterns.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Interview Prep',
                'learning_objectives' => [],
                'skills_gained' => ['System Design', 'Architecture', 'Scalability'],
                'tags' => ['system-design', 'architecture', 'interview', 'scalability'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=bUHFg8CZFws', 'title' => 'System Design Primer - freeCodeCamp', 'type' => 'video'],
                    ['url' => 'https://github.com/donnemartin/system-design-primer', 'title' => 'System Design Primer - GitHub', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Behavioral Interview Preparation',
                'description' => 'Master behavioral interviews: STAR method, common questions, storytelling, and demonstrating soft skills.',
                'estimated_time_minutes' => 90,
                'task_type' => 'exercise',
                'category' => 'Interview Prep',
                'learning_objectives' => [],
                'skills_gained' => ['Behavioral Interviews', 'Communication', 'Storytelling'],
                'tags' => ['behavioral', 'interview', 'communication', 'soft-skills'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://biginterview.com/blog/behavioral-interview-questions', 'title' => 'Behavioral Questions Guide', 'type' => 'article'],
                    ['url' => 'https://interviewsteps.com/blogs/guides/star-method', 'title' => 'STAR Method Explained', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Mock Technical Interviews',
                'description' => 'Practice mock interviews: coding problems, system design, and behavioral questions in interview-like conditions.',
                'estimated_time_minutes' => 120,
                'task_type' => 'exercise',
                'category' => 'Interview Prep',
                'learning_objectives' => [],
                'skills_gained' => ['Interview Skills', 'Communication', 'Problem Solving'],
                'tags' => ['mock-interview', 'practice', 'interview', 'preparation'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://interviewing.io/', 'title' => 'interviewing.io - Practice Platform', 'type' => 'article'],
                    ['url' => 'https://pramp.com/', 'title' => 'Pramp - Peer Mock Interviews', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Salary Negotiation Skills',
                'description' => 'Learn salary negotiation: researching market rates, making counter offers, negotiating benefits, and knowing your worth.',
                'estimated_time_minutes' => 60,
                'task_type' => 'reading',
                'category' => 'Career',
                'learning_objectives' => [],
                'skills_gained' => ['Negotiation', 'Communication', 'Career Strategy'],
                'tags' => ['salary', 'negotiation', 'career', 'compensation'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://haseebq.com/my-ten-rules-for-negotiating-a-job-offer/', 'title' => '10 Rules for Salary Negotiation', 'type' => 'article'],
                    ['url' => 'https://levels.fyi/', 'title' => 'levels.fyi - Salary Data', 'type' => 'article'],
                    ['url' => 'https://glassdoor.com/Salaries/index.htm', 'title' => 'Glassdoor Salary Data', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Job Search Strategy & Networking',
                'description' => 'Develop effective job search strategy: finding opportunities, networking, cold emailing, referrals, and follow-ups.',
                'estimated_time_minutes' => 90,
                'task_type' => 'exercise',
                'category' => 'Career',
                'learning_objectives' => [],
                'skills_gained' => ['Job Search', 'Networking', 'Professional Communication'],
                'tags' => ['job-search', 'networking', 'career', 'outreach'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://wellfound.com/', 'title' => 'Wellfound (AngelList Talent)', 'type' => 'article'],
                    ['url' => 'https://linkedin.com/jobs/', 'title' => 'LinkedIn Jobs', 'type' => 'article'],
                    ['url' => 'https://remoteok.com/', 'title' => 'RemoteOK - Remote Jobs', 'type' => 'article'],
                ],
            ],
        ];

        $dayNumber = 1;
        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, [
                'roadmap_id' => $roadmap->id,
                'day_number' => $dayNumber++,
                'order' => 1,
                'difficulty_level' => 'intermediate',
                'has_code_submission' => $taskData['has_code_submission'] ?? false,
                'has_quality_rating' => false,
            ]));
        }
    }
}
