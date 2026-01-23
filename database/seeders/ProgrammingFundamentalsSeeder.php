<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;

class ProgrammingFundamentalsSeeder extends Seeder
{
    /**
     * Seed the 5 programming fundamentals roadmaps by creating tasks directly
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            $this->command->error('Admin user not found. Please run UserSeeder first.');
            return;
        }

        // Check if already seeded
        if (Roadmap::where('slug', 'think-like-a-programmer')->exists()) {
            $this->command->info('Programming Fundamentals roadmaps already exist. Skipping...');
            return;
        }

        $this->command->info('Creating 5 Programming Fundamentals roadmaps with tasks...');

        // 1. Think Like a Programmer (Days 1-20)
        $roadmap1 = Roadmap::create([
            'title' => 'Think Like a Programmer',
            'slug' => 'think-like-a-programmer',
            'description' => 'Master problem-solving, computational thinking, and modern AI tools before writing your first line of code. Perfect for absolute beginners who want to understand how programmers think.',
            'creator_id' => $admin->id,
            'duration_days' => 20,
            'difficulty_level' => 'beginner',
            'is_published' => true,
            'is_featured' => true,
            'order' => 1,
            'prerequisite_roadmap_id' => null,
        ]);

        // 2. Programming Basics (Days 21-44)
        $roadmap2 = Roadmap::create([
            'title' => 'Programming Basics',
            'slug' => 'programming-basics',
            'description' => 'Learn fundamental programming syntax, data structures, and basic algorithms. Master variables, functions, arrays, and more through hands-on exercises.',
            'creator_id' => $admin->id,
            'duration_days' => 24,
            'difficulty_level' => 'beginner',
            'is_published' => true,
            'is_featured' => false,
            'order' => 2,
            'prerequisite_roadmap_id' => $roadmap1->id,
        ]);

        // 3. Object-Oriented Programming (Days 45-55)
        $roadmap3 = Roadmap::create([
            'title' => 'Object-Oriented Programming',
            'slug' => 'object-oriented-programming',
            'description' => 'Dive deep into OOP concepts: classes, objects, encapsulation, inheritance, and polymorphism. Build real-world class hierarchies and understand modern software design.',
            'creator_id' => $admin->id,
            'duration_days' => 11,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 3,
            'prerequisite_roadmap_id' => $roadmap2->id,
        ]);

        // 4. Debugging & Code Quality (Days 56-69)
        $roadmap4 = Roadmap::create([
            'title' => 'Debugging & Code Quality',
            'slug' => 'debugging-code-quality',
            'description' => 'Master essential debugging techniques and code quality practices. Learn to find bugs quickly, write clean code, and conduct effective code reviews like a professional developer.',
            'creator_id' => $admin->id,
            'duration_days' => 14,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 4,
            'prerequisite_roadmap_id' => $roadmap2->id,
        ]);

        // 5. Software Development Essentials (Days 70-85)
        $roadmap5 = Roadmap::create([
            'title' => 'Software Development Essentials',
            'slug' => 'software-development-essentials',
            'description' => 'Learn the tools and concepts real developers use daily: version control, APIs, databases, networking, and system design. Bridge the gap between learning to code and professional development.',
            'creator_id' => $admin->id,
            'duration_days' => 16,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 5,
            'prerequisite_roadmap_id' => $roadmap2->id,
        ]);

        // Create all tasks
        $this->createAllTasks($roadmap1, $roadmap2, $roadmap3, $roadmap4, $roadmap5);

        $this->command->info('✓ Think Like a Programmer (20 days, 20 tasks)');
        $this->command->info('✓ Programming Basics (24 days, 24 tasks)');
        $this->command->info('✓ Object-Oriented Programming (11 days, 11 tasks)');
        $this->command->info('✓ Debugging & Code Quality (14 days, 14 tasks)');
        $this->command->info('✓ Software Development Essentials (16 days, 16 tasks)');
        $this->command->info('✓ Successfully created 5 Programming Fundamentals roadmaps');
    }

    private function createAllTasks($roadmap1, $roadmap2, $roadmap3, $roadmap4, $roadmap5): void
    {

        // PART 1: MINDSET & PROBLEM SOLVING (Days 1-8)

        // Day 1: Introduction to Programming
        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'What is Programming?',
            'description' => 'Understand what programming is, how computers work, and why learning to code matters. Explore different programming paradigms and applications.',
            'day_number' => 1,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Computational Thinking',
            'order' => 1,
            'resources_links' => [
                ['title' => 'FreeCodeCamp - What is Programming', 'url' => 'https://www.freecodecamp.org/news/what-is-programming/'],
                ['title' => 'Eloquent JavaScript - Introduction', 'url' => 'https://eloquentjavascript.net/00_intro.html'],
                ['title' => 'Programming Basics Video', 'url' => 'https://www.youtube.com/watch?v=zOjov-2OZ0E'],
                ['title' => 'Eloquent JavaScript by Marijn Haverbeke (free online)', 'url' => 'https://eloquentjavascript.net/'],
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
            // Enhanced metadata
            'learning_objectives' => [
                'Understand what programming is and why it matters',
                'Identify different programming paradigms',
                'Recognize where programming is used in daily life'
            ],
            'skills_gained' => [
                'Computational thinking',
                'Problem analysis',
                'Programming concepts overview'
            ],
            'success_criteria' => [
                'Can explain what programming is in your own words',
                'Understand the difference between compiled and interpreted languages',
                'Identify 3 real-world applications of programming'
            ],
            'common_mistakes' => "Don't rush through the reading material. Take notes and try to understand concepts deeply rather than memorizing facts. If stuck for more than 30 minutes, review resources again.",
            'quick_tips' => "Take breaks every 25-30 minutes to stay focused. Take notes in your own words - this helps solidify understanding. Check the resource ratings to see which materials other students found most helpful.",
        ]);

        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'The Programming Mindset',
            'description' => 'Learn how programmers think: breaking down problems, pattern recognition, abstraction, and algorithmic thinking.',
            'day_number' => 2,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Computational Thinking',
            'order' => 2,
            'resources_links' => [
                ['title' => 'FreeCodeCamp - How to Think Like a Programmer', 'url' => 'https://www.freecodecamp.org/news/how-to-think-like-a-programmer-lessons-in-problem-solving-d1d8bf1de7d2/'],
                ['title' => 'Problem Solving Video', 'url' => 'https://www.youtube.com/watch?v=azcrPFhaY9k'],
                ['title' => 'Thinking Like a Programmer Video', 'url' => 'https://www.youtube.com/watch?v=rWMuEIcdJP4'],
                ['title' => 'Think Like a Programmer by V. Anton Spraul - Chapter 1', 'url' => 'https://www.amazon.com/Think-Like-Programmer-Introduction-Creative/dp/1593274246'],
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Problem Decomposition Exercise',
            'description' => 'Practice breaking down a complex daily task (like making breakfast) into detailed step-by-step instructions a computer could follow. 💡 Book: "How to Think Like a Computer Scientist" - Chapter on Problem Solving.',
            'day_number' => 3,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Problem Solving',
            'order' => 3,
            'resources_links' => [
                'https://www.freecodecamp.org/news/how-to-think-like-a-programmer-lessons-in-problem-solving-d1d8bf1de7d2/',
                'https://runestone.academy/runestone/books/published/thinkcspy/GeneralIntro/toctree.html',
                'https://www.youtube.com/watch?v=v5Qeq7FrMyA',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 2: Logical Thinking
        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Computational Thinking Basics',
            'description' => 'Master the four pillars of computational thinking: decomposition, pattern recognition, abstraction, and algorithm design.',
            'day_number' => 4,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Computational Thinking',
            'order' => 4,
            'resources_links' => [
                'https://www.bbc.co.uk/bitesize/guides/zp92mp3/revision/1',
                'https://edu.google.com/',
                'https://www.youtube.com/watch?v=qBCW6KPy6Vg',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Algorithm Design Fundamentals',
            'description' => 'Learn to write pseudocode to express algorithms clearly before coding. Practice with simple algorithms like finding max number, sorting, searching. 💡 Book: "Introduction to Algorithms" (CLRS) - Chapter 1 for concepts.',
            'day_number' => 5,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Problem Solving',
            'order' => 5,
            'resources_links' => [
                'https://www.khanacademy.org/computing/computer-science/algorithms/intro-to-algorithms/a/a-guessing-game',
                'https://visualgo.net/en',
                'https://www.youtube.com/watch?v=8hly31xKli0',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Flowchart Practice',
            'description' => 'Create flowcharts for common processes (ATM withdrawal, login system, simple calculator) using standard flowchart symbols.',
            'day_number' => 6,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Problem Solving',
            'order' => 6,
            'resources_links' => [
                'https://www.lucidchart.com/pages/what-is-a-flowchart-tutorial',
                'https://excalidraw.com/',
                'https://www.youtube.com/watch?v=SWRDqTx8d4k',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 3: Problem-Solving Strategies
        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Problem-Solving Methodologies',
            'description' => 'Study proven problem-solving techniques: understand the problem, devise a plan, carry out the plan, review/reflect.',
            'day_number' => 7,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Problem Solving',
            'order' => 7,
            'resources_links' => [
                'https://www.freecodecamp.org/news/how-to-solve-coding-problems/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Breaking Down Complex Problems',
            'description' => 'Take a complex problem (design a library management system) and break it into smaller, manageable sub-problems. Document your approach.',
            'day_number' => 8,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Problem Solving',
            'order' => 8,
            'resources_links' => [
                'https://www.theodinproject.com/lessons/foundations-problem-solving',
                'https://www.youtube.com/watch?v=UFc-RPbq8kg',
                'https://www.youtube.com/watch?v=7EmboKQH8lM',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 4: From Problem to Solution
        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Writing Step-by-Step Solutions',
            'description' => 'Practice writing detailed step-by-step solutions (algorithms) for everyday problems: sort a deck of cards, find a word in dictionary, calculate average.',
            'day_number' => 9,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Problem Solving',
            'order' => 9,
            'resources_links' => [
                'https://www.khanacademy.org/computing/computer-science/algorithms',
                'https://visualgo.net/en',
                'https://www.youtube.com/watch?v=8hly31xKli0',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Testing Your Logic',
            'description' => 'Learn to trace through algorithms step-by-step with sample inputs. Practice finding logical errors in given pseudocode.',
            'day_number' => 10,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Problem Solving',
            'order' => 10,
            'resources_links' => [
                'https://pythontutor.com/',
                'https://www.youtube.com/watch?v=AX7eH0OUzII',
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/Scripting/What_went_wrong',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 5: Practice Integration
        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Design a Solution for Real Problem',
            'description' => 'Choose a real-world problem (e.g., student grade calculator, to-do list manager) and create complete documentation: problem statement, flowchart, pseudocode, and test cases.',
            'day_number' => 11,
            'estimated_time_minutes' => 240,
            'task_type' => 'project',
            'category' => 'Problem Solving',
            'order' => 11,
            'resources_links' => [
                'https://excalidraw.com/',
                'https://www.writethedocs.org/guide/writing/beginners-guide-to-docs/',
                'https://www.youtube.com/watch?v=QCif0woH60I',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 6: Introduction to AI in Development
        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'AI Tools for Programmers',
            'description' => 'Overview of AI coding assistants (ChatGPT, GitHub Copilot, Claude) and how they can accelerate learning and development.',
            'day_number' => 12,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'AI Tools',
            'order' => 12,
            'resources_links' => [
                'https://docs.github.com/en/copilot',
                'https://github.blog/developer-skills/github/how-to-use-github-copilot-in-your-ide-tips-tricks-and-best-practices/',
                'https://www.youtube.com/watch?v=JTxsNm9IdYU',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'How to Use AI Effectively',
            'description' => 'Learn best practices: when to use AI, how to verify outputs, iterative refinement, and maintaining your learning process.',
            'day_number' => 13,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'AI Tools',
            'order' => 13,
            'resources_links' => [
                'https://www.coursera.org/articles/how-to-use-chatgpt',
                'https://austinhenley.com/blog/learningwithai.html',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'AI-Assisted Problem Solving',
            'description' => 'Use AI to help break down a problem, generate pseudocode, and explain concepts. Compare AI output with your own solution.',
            'day_number' => 14,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'AI Tools',
            'order' => 14,
            'resources_links' => [
                'https://platform.openai.com/docs/quickstart',
                'https://platform.claude.com/docs/en/intro',
                'https://www.youtube.com/watch?v=jC4v5AS4RIM',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 7: Best Practices with AI
        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Prompt Engineering Basics',
            'description' => 'Learn to write effective prompts: be specific, provide context, ask for explanations, request step-by-step solutions.',
            'day_number' => 15,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'AI Tools',
            'order' => 15,
            'resources_links' => [
                'https://www.promptingguide.ai/',
                'https://learnprompting.org/',
                'https://www.youtube.com/watch?v=mBYu5NoXBcs',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Getting Better AI Responses',
            'description' => 'Practice writing progressively better prompts for the same problem. Document what makes a good prompt versus a poor one.',
            'day_number' => 16,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'AI Tools',
            'order' => 16,
            'resources_links' => [
                'https://learnprompting.org/',
                'https://www.promptingguide.ai/',
                'https://www.deeplearning.ai/short-courses/chatgpt-prompt-engineering-for-developers/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Reviewing AI-Generated Code',
            'description' => 'Get AI to generate pseudocode for a problem, then critically review it: find errors, suggest improvements, understand trade-offs.',
            'day_number' => 17,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'AI Tools',
            'order' => 17,
            'resources_links' => [
                'https://google.github.io/eng-practices/review/',
                'https://google.github.io/eng-practices/review/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 8: AI Limitations and Ethics
        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'When NOT to Use AI',
            'description' => 'Understand AI limitations: learning fundamentals, debugging skills, critical thinking, academic integrity, and security concerns.',
            'day_number' => 18,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'AI Tools',
            'order' => 18,
            'resources_links' => [
                'https://www.freecodecamp.org/news/how-to-learn-programming/',
                'https://austinhenley.com/blog/learningwithai.html',
                'https://stackoverflow.blog/2023/12/29/the-hardest-part-of-building-software-is-not-coding-its-requirements/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'AI vs Manual Problem Solving',
            'description' => 'Solve the same problem twice: once with AI assistance, once entirely on your own. Reflect on the differences in learning and understanding.',
            'day_number' => 19,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'AI Tools',
            'order' => 19,
            'resources_links' => [
                'https://www.freecodecamp.org/news/how-to-learn-programming/',
                'https://austinhenley.com/blog/learningwithai.html',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // PART 2: PROGRAMMING FOUNDATIONS (Days 9-18)

        // Day 9: Languages as Tools
        Task::create([
            'roadmap_id' => $roadmap1->id,
            'title' => 'Programming Languages Overview',
            'description' => 'Survey of programming languages: Python, JavaScript, Java, C++. Understand that languages are tools, concepts transfer across them. 💡 Book: "Code: The Hidden Language" by Charles Petzold - great introduction.',
            'day_number' => 20,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Programming Languages',
            'order' => 20,
            'resources_links' => [
                'https://www.codecademy.com/resources/blog/programming-languages/',
                'https://roadmap.sh/computer-science',
                'https://www.youtube.com/watch?v=2lVDktWK-pc',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Compiled vs Interpreted Languages',
            'description' => 'Learn the difference between compiled and interpreted languages, execution models, and when to use each type.',
            'day_number' => 1,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Programming Languages',
            'order' => 21,
            'resources_links' => [
                'https://www.freecodecamp.org/news/compiled-versus-interpreted-languages/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        // Day 10: Basic Syntax Concepts
        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Common Syntax Patterns',
            'description' => 'Explore syntax elements common across languages: statements, expressions, blocks, comments, and code organization. 💡 Book: "Eloquent JavaScript" Chapter 2 - Program Structure.',
            'day_number' => 2,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Syntax Basics',
            'order' => 22,
            'resources_links' => [
                'https://javascript.info/structure',
                'https://eloquentjavascript.net/02_program_structure.html',
                'https://www.youtube.com/watch?v=GM6dQBmc-Xg',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Variables and Data Types',
            'description' => 'Practice declaring variables and working with primitive data types: numbers, strings, booleans. Write pseudocode examples. 💡 Book: "Eloquent JavaScript" Chapter 1 - Values, Types, and Operators.',
            'day_number' => 3,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Syntax Basics',
            'order' => 23,
            'resources_links' => [
                'https://javascript.info/variables',
                'https://eloquentjavascript.net/01_values.html',
                'https://www.youtube.com/watch?v=fju9ii8YsGs',
                'https://roadmap.sh/javascript',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Operators and Expressions',
            'description' => 'Learn arithmetic, comparison, and logical operators. Practice building complex expressions and understanding operator precedence.',
            'day_number' => 4,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Syntax Basics',
            'order' => 24,
            'resources_links' => [
                'https://javascript.info/operators',
                'https://eloquentjavascript.net/01_values.html',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 11: Control Structures
        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Conditionals and Loops',
            'description' => 'Master control flow: if/else statements, switch/case, while loops, for loops, and loop control (break/continue).',
            'day_number' => 5,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Syntax Basics',
            'order' => 25,
            'resources_links' => [
                'https://javascript.info/ifelse',
                'https://javascript.info/while-for',
                'https://eloquentjavascript.net/02_program_structure.html',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'If-Else Practice',
            'description' => 'Write algorithms using conditionals: grade calculator, leap year checker, number sign identifier, max of three numbers.',
            'day_number' => 6,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Syntax Basics',
            'order' => 26,
            'resources_links' => [
                'https://exercism.org/tracks/javascript/exercises',
                'https://www.codewars.com/kata/search/javascript?q=&tags=Fundamentals',
                'https://www.youtube.com/watch?v=IsG4Xd6LlsM',
                'https://roadmap.sh/javascript',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Loop Fundamentals',
            'description' => 'Practice loops: print numbers 1-100, calculate factorial, find sum of digits, generate multiplication table, FizzBuzz problem.',
            'day_number' => 7,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Syntax Basics',
            'order' => 27,
            'resources_links' => [
                'https://exercism.org/tracks/javascript/exercises',
                'https://www.codewars.com/kata/search/javascript?q=loop',
                'https://www.youtube.com/watch?v=Kn06785pkJg',
                'https://roadmap.sh/javascript',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 12: Functions Basics
        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'What are Functions?',
            'description' => 'Understand functions: code reusability, abstraction, modularity. Learn function declaration, calling, and scope. 💡 Book: "Eloquent JavaScript" Chapter 3 - Functions.',
            'day_number' => 8,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Syntax Basics',
            'order' => 28,
            'resources_links' => [
                'https://javascript.info/function-basics',
                'https://eloquentjavascript.net/03_functions.html',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Creating Simple Functions',
            'description' => 'Write basic functions: calculate area of shapes, convert temperature, check if number is prime, reverse a string.',
            'day_number' => 9,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Syntax Basics',
            'order' => 29,
            'resources_links' => [
                'https://exercism.org/tracks/javascript/exercises',
                'https://www.youtube.com/watch?v=gigtS_5KOqo',
                'https://roadmap.sh/javascript',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Function Parameters and Return Values',
            'description' => 'Master parameters (required, optional, default values) and return values. Practice functions that call other functions.',
            'day_number' => 10,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Syntax Basics',
            'order' => 30,
            'resources_links' => [
                'https://javascript.info/function-basics',
                'https://www.youtube.com/watch?v=N8ap4k_1QEQ',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 13: Arrays and Lists
        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Introduction to Data Structures',
            'description' => 'Learn why data structures matter: organizing data for efficient access and modification. Overview of common data structures. 💡 Book: "Grokking Algorithms" by Aditya Bhargava - visual and beginner-friendly.',
            'day_number' => 11,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Data Structures',
            'order' => 31,
            'resources_links' => [
                'https://www.geeksforgeeks.org/dsa/introduction-to-data-structures/',
                'https://visualgo.net/en/list',
                'https://www.youtube.com/watch?v=bum_19loj9A',
                'https://roadmap.sh/datastructures-and-algorithms',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Working with Arrays',
            'description' => 'Practice array fundamentals: creation, indexing, length, iterating through elements, basic array operations. 💡 Book: "Eloquent JavaScript" Chapter 4 - Data Structures: Objects and Arrays.',
            'day_number' => 12,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Data Structures',
            'order' => 32,
            'resources_links' => [
                'https://javascript.info/array',
                'https://eloquentjavascript.net/04_data.html',
                'https://www.youtube.com/watch?v=7W4pQQ20nJg',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Array Operations',
            'description' => 'Master array methods: add/remove elements (push, pop, shift, unshift), slice, splice, concat. Find min/max, calculate average.',
            'day_number' => 13,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Data Structures',
            'order' => 33,
            'resources_links' => [
                'https://javascript.info/array-methods',
                'https://eloquentjavascript.net/04_data.html',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 14: Strings
        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'String Manipulation',
            'description' => 'Learn string as character array: accessing characters, length, immutability, common string operations across languages.',
            'day_number' => 14,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Data Structures',
            'order' => 34,
            'resources_links' => [
                'https://javascript.info/string',
                'https://eloquentjavascript.net/01_values.html',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'String Operations Practice',
            'description' => 'Practice string methods: concatenation, substring, indexOf, split, join, replace, toUpperCase/toLowerCase, trim. Check palindrome, count vowels.',
            'day_number' => 15,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Data Structures',
            'order' => 35,
            'resources_links' => [
                'https://exercism.org/tracks/javascript/exercises',
                'https://www.codewars.com/kata/search/javascript?q=string',
                'https://www.youtube.com/watch?v=EJy7f0YPgi8',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 15: Objects and Dictionaries
        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Key-Value Data Structures',
            'description' => 'Understand objects/dictionaries/maps: storing related data with keys, accessing values, when to use vs arrays.',
            'day_number' => 16,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Data Structures',
            'order' => 36,
            'resources_links' => [
                'https://javascript.info/object',
                'https://eloquentjavascript.net/04_data.html',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Object Creation and Access',
            'description' => 'Practice creating objects, accessing properties (dot notation, bracket notation), adding/updating/deleting properties, iterating over keys.',
            'day_number' => 17,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Data Structures',
            'order' => 37,
            'resources_links' => [
                'https://javascript.info/object',
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Working_with_objects',
                'https://www.youtube.com/watch?v=Gp5nnerXETg',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 16: Nested Structures
        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Working with Complex Data',
            'description' => 'Practice nested data structures: arrays of objects, objects with array properties, multi-dimensional arrays. Access deeply nested values.',
            'day_number' => 18,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Data Structures',
            'order' => 38,
            'resources_links' => [
                'https://javascript.info/object',
                'https://www.youtube.com/watch?v=t2CEgPsws3U',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Data Structure Selection',
            'description' => 'Given various problems, decide which data structure is best (array, object, nested structure) and justify your choice.',
            'day_number' => 19,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Data Structures',
            'order' => 39,
            'resources_links' => [
                'https://www.geeksforgeeks.org/dsa/dsa-tutorial-learn-data-structures-and-algorithms/',
                'https://visualgo.net/en',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 17: Algorithms Basics
        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Introduction to Algorithms',
            'description' => 'What makes a good algorithm: correctness, efficiency, clarity. Big O notation introduction - understanding time and space complexity. 💡 Book: "Grokking Algorithms" Chapter 1.',
            'day_number' => 20,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Algorithms',
            'order' => 40,
            'resources_links' => [
                'https://www.freecodecamp.org/news/introduction-to-algorithms-with-javascript-examples/',
                'https://www.khanacademy.org/computing/computer-science/algorithms',
                'https://visualgo.net/en',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Searching Algorithms',
            'description' => 'Implement linear search and binary search. Compare their efficiency. Understand when to use each.',
            'day_number' => 21,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Algorithms',
            'order' => 41,
            'resources_links' => [
                'https://www.freecodecamp.org/news/search-algorithms-linear-and-binary-search-explained/',
                'https://visualgo.net/en/sorting',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 18: Sorting and Efficiency
        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Algorithm Efficiency Basics',
            'description' => 'Deep dive into Big O notation: O(1), O(n), O(n²), O(log n). Learn to analyze algorithm efficiency.',
            'day_number' => 22,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Algorithms',
            'order' => 42,
            'resources_links' => [
                'https://www.freecodecamp.org/news/big-o-notation-why-it-matters-and-why-it-doesnt-1674cfa8a23c/',
                'https://www.youtube.com/watch?v=D6xkbGLQesk',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Sorting Practice',
            'description' => 'Implement bubble sort and selection sort. Analyze their time complexity. Compare with built-in sort methods.',
            'day_number' => 23,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Algorithms',
            'order' => 43,
            'resources_links' => [
                'https://www.freecodecamp.org/news/sorting-algorithms-explained-with-examples-in-python-java-and-c/',
                'https://visualgo.net/en/sorting',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap2->id,
            'title' => 'Data Processing Challenge',
            'description' => 'Build a student record system: store students with grades, search by name, sort by grade, calculate class average, find top performers.',
            'day_number' => 24,
            'estimated_time_minutes' => 240,
            'task_type' => 'project',
            'category' => 'Data Structures',
            'order' => 44,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Extensions/Server-side/Express_Nodejs/forms',
                'https://www.youtube.com/watch?v=7nafaH9SddU',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // PART 3: ADVANCED CONCEPTS (Days 19-29)

        // Day 19: OOP Introduction
        Task::create([
            'roadmap_id' => $roadmap3->id,
            'title' => 'What is Object-Oriented Programming?',
            'description' => 'Introduction to OOP: modeling real-world entities, combining data and behavior, benefits of OOP (modularity, reusability, maintainability). 💡 Book: "Head First Object-Oriented Analysis & Design" - great visual introduction.',
            'day_number' => 1,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'OOP Concepts',
            'order' => 45,
            'resources_links' => [
                'https://www.freecodecamp.org/news/object-oriented-programming-concepts-21bb035f7260/',
                'https://www.youtube.com/watch?v=pTB0EiLXUC8',
                'https://roadmap.sh/computer-science',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap3->id,
            'title' => 'Classes and Objects',
            'description' => 'Learn the difference between classes (blueprints) and objects (instances). Understand constructors and instance variables. 💡 Book: "Eloquent JavaScript" Chapter 6 - The Secret Life of Objects.',
            'day_number' => 2,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'OOP Concepts',
            'order' => 46,
            'resources_links' => [
                'https://javascript.info/class',
                'https://eloquentjavascript.net/06_object.html',
                'https://www.youtube.com/watch?v=pTB0EiLXUC8',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        // Day 20: Classes and Instances
        Task::create([
            'roadmap_id' => $roadmap3->id,
            'title' => 'Creating Your First Class',
            'description' => 'Design and implement simple classes: Car (make, model, year, start/stop), Book (title, author, pages, read status).',
            'day_number' => 3,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'OOP Concepts',
            'order' => 47,
            'resources_links' => [
                'https://javascript.info/class',
                'https://eloquentjavascript.net/06_object.html',
                'https://www.youtube.com/watch?v=Z1RJmh_OqeA',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap3->id,
            'title' => 'Object Properties and Methods',
            'description' => 'Practice creating objects from classes, accessing properties, calling methods. Create multiple instances and see how they differ.',
            'day_number' => 4,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'OOP Concepts',
            'order' => 48,
            'resources_links' => [
                'https://javascript.info/class',
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Classes',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 21: Encapsulation
        Task::create([
            'roadmap_id' => $roadmap3->id,
            'title' => 'Encapsulation Principles',
            'description' => 'Learn data hiding: public vs private members, getters and setters, why encapsulation matters for code maintainability.',
            'day_number' => 5,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'OOP Concepts',
            'order' => 49,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Working_with_objects#defining_getters_and_setters',
                'https://javascript.info/private-protected-properties-methods',
                'https://www.youtube.com/watch?v=0jjNjXcYmAU',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap3->id,
            'title' => 'Public vs Private Members',
            'description' => 'Implement a BankAccount class with private balance, public deposit/withdraw methods, validation, and proper encapsulation.',
            'day_number' => 6,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'OOP Concepts',
            'order' => 50,
            'resources_links' => [
                'https://javascript.info/private-protected-properties-methods',
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Classes/Private_elements',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 22: Inheritance
        Task::create([
            'roadmap_id' => $roadmap3->id,
            'title' => 'Inheritance Basics',
            'description' => 'Understanding inheritance: parent-child relationships, code reuse, "is-a" relationship, super/base class concept.',
            'day_number' => 7,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'OOP Concepts',
            'order' => 51,
            'resources_links' => [
                'https://javascript.info/class-inheritance',
                'https://eloquentjavascript.net/06_object.html',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap3->id,
            'title' => 'Creating Child Classes',
            'description' => 'Create an Animal base class, then Dog and Cat child classes that inherit and extend Animal\'s properties and methods.',
            'day_number' => 8,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'OOP Concepts',
            'order' => 52,
            'resources_links' => [
                'https://javascript.info/class-inheritance',
                'https://www.youtube.com/watch?v=BSVKUk58K6U',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 23: Polymorphism
        Task::create([
            'roadmap_id' => $roadmap3->id,
            'title' => 'Polymorphism Explained',
            'description' => 'Learn polymorphism: same interface, different implementations. Method overriding and how it enables flexible code.',
            'day_number' => 9,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'OOP Concepts',
            'order' => 53,
            'resources_links' => [
                'https://javascript.info/class-inheritance',
                'https://javascript.info/class-inheritance',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap3->id,
            'title' => 'Method Overriding Practice',
            'description' => 'Create Shape base class with calculateArea() method. Override in Circle, Rectangle, Triangle child classes with specific implementations.',
            'day_number' => 10,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'OOP Concepts',
            'order' => 54,
            'resources_links' => [
                'https://javascript.info/class-inheritance',
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Inheritance_and_the_prototype_chain',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap3->id,
            'title' => 'Build a Class Hierarchy',
            'description' => 'Design a complete OOP system for a university: Person → Student/Professor, Course, Enrollment. Include all OOP principles learned. 💡 Reference: Design patterns from refactoring.guru for ideas.',
            'day_number' => 11,
            'estimated_time_minutes' => 240,
            'task_type' => 'project',
            'category' => 'OOP Concepts',
            'order' => 55,
            'resources_links' => [
                'https://refactoring.guru/design-patterns',
                'https://www.youtube.com/watch?v=Ej_02ICOIgs',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 24: Debugging Mindset
        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'Introduction to Debugging',
            'description' => 'What is debugging? The debugging mindset: reproduce, isolate, fix, verify. Debugging as a core programming skill.',
            'day_number' => 1,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Debugging',
            'order' => 56,
            'resources_links' => [
                'https://www.freecodecamp.org/news/what-is-debugging-how-to-debug-code/',
                'https://www.youtube.com/watch?v=ltzyNx5TX3w',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'Common Error Types',
            'description' => 'Learn error categories: syntax errors, runtime errors, logical errors. How to identify each type and strategies to fix them.',
            'day_number' => 2,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Debugging',
            'order' => 57,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Errors',
                'https://javascript.info/debugging-chrome',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'Reading Error Messages',
            'description' => 'Practice interpreting error messages: stack traces, line numbers, error types. Given buggy code, identify and fix errors.',
            'day_number' => 3,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Debugging',
            'order' => 58,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Errors',
                'https://javascript.info/debugging-chrome',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 25: Debugging Techniques
        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'Debugging Strategies',
            'description' => 'Master debugging techniques: print statements, rubber duck debugging, binary search debugging, using debuggers. 💡 Read Julia Evans\' debugging guide for practical tips.',
            'day_number' => 4,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Debugging',
            'order' => 59,
            'resources_links' => [
                'https://developer.chrome.com/docs/devtools/javascript/',
                'https://jvns.ca/blog/2019/06/23/a-few-debugging-resources/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'Using Print Statements',
            'description' => 'Debug provided buggy programs using console.log/print statements. Track variable values, execution flow, and identify where things go wrong.',
            'day_number' => 5,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Debugging',
            'order' => 60,
            'resources_links' => [
                'https://developer.chrome.com/docs/devtools/console/',
                'https://www.youtube.com/watch?v=KER_yDCqWqw',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'Step-by-Step Debugging',
            'description' => 'Use browser DevTools or debugging tools to step through code, set breakpoints, inspect variables, and watch expressions.',
            'day_number' => 6,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Debugging',
            'order' => 61,
            'resources_links' => [
                'https://developer.chrome.com/docs/devtools/javascript/',
                'https://javascript.info/debugging-chrome',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 26: Advanced Debugging
        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'Finding Logic Errors',
            'description' => 'Debug programs with subtle logic errors (off-by-one, incorrect conditions, wrong formulas). No syntax errors - pure logic problems.',
            'day_number' => 7,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Debugging',
            'order' => 62,
            'resources_links' => [
                'https://pythontutor.com/javascript.html',
                'https://www.youtube.com/watch?v=H0XScE08hy8',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'Debugging Practice Challenges',
            'description' => 'Series of intentionally buggy programs to debug: factorial calculator, palindrome checker, student grade system, shopping cart.',
            'day_number' => 8,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Debugging',
            'order' => 63,
            'resources_links' => [
                'https://exercism.org/tracks/javascript/exercises',
                'https://jschallenger.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 27: Code Quality
        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'What Makes Good Code?',
            'description' => 'Learn code quality principles: readability, maintainability, efficiency, testability. The importance of writing code for humans. 💡 Book: "Clean Code" by Robert C. Martin - industry standard reference.',
            'day_number' => 9,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Code Quality',
            'order' => 64,
            'resources_links' => [
                'https://www.freecodecamp.org/news/clean-coding-for-beginners/',
                'https://github.com/ryanmcdermott/clean-code-javascript',
                'https://www.youtube.com/watch?v=Bf7vDBBOBUA',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'Code Style and Conventions',
            'description' => 'Study naming conventions, code formatting, commenting best practices, and style guides (Airbnb JavaScript, Google Style Guide).',
            'day_number' => 10,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Code Quality',
            'order' => 65,
            'resources_links' => [
                'https://google.github.io/styleguide/jsguide.html',
                'https://github.com/airbnb/javascript',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'Refactoring Practice',
            'description' => 'Improve poorly written code: rename variables for clarity, extract functions, remove duplication, add comments where needed. 💡 Book: "Refactoring" by Martin Fowler - comprehensive guide.',
            'day_number' => 11,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Code Quality',
            'order' => 66,
            'resources_links' => [
                'https://refactoring.guru/refactoring',
                'https://sourcemaking.com/refactoring',
                'https://www.youtube.com/watch?v=DC471a9qrU4',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 28: Code Review
        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'How to Review Code',
            'description' => 'Learn code review process: what to look for (bugs, style, logic, performance), how to give constructive feedback.',
            'day_number' => 12,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Code Quality',
            'order' => 67,
            'resources_links' => [
                'https://google.github.io/eng-practices/review/',
                'https://google.github.io/eng-practices/review/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'Peer Review Exercise',
            'description' => 'Review sample code submissions: identify issues, suggest improvements, write constructive feedback. Practice being both reviewer and reviewee.',
            'day_number' => 13,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Code Quality',
            'order' => 68,
            'resources_links' => [
                'https://google.github.io/eng-practices/review/',
                'https://github.com/features/code-review',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap4->id,
            'title' => 'Self-Review Checklist',
            'description' => 'Create and use a code review checklist. Review your own previous code and identify areas for improvement.',
            'day_number' => 14,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Code Quality',
            'order' => 69,
            'resources_links' => [
                'https://google.github.io/eng-practices/review/reviewer/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 29: Development Tools
        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'Essential Programming Tools',
            'description' => 'Overview of development tools: IDEs vs text editors, version control, package managers, linters, formatters. 💡 Check out MIT\'s "Missing Semester" course for comprehensive tool education.',
            'day_number' => 1,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Development Tools',
            'order' => 70,
            'resources_links' => [
                'https://missing.csail.mit.edu/',
                'https://code.visualstudio.com/docs',
                'https://www.youtube.com/watch?v=dU1xS07N-FA',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'IDE and Editor Setup',
            'description' => 'Set up a development environment: install VS Code, configure extensions, learn keyboard shortcuts, customize settings for productivity.',
            'day_number' => 2,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Development Tools',
            'order' => 71,
            'resources_links' => [
                'https://code.visualstudio.com/docs',
                'https://vscodecandothat.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'Version Control Basics (Git Preview)',
            'description' => 'Introduction to version control concepts: tracking changes, commits, branches. Basic Git commands overview (detailed Git in next roadmap). 💡 Book: "Pro Git" (free online) - comprehensive Git guide.',
            'day_number' => 3,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Development Tools',
            'order' => 72,
            'resources_links' => [
                'https://git-scm.com/book/en/v2',
                'https://learngitbranching.js.org/',
                'https://www.youtube.com/watch?v=RGOj5yH7evk',
                'https://roadmap.sh/git-github',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // PART 4: SYSTEMS OVERVIEW (Days 30-35)

        // Day 30: Networking Basics
        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'How the Internet Works',
            'description' => 'Understand the internet: IP addresses, DNS, protocols (HTTP/HTTPS), how data travels across networks.',
            'day_number' => 4,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Networking',
            'order' => 73,
            'resources_links' => [
                'https://www.freecodecamp.org/news/how-the-internet-works/',
                'https://web.stanford.edu/class/msande91si/www-spr04/readings/week1/InternetWhitepaper.htm',
                'https://www.youtube.com/watch?v=7_LPdttKXPc',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'Client-Server Architecture',
            'description' => 'Learn client-server model: requests and responses, frontend vs backend, stateless vs stateful communication.',
            'day_number' => 5,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Networking',
            'order' => 74,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Extensions/Server-side/First_steps/Client-Server_overview',
                'https://roadmap.sh/backend',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'Network Concepts Practice',
            'description' => 'Answer conceptual questions and diagram network flows: trace a web request from browser to server and back.',
            'day_number' => 6,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Networking',
            'order' => 75,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Web/HTTP',
                'https://www.youtube.com/watch?v=PBWhzz_Gn10',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 31: APIs and Communication
        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'What are APIs?',
            'description' => 'Introduction to APIs: Application Programming Interfaces, how software talks to software, REST API basics.',
            'day_number' => 7,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Networking',
            'order' => 76,
            'resources_links' => [
                'https://www.freecodecamp.org/news/what-is-an-api-in-english-please-b880a3214a82/',
                'https://www.postman.com/what-is-an-api/',
                'https://www.youtube.com/watch?v=s7wmiS2mSXY',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'Understanding HTTP Requests',
            'description' => 'Learn HTTP methods (GET, POST, PUT, DELETE), status codes, headers, request/response structure. Explore public APIs.',
            'day_number' => 8,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Networking',
            'order' => 77,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Methods',
                'https://www.youtube.com/watch?v=PUPDGbnpSjw',
                'https://jsonplaceholder.typicode.com/',
                'https://roadmap.sh/backend',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 32: DevOps Introduction
        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'What is DevOps?',
            'description' => 'Introduction to DevOps: development + operations, continuous integration/deployment, automation, collaboration culture.',
            'day_number' => 9,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'DevOps',
            'order' => 78,
            'resources_links' => [
                'https://about.gitlab.com/topics/devops/',
                'https://roadmap.sh/devops',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'Servers and Deployment Basics',
            'description' => 'What are servers? Local vs cloud hosting, deployment process overview, environments (dev, staging, production).',
            'day_number' => 10,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'DevOps',
            'order' => 79,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Howto/Web_mechanics/What_is_a_web_server',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        // Day 33: Databases Overview
        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'Introduction to Databases',
            'description' => 'Why databases? Data persistence, CRUD operations, database management systems, relational vs non-relational databases. 💡 Book: "Database Design for Mere Mortals" - excellent beginner guide.',
            'day_number' => 11,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Databases',
            'order' => 80,
            'resources_links' => [
                'https://www.oracle.com/database/what-is-database/',
                'https://www.youtube.com/watch?v=wR0jg0eQsZA',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'SQL vs NoSQL',
            'description' => 'Compare SQL (PostgreSQL, MySQL) and NoSQL (MongoDB, Firebase) databases. When to use each, trade-offs, basic query concepts.',
            'day_number' => 12,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Databases',
            'order' => 81,
            'resources_links' => [
                'https://www.mongodb.com/resources/basics/databases/nosql-explained/nosql-vs-sql',
                'https://www.youtube.com/watch?v=HXV3zeQKqGY',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'Database Concepts Practice',
            'description' => 'Design database schemas for applications: blog (users, posts, comments), e-commerce (products, orders, customers). Choose appropriate data types.',
            'day_number' => 13,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Databases',
            'order' => 82,
            'resources_links' => [
                'https://sqlbolt.com/',
                'https://mystery.knightlab.com/',
                'https://www.hackerrank.com/domains/sql',
                'https://roadmap.sh/sql',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 34: Putting It All Together
        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'Full Stack Thinking Exercise',
            'description' => 'Trace a complete application flow: user clicks button → frontend → API → database → response. Understand how all pieces connect.',
            'day_number' => 14,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'System Design',
            'order' => 83,
            'resources_links' => [
                'https://www.w3schools.com/whatis/whatis_fullstack.asp',
                'https://www.youtube.com/watch?v=UzLMhqg3_Wc',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'System Design Basics',
            'description' => 'Introduction to system design: components of a web application, scalability basics, caching, load balancing concepts.',
            'day_number' => 15,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'System Design',
            'order' => 84,
            'resources_links' => [
                'https://github.com/donnemartin/system-design-primer',
                'https://www.freecodecamp.org/news/systems-design-for-interviews/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 35: Final Integration Project
        Task::create([
            'roadmap_id' => $roadmap5->id,
            'title' => 'Design a Simple Application Architecture',
            'description' => 'Final capstone: Design a complete application (e.g., task management app, social media platform). Create architecture diagram, define data models, plan API endpoints, describe user flows. Document all technical decisions using concepts learned.',
            'day_number' => 16,
            'estimated_time_minutes' => 240,
            'task_type' => 'project',
            'category' => 'System Design',
            'order' => 85,
            'resources_links' => [
                'https://excalidraw.com/',
                'https://www.frontendmentor.io/challenges',
                'https://www.youtube.com/watch?v=lTkL1oIMiaU',
                'https://roadmap.sh/software-design-architecture',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);
    }
}
