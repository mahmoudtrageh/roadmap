<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use Illuminate\Database\Seeder;

class YouTubeResourcesSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $this->command->info('Starting YouTube Resources Seeder...');

        // Get all roadmaps
        $roadmaps = [
            'Programming Basics' => $this->getProgrammingBasicsResources(),
            'Object-Oriented Programming' => $this->getOOPResources(),
            'Web Development Foundations' => $this->getWebFoundationsResources(),
            'Frontend Fundamentals' => $this->getFrontendResources(),
            'Frontend Framework - React' => $this->getReactResources(),
            'Backend Development - Laravel' => $this->getLaravelResources(),
            'Full Stack Integration' => $this->getFullStackResources(),
            'Advanced Topics & Best Practices' => $this->getAdvancedResources(),
            'Senior Level Skills' => $this->getSeniorResources(),
            'Debugging & Code Quality' => $this->getDebuggingResources(),
            'Software Development Essentials' => $this->getSoftwareDevResources(),
        ];

        foreach ($roadmaps as $roadmapTitle => $topicResources) {
            $roadmap = Roadmap::where('title', $roadmapTitle)->first();

            if (!$roadmap) {
                $this->command->warn("Roadmap not found: {$roadmapTitle}");
                continue;
            }

            $this->command->info("Processing roadmap: {$roadmapTitle}");

            foreach ($topicResources as $topicKeywords => $resources) {
                $this->addResourcesToTasks($roadmap, $topicKeywords, $resources);
            }
        }

        $this->command->info('YouTube Resources Seeder completed!');
    }

    /**
     * Add resources to tasks matching topic keywords
     */
    private function addResourcesToTasks(Roadmap $roadmap, string $topicKeywords, array $resources): void
    {
        $keywords = array_map('trim', explode(',', $topicKeywords));

        $tasks = Task::where('roadmap_id', $roadmap->id)
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('title', 'LIKE', "%{$keyword}%")
                          ->orWhere('description', 'LIKE', "%{$keyword}%")
                          ->orWhere('category', 'LIKE', "%{$keyword}%");
                }
            })
            ->get();

        foreach ($tasks as $task) {
            $existingResources = $task->resources ?? [];

            // Merge new resources with existing ones (avoid duplicates)
            $existingUrls = array_column($existingResources, 'url');

            foreach ($resources as $resource) {
                if (!in_array($resource['url'], $existingUrls)) {
                    $existingResources[] = $resource;
                }
            }

            $task->resources = $existingResources;
            $task->save();

            $this->command->info("  - Added " . count($resources) . " resources to: {$task->title}");
        }
    }

    /**
     * Programming Basics Resources
     */
    private function getProgrammingBasicsResources(): array
    {
        return [
            'Programming, Fundamentals, Basics, Introduction' => [
                // English Resources
                ['url' => 'https://www.youtube.com/@freecodecamp', 'title' => 'freeCodeCamp - Programming Fundamentals', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@CSDojo', 'title' => 'CS Dojo - Programming Basics', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@TraversyMedia', 'title' => 'Traversy Media - Web Development Crash Courses', 'language' => 'en', 'type' => 'youtube'],
                // Arabic Resources
                ['url' => 'https://www.youtube.com/@ProgrammingAdvices', 'title' => 'Programming Advices - أساسيات البرمجة بلغة C++', 'language' => 'ar', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@dr.mohammedabdallayoussif8051', 'title' => 'Dr. Mohammed Abdalla - أساسيات البرمجة', 'language' => 'ar', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@essamcafe', 'title' => 'Essam Cafe - دروس برمجة', 'language' => 'ar', 'type' => 'youtube'],
            ],
        ];
    }

    private function getOOPResources(): array
    {
        return [
            'Object-Oriented, OOP, Class, Object' => [
                ['url' => 'https://www.youtube.com/@ProgramWithGio', 'title' => 'Program With Gio - OOP in PHP', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@freecodecamp', 'title' => 'freeCodeCamp - Object-Oriented Programming', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ProgrammingAdvices', 'title' => 'Programming Advices - البرمجة الكائنية', 'language' => 'ar', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@AmeerGaafar', 'title' => 'Ameer Gaafar - البرمجة الكائنية', 'language' => 'ar', 'type' => 'youtube'],
            ],
        ];
    }

    private function getWebFoundationsResources(): array
    {
        return [
            'HTML, Markup, Structure, Elements' => [
                ['url' => 'https://www.youtube.com/@SuperSimpleDev', 'title' => 'SuperSimpleDev - HTML Basics', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@TraversyMedia', 'title' => 'Traversy Media - HTML Crash Course', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@freecodecamp', 'title' => 'freeCodeCamp - HTML Full Course', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ahmadalfy', 'title' => 'Ahmad Alfy - أساسيات HTML', 'language' => 'ar', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@firefoxegyweb', 'title' => 'Firefox Egypt Web - دروس HTML', 'language' => 'ar', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@SimpleArabCode', 'title' => 'Simple Arab Code - تعلم HTML', 'language' => 'ar', 'type' => 'youtube'],
            ],
            'CSS, Styling, Design, Layout' => [
                ['url' => 'https://www.youtube.com/@SuperSimpleDev', 'title' => 'SuperSimpleDev - CSS Complete Guide', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@TraversyMedia', 'title' => 'Traversy Media - CSS Crash Course', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ahmadalfy', 'title' => 'Ahmad Alfy - تعلم CSS', 'language' => 'ar', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@firefoxegyweb', 'title' => 'Firefox Egypt Web - دروس CSS', 'language' => 'ar', 'type' => 'youtube'],
            ],
            'JavaScript, JS, Programming, Interactive' => [
                ['url' => 'https://www.youtube.com/@SuperSimpleDev', 'title' => 'SuperSimpleDev - JavaScript Full Course', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@TraversyMedia', 'title' => 'Traversy Media - JavaScript Crash Course', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@freecodecamp', 'title' => 'freeCodeCamp - JavaScript Full Course', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ahmdelemam', 'title' => 'Ahmed Elemam - تعلم JavaScript', 'language' => 'ar', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@yallacode_', 'title' => 'Yalla Code - دروس JavaScript', 'language' => 'ar', 'type' => 'youtube'],
            ],
        ];
    }

    private function getFrontendResources(): array
    {
        return [
            'Responsive, Mobile, Design, CSS' => [
                ['url' => 'https://www.youtube.com/@TraversyMedia', 'title' => 'Traversy Media - Responsive Web Design', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ahmadalfy', 'title' => 'Ahmad Alfy - التصميم المتجاوب', 'language' => 'ar', 'type' => 'youtube'],
            ],
            'Tailwind, CSS Framework' => [
                ['url' => 'https://www.youtube.com/@TraversyMedia', 'title' => 'Traversy Media - Tailwind CSS Crash Course', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@codebreakthrough', 'title' => 'Code Breakthrough - Tailwind CSS', 'language' => 'en', 'type' => 'youtube'],
            ],
            'DOM, Manipulation, Events' => [
                ['url' => 'https://www.youtube.com/@SuperSimpleDev', 'title' => 'SuperSimpleDev - DOM Manipulation', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@TraversyMedia', 'title' => 'Traversy Media - JavaScript DOM', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ahmdelemam', 'title' => 'Ahmed Elemam - التعامل مع DOM', 'language' => 'ar', 'type' => 'youtube'],
            ],
        ];
    }

    private function getReactResources(): array
    {
        return [
            'React, Component, JSX, Frontend Framework' => [
                ['url' => 'https://www.youtube.com/@TraversyMedia', 'title' => 'Traversy Media - React Crash Course', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@freecodecamp', 'title' => 'freeCodeCamp - React Full Course', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@PedroTechnologies', 'title' => 'Pedro Technologies - React Tutorial', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ahmdelemam', 'title' => 'Ahmed Elemam - تعلم React', 'language' => 'ar', 'type' => 'youtube'],
            ],
        ];
    }

    private function getLaravelResources(): array
    {
        return [
            'Laravel, PHP, Framework, Backend' => [
                ['url' => 'https://www.youtube.com/@LaravelPHP', 'title' => 'Laravel - Official Channel', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@LaravelDaily', 'title' => 'Laravel Daily - Tips and Tutorials', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ProgramWithGio', 'title' => 'Program With Gio - Laravel Course', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@codewithSJM', 'title' => 'Code with SJM - Laravel Tutorials', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@saleem-hadad', 'title' => 'Saleem Hadad - تعلم Laravel', 'language' => 'ar', 'type' => 'youtube'],
            ],
            'Eloquent, ORM, Database, Model' => [
                ['url' => 'https://www.youtube.com/@LaravelDaily', 'title' => 'Laravel Daily - Eloquent Tips', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ProgramWithGio', 'title' => 'Program With Gio - Eloquent ORM', 'language' => 'en', 'type' => 'youtube'],
            ],
        ];
    }

    private function getFullStackResources(): array
    {
        return [
            'Full Stack, Integration, MERN, LAMP' => [
                ['url' => 'https://www.youtube.com/@TraversyMedia', 'title' => 'Traversy Media - Full Stack Projects', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@freecodecamp', 'title' => 'freeCodeCamp - Full Stack Development', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@PedroTechnologies', 'title' => 'Pedro Technologies - MERN Stack', 'language' => 'en', 'type' => 'youtube'],
            ],
        ];
    }

    private function getAdvancedResources(): array
    {
        return [
            'Testing, TDD, PHPUnit, Unit Test' => [
                ['url' => 'https://www.youtube.com/@LaravelDaily', 'title' => 'Laravel Daily - Testing in Laravel', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ProgramWithGio', 'title' => 'Program With Gio - PHP Testing', 'language' => 'en', 'type' => 'youtube'],
            ],
            'Docker, Container, Deployment' => [
                ['url' => 'https://www.youtube.com/@TechWorldwithNana', 'title' => 'TechWorld with Nana - Docker Tutorial', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@freecodecamp', 'title' => 'freeCodeCamp - Docker Course', 'language' => 'en', 'type' => 'youtube'],
            ],
            'CI/CD, DevOps, Automation' => [
                ['url' => 'https://www.youtube.com/@TechWorldwithNana', 'title' => 'TechWorld with Nana - CI/CD Pipeline', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@Cloud-Kode', 'title' => 'Cloud Kode - DevOps Tutorials', 'language' => 'en', 'type' => 'youtube'],
            ],
            'Security, Cybersecurity, Penetration' => [
                ['url' => 'https://www.youtube.com/@SecTheater', 'title' => 'Sec Theater - أمن المعلومات', 'language' => 'ar', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@metwallysec', 'title' => 'Metwally Sec - الاختراق الأخلاقي', 'language' => 'ar', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@MetwallyLabs', 'title' => 'Metwally Labs - Security Labs', 'language' => 'ar', 'type' => 'youtube'],
            ],
        ];
    }

    private function getSeniorResources(): array
    {
        return [
            'System Design, Architecture, Scalability' => [
                ['url' => 'https://www.youtube.com/@ByteByteGo', 'title' => 'ByteByteGo - System Design Interview', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ashishps_1', 'title' => 'Ashish Pratap Singh - System Design', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@hnasr', 'title' => 'Hussein Nasser - Backend Engineering', 'language' => 'en', 'type' => 'youtube'],
            ],
            'Database, Performance, Optimization' => [
                ['url' => 'https://www.youtube.com/@hnasr', 'title' => 'Hussein Nasser - Database Engineering', 'language' => 'en', 'type' => 'youtube'],
            ],
            'Microservices, Distributed Systems' => [
                ['url' => 'https://www.youtube.com/@ByteByteGo', 'title' => 'ByteByteGo - Microservices Architecture', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@hnasr', 'title' => 'Hussein Nasser - Distributed Systems', 'language' => 'en', 'type' => 'youtube'],
            ],
            'Algorithms, Data Structures, Interview' => [
                ['url' => 'https://www.youtube.com/@NeetCode', 'title' => 'NeetCode - LeetCode Solutions', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ArabicCompetitiveProgramming', 'title' => 'Arabic Competitive Programming - البرمجة التنافسية', 'language' => 'ar', 'type' => 'youtube'],
            ],
        ];
    }

    private function getDebuggingResources(): array
    {
        return [
            'Debugging, Error, Bug, Troubleshoot' => [
                ['url' => 'https://www.youtube.com/@alexhyettdev', 'title' => 'Alex Hyett - Debugging Techniques', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@TraversyMedia', 'title' => 'Traversy Media - Debugging Tips', 'language' => 'en', 'type' => 'youtube'],
            ],
            'Code Quality, Clean Code, Best Practices' => [
                ['url' => 'https://www.youtube.com/@alexhyettdev', 'title' => 'Alex Hyett - Clean Code', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@ProgramWithGio', 'title' => 'Program With Gio - Design Patterns', 'language' => 'en', 'type' => 'youtube'],
            ],
        ];
    }

    private function getSoftwareDevResources(): array
    {
        return [
            'Git, Version Control, GitHub' => [
                ['url' => 'https://www.youtube.com/@freecodecamp', 'title' => 'freeCodeCamp - Git and GitHub', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@TraversyMedia', 'title' => 'Traversy Media - Git Crash Course', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@MissingSemester', 'title' => 'Missing Semester - Version Control', 'language' => 'en', 'type' => 'youtube'],
            ],
            'Command Line, Terminal, Shell, Bash' => [
                ['url' => 'https://www.youtube.com/@MissingSemester', 'title' => 'Missing Semester - The Shell', 'language' => 'en', 'type' => 'youtube'],
                ['url' => 'https://www.youtube.com/@freecodecamp', 'title' => 'freeCodeCamp - Command Line Crash Course', 'language' => 'en', 'type' => 'youtube'],
            ],
            'Agile, Scrum, Project Management' => [
                ['url' => 'https://www.youtube.com/@alexhyettdev', 'title' => 'Alex Hyett - Software Engineering Career', 'language' => 'en', 'type' => 'youtube'],
            ],
        ];
    }
}
