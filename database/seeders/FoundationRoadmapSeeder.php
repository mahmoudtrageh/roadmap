<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FoundationRoadmapSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();

        $roadmap = Roadmap::create([
            'creator_id' => 1,
            'title' => 'Foundation',
            'description' => 'Master fundamental concepts: How computers work, operating systems, command line, programming basics, internet, HTTP/HTTPS, DNS, and browsers.',
            'slug' => 'phase-1-foundation',
            'creator_id' => $admin->id ?? null,
            'duration_days' => 17,
            'difficulty_level' => 'beginner',
            'is_published' => true,
            'is_featured' => false,
            'order' => 2,
            'prerequisite_roadmap_id' => null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            // Day 1-4: How Computers Work (split 475 min into 4 days)
            [
                'title' => 'How Computers Work - Part 1',
                'description' => 'Understand the fundamental concepts of how computers work: hardware components, binary, and basic architecture. Watch episodes 1-10 of Crash Course Computer Science.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Computer Science',
                'learning_objectives' => [],
                'skills_gained' => ['Computer Architecture', 'Hardware Fundamentals', 'Binary Systems'],
                'tags' => ['computer-science', 'fundamentals', 'hardware'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://youtube.com/playlist?list=PL8dPuuaLjXtNlUrzyH5r6jN9ulIgZBpdo', 'title' => 'Crash Course - Computer Science (Episodes 1-10)', 'type' => 'video'],
                    ['url' => 'https://www.explainthatstuff.com/howcomputerswork.html', 'title' => 'How Do Computers Work? - Explain That Stuff', 'type' => 'article'],
                    ['url' => 'https://edu.gcfglobal.org/en/computerbasics/what-is-a-computer/1/', 'title' => 'What is a Computer? - GCFGlobal', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Code: The Hidden Language by Charles Petzold (Chapters 1-12)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'But How Do It Know? by J. Clark Scott', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'How Computers Work - Part 2',
                'description' => 'Continue learning about CPU operations, memory hierarchy, and data storage. Watch episodes 11-20 of Crash Course Computer Science.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Computer Science',
                'learning_objectives' => [],
                'skills_gained' => ['CPU Operations', 'Memory Management', 'Data Storage'],
                'tags' => ['computer-science', 'cpu', 'memory'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://youtube.com/playlist?list=PL8dPuuaLjXtNlUrzyH5r6jN9ulIgZBpdo', 'title' => 'Crash Course - Computer Science (Episodes 11-20)', 'type' => 'video'],
                    ['url' => 'https://www.explainthatstuff.com/how-computer-memory-works.html', 'title' => 'How Computer Memory Works - Explain That Stuff', 'type' => 'article'],
                    ['url' => 'https://www.geeksforgeeks.org/computer-organization-and-architecture-tutorials/', 'title' => 'CPU & Memory Architecture - GeeksforGeeks', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'How Computers Work - Part 3',
                'description' => 'Learn about algorithms, data structures basics, and software fundamentals. Watch episodes 21-30 of Crash Course Computer Science.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Computer Science',
                'learning_objectives' => [],
                'skills_gained' => ['Algorithms', 'Data Structures', 'Software Fundamentals'],
                'tags' => ['computer-science', 'algorithms', 'software'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://youtube.com/playlist?list=PL8dPuuaLjXtNlUrzyH5r6jN9ulIgZBpdo', 'title' => 'Crash Course - Computer Science (Episodes 21-30)', 'type' => 'video'],
                ],
            ],
            [
                'title' => 'How Computers Work - Part 4',
                'description' => 'Explore programming languages, compilers, and modern computing. Watch remaining episodes of Crash Course Computer Science.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Computer Science',
                'learning_objectives' => [],
                'skills_gained' => ['Programming Languages', 'Compilers', 'Modern Computing'],
                'tags' => ['computer-science', 'programming', 'compilers'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://youtube.com/playlist?list=PL8dPuuaLjXtNlUrzyH5r6jN9ulIgZBpdo', 'title' => 'Crash Course - Computer Science (Episodes 31-40)', 'type' => 'video'],
                ],
            ],
            // Day 5: Operating Systems Basics (120 min selected content)
            [
                'title' => 'Operating Systems Basics',
                'description' => 'Learn the fundamentals of operating systems including processes, memory management, file systems, and OS architecture. Focus on essential concepts from curated playlist episodes.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Operating Systems',
                'learning_objectives' => [],
                'skills_gained' => ['Operating Systems', 'Process Management', 'File Systems'],
                'tags' => ['operating-systems', 'fundamentals', 'os'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://youtube.com/playlist?list=PLBlnK6fEyqRiVhbXDGLXDk_OQAeuVcp2O', 'title' => 'Neso Academy - Operating Systems (First 15 videos)', 'type' => 'video'],
                    ['url' => 'https://geeksforgeeks.org/operating-systems/', 'title' => 'Operating System Tutorial - GeeksforGeeks', 'type' => 'article'],
                    ['url' => 'https://tutorialspoint.com/operating_system/', 'title' => 'Operating System Basics - Tutorialspoint', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Operating Systems: Three Easy Pieces (Free Online)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Modern Operating Systems by Tanenbaum (Chapters 1-3)', 'type' => 'book'],
                ],
            ],
            // Day 6: Command Line / Terminal (56 min actual)
            [
                'title' => 'Command Line / Terminal',
                'description' => 'Master the command line interface, basic commands, file navigation, and shell scripting basics.',
                'estimated_time_minutes' => 36,
                'task_type' => 'video',
                'category' => 'Command Line',
                'learning_objectives' => [],
                'skills_gained' => ['Command Line', 'Bash', 'Terminal', 'Shell Commands'],
                'tags' => ['cli', 'terminal', 'bash', 'linux'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=yz7nYlnXLfE', 'title' => 'freeCodeCamp - Command Line Crash Course', 'type' => 'video'],
                    ['url' => 'https://linuxcommand.org/lc3_learning_the_shell.php', 'title' => 'Linux Command Line - LinuxCommand.org', 'type' => 'article'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Learn/Tools_and_testing/Understanding_client-side_tools/Command_line', 'title' => 'Command Line Basics - MDN', 'type' => 'article'],
                    ['url' => '#', 'title' => 'The Linux Command Line by William Shotts (Chapters 1-10)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Learning the bash Shell O\'Reilly (Chapters 1-5)', 'type' => 'book'],
                ],
            ],
            // Day 7: Programming Fundamentals - Part 1
            [
                'title' => 'Programming Fundamentals - Part 1',
                'description' => 'Learn core programming concepts: variables, data types, operators, input/output, and problem-solving basics. Watch first 2 hours of freeCodeCamp course.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Programming',
                'learning_objectives' => [],
                'skills_gained' => ['Programming Basics', 'Problem Solving', 'Variables'],
                'tags' => ['programming', 'fundamentals', 'basics'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=zOjov-2OZ0E&t=0s', 'title' => 'freeCodeCamp - Programming for Beginners (Hours 0-2)', 'type' => 'video'],
                    ['url' => 'https://javascript.info/first-steps', 'title' => 'JavaScript Basics - javascript.info', 'type' => 'article'],
                    ['url' => 'https://codecademy.com/learn/learn-how-to-code', 'title' => 'Programming Fundamentals - Codecademy', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Head First Programming (Chapters 1-5)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Clean Code by Robert Martin (Chapter 2)', 'type' => 'book'],
                ],
            ],
            // Day 8: JavaScript Introduction - Part 2
            [
                'title' => 'JavaScript Introduction - Part 2',
                'description' => 'Continue learning JavaScript fundamentals with deeper focus on syntax, expressions, and basic programming patterns. This bridges the gap between basic programming concepts and advanced topics.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Programming',
                'learning_objectives' => [],
                'skills_gained' => ['JavaScript', 'Programming Patterns', 'Syntax'],
                'tags' => ['javascript', 'programming', 'fundamentals'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=W6NZfCO5SIk', 'title' => 'Mosh - JavaScript Tutorial for Beginners (Hour 1-2)', 'type' => 'video'],
                    ['url' => 'https://javascript.info/first-steps', 'title' => 'JavaScript Fundamentals - javascript.info', 'type' => 'article'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Introduction', 'title' => 'JavaScript Introduction - MDN', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Eloquent JavaScript (Chapter 1)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'JavaScript: The Good Parts (Chapter 1)', 'type' => 'book'],
                ],
            ],
            // Day 9: Control Flow & Loops (22 min actual)
            [
                'title' => 'Control Flow & Loops',
                'description' => 'Master conditional statements (if/else/switch), loops (for/while), and control flow patterns.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'Programming',
                'learning_objectives' => [],
                'skills_gained' => ['Control Flow', 'Loops', 'Conditionals'],
                'tags' => ['loops', 'conditionals', 'control-flow'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=Kn06785pkJg', 'title' => 'Traversy Media - JavaScript Loops', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Glossary/Control_flow', 'title' => 'Control Flow - MDN Web Docs', 'type' => 'article'],
                    ['url' => 'https://javascript.info/while-for', 'title' => 'Loops and Iteration - javascript.info', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Eloquent JavaScript (Chapter 2)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'JavaScript: The Good Parts (Chapter 2)', 'type' => 'book'],
                ],
            ],
            // Day 10: Functions (54 min actual)
            [
                'title' => 'Functions',
                'description' => 'Learn to create and use functions, understand parameters, return values, and function scope.',
                'estimated_time_minutes' => 44,
                'task_type' => 'video',
                'category' => 'Programming',
                'learning_objectives' => [],
                'skills_gained' => ['Functions', 'Code Reusability', 'Scope'],
                'tags' => ['functions', 'parameters', 'scope'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=xUI5Tsl2JpY', 'title' => 'The Net Ninja - JavaScript Functions', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Functions', 'title' => 'Functions - MDN Web Docs', 'type' => 'article'],
                    ['url' => 'https://javascript.info/function-basics', 'title' => 'Functions - javascript.info', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Eloquent JavaScript (Chapter 3)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'JavaScript: The Definitive Guide (Chapter 8)', 'type' => 'book'],
                ],
            ],
            // Day 11: Arrays & Objects (16 min actual)
            [
                'title' => 'Arrays & Objects',
                'description' => 'Master arrays and objects: creation, manipulation, iteration, and common operations.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'Data Structures',
                'learning_objectives' => [],
                'skills_gained' => ['Arrays', 'Objects', 'Data Structures'],
                'tags' => ['arrays', 'objects', 'data-structures'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=oigfaZ5ApsM', 'title' => 'Traversy Media - JavaScript Arrays', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array', 'title' => 'Arrays - MDN Web Docs', 'type' => 'article'],
                    ['url' => 'https://javascript.info/object', 'title' => 'Objects - javascript.info', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Eloquent JavaScript (Chapter 4)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'You Don\'t Know JS: Types & Grammar (Chapters 2-3)', 'type' => 'book'],
                ],
            ],
            // Day 12: How The Internet Works (57 min actual)
            [
                'title' => 'How The Internet Works',
                'description' => 'Understand internet fundamentals: IP addresses, packets, routing, protocols, and network layers.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'Networking',
                'learning_objectives' => [],
                'skills_gained' => ['Internet', 'Networking', 'Protocols'],
                'tags' => ['internet', 'networking', 'protocols'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=7_LPdttKXPc', 'title' => 'Academind - How The Internet Works', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Learn/Common_questions/How_does_the_Internet_work', 'title' => 'How Does the Internet Work? - MDN', 'type' => 'article'],
                    ['url' => 'https://web.dev/articles/howbrowserswork', 'title' => 'How the Web Works - web.dev', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Computer Networking: A Top-Down Approach (Chapter 1)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'HTTP: The Definitive Guide (Chapters 1-2)', 'type' => 'book'],
                ],
            ],
            // Day 13-16: HTTP/HTTPS (split 347 min into 3 days)
            [
                'title' => 'HTTP/HTTPS - Part 1',
                'description' => 'Learn HTTP protocol basics: requests, responses, methods, and request structure. Watch Traversy Media HTTP Crash Course.',
                'estimated_time_minutes' => 40,
                'task_type' => 'video',
                'category' => 'Web',
                'learning_objectives' => [],
                'skills_gained' => ['HTTP', 'Web Protocols', 'Request/Response'],
                'tags' => ['http', 'web', 'protocols'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=iYM2zFP3Zn0', 'title' => 'Traversy Media - HTTP Crash Course', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Overview', 'title' => 'HTTP Overview - MDN', 'type' => 'article'],
                    ['url' => '#', 'title' => 'HTTP: The Definitive Guide (Chapters 3-7)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'HTTP/HTTPS - Part 2',
                'description' => 'Deep dive into HTTP: status codes, headers, cookies, sessions. Watch first half of Web Dev Simplified HTTP course.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Web',
                'learning_objectives' => [],
                'skills_gained' => ['HTTP Headers', 'Status Codes', 'Cookies & Sessions'],
                'tags' => ['http', 'headers', 'cookies'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=2JYT5f2isg4', 'title' => 'Web Dev Simplified - HTTP (Part 1)', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Status', 'title' => 'HTTP Status Codes - MDN', 'type' => 'article'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers', 'title' => 'HTTP Headers - MDN', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'HTTP/HTTPS - Part 3',
                'description' => 'Learn about HTTPS encryption, SSL/TLS, certificates, and secure communication. Complete Web Dev Simplified HTTP course.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Web',
                'learning_objectives' => [],
                'skills_gained' => ['HTTPS', 'SSL/TLS', 'Security'],
                'tags' => ['https', 'ssl', 'security'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=S2iBR2ZlZf0', 'title' => 'PowerCert - SSL/TLS Explained', 'type' => 'video'],
                    ['url' => 'https://cloudflare.com/learning/ssl/what-is-https/', 'title' => 'HTTPS Explained - CloudFlare', 'type' => 'article'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Glossary/HTTPS', 'title' => 'HTTPS - MDN', 'type' => 'article'],
                    ['url' => '#', 'title' => 'High Performance Browser Networking (Chapters 9-11)', 'type' => 'book'],
                ],
            ],
            // Day 16: DNS & Domain Names (8 min actual)
            [
                'title' => 'DNS & Domain Names',
                'description' => 'Understand DNS system, domain name resolution, DNS records, and how domains work.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'Networking',
                'learning_objectives' => [],
                'skills_gained' => ['DNS', 'Domain Names', 'Networking'],
                'tags' => ['dns', 'domains', 'networking'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=mpQZVYPuDGU', 'title' => 'PowerCert - DNS Explained', 'type' => 'video'],
                    ['url' => 'https://cloudflare.com/learning/dns/what-is-dns/', 'title' => 'What is DNS? - CloudFlare', 'type' => 'article'],
                    ['url' => 'https://digitalocean.com/community/tutorials/an-introduction-to-dns-terminology-components-and-concepts', 'title' => 'DNS Basics - DigitalOcean', 'type' => 'article'],
                    ['url' => '#', 'title' => 'DNS and BIND O\'Reilly (Chapters 1-4)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Computer Networking by Kurose (Chapter 2.4)', 'type' => 'book'],
                ],
            ],
            // Day 17: Browsers & Client-Server Model (32 min actual)
            [
                'title' => 'Browsers & Client-Server Model',
                'description' => 'Learn how browsers work, rendering engines, client-server architecture, and web application flow.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'Web',
                'learning_objectives' => [],
                'skills_gained' => ['Browsers', 'Client-Server', 'Web Architecture'],
                'tags' => ['browsers', 'client-server', 'web'],
                'success_criteria' => [],
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=WjDrMKZWCt0', 'title' => 'Academind - How Browsers Work', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/Performance/How_browsers_work', 'title' => 'Populating the page: how browsers work - MDN', 'type' => 'article'],
                    ['url' => 'https://geeksforgeeks.org/client-server-model/', 'title' => 'Client-Server Model - GeeksforGeeks', 'type' => 'article'],
                    ['url' => '#', 'title' => 'High Performance Browser Networking (Chapters 1-4)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Web Development with Node and Express (Chapter 1)', 'type' => 'book'],
                ],
            ],
        ];

        $dayNumber = 1;
        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, [
                'roadmap_id' => $roadmap->id,
                'day_number' => $dayNumber++,
                'order' => 1,
                'difficulty_level' => 'beginner',
                'has_code_submission' => $taskData['has_code_submission'] ?? false,
                'has_quality_rating' => false,
            ]));
        }
    }
}
