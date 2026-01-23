<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class FullStackRoadmapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user as creator
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            $this->command->error('Admin user not found. Please run UserSeeder first.');
            return;
        }

        // Get the "Programming Basics" roadmap as prerequisite
        $programmingBasics = Roadmap::where('slug', 'programming-basics')->first();

        // 1. Foundations (30 days)
        $foundations = Roadmap::create([
            'title' => 'Web Development Foundations',
            'description' => 'Start your journey from absolute beginner to understanding core web technologies. Learn HTML, CSS, JavaScript basics, Git, and fundamental development tools.',
            'duration_days' => 30,
            'difficulty_level' => 'beginner',
            'is_published' => true,
            'is_featured' => false,
            'creator_id' => $admin->id,
            'order' => 6,
            'prerequisite_roadmap_id' => $programmingBasics ? $programmingBasics->id : null,
        ]);

        $this->createFoundationsTasks($foundations);

        // 2. Frontend Fundamentals (21 days)
        $frontendFundamentals = Roadmap::create([
            'title' => 'Frontend Fundamentals',
            'description' => 'Master modern CSS techniques, advanced JavaScript ES6+, DOM manipulation, and responsive design. Build real-world projects with Tailwind CSS.',
            'duration_days' => 21,
            'difficulty_level' => 'beginner',
            'is_published' => true,
            'creator_id' => $admin->id,
            'order' => 7,
            'prerequisite_roadmap_id' => $foundations->id,
        ]);

        $this->createFrontendFundamentalsTasks($frontendFundamentals);

        // 3. Frontend Framework - React (23 days)
        $react = Roadmap::create([
            'title' => 'Frontend Framework - React',
            'description' => 'Dive deep into React ecosystem. Learn hooks, state management, routing, API integration, and build production-ready React applications.',
            'duration_days' => 23,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'creator_id' => $admin->id,
            'order' => 8,
            'prerequisite_roadmap_id' => $frontendFundamentals->id,
        ]);

        $this->createReactTasks($react);

        // 4. Backend Development - Laravel (25 days)
        $laravel = Roadmap::create([
            'title' => 'Backend Development - Laravel',
            'description' => 'Master server-side development with Laravel. Learn PHP, database design, RESTful APIs, authentication, and backend best practices.',
            'duration_days' => 25,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'creator_id' => $admin->id,
            'order' => 9,
            'prerequisite_roadmap_id' => $frontendFundamentals->id,
        ]);

        $this->createLaravelTasks($laravel);

        // 5. Full Stack Integration (20 days)
        $fullStack = Roadmap::create([
            'title' => 'Full Stack Integration',
            'description' => 'Combine React frontend with Laravel backend. Build complete full-stack applications with authentication, real-time features, and deployment.',
            'duration_days' => 20,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'creator_id' => $admin->id,
            'order' => 10,
            'prerequisite_roadmap_id' => $laravel->id, // Needs both React and Laravel
        ]);

        $this->createFullStackTasks($fullStack);

        // 6. Advanced Topics & Best Practices (21 days)
        $advanced = Roadmap::create([
            'title' => 'Advanced Topics & Best Practices',
            'description' => 'Level up with testing, CI/CD, Docker, performance optimization, and security. Learn industry-standard practices for professional development.',
            'duration_days' => 21,
            'difficulty_level' => 'advanced',
            'is_published' => true,
            'creator_id' => $admin->id,
            'order' => 11,
            'prerequisite_roadmap_id' => $fullStack->id,
        ]);

        $this->createAdvancedTasks($advanced);

        // 7. Senior Level Skills (24 days)
        $senior = Roadmap::create([
            'title' => 'Senior Level Skills',
            'description' => 'Master system design, architecture patterns, scalability, microservices, and advanced database optimization. Build senior-level portfolio projects.',
            'duration_days' => 24,
            'difficulty_level' => 'advanced',
            'is_published' => true,
            'creator_id' => $admin->id,
            'order' => 12,
            'prerequisite_roadmap_id' => $advanced->id,
        ]);

        $this->createSeniorTasks($senior);
    }

    private function createFoundationsTasks(Roadmap $roadmap): void
    {
        // Day 1-5: HTML Basics
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Introduction to HTML',
            'description' => 'Learn what HTML is, its structure, and basic tags. Understand how web pages are built.',
            'day_number' => 1,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'HTML',
            'order' => 1,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/Structuring_content',
                'https://www.w3schools.com/html/html_intro.asp',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'HTML Document Structure',
            'description' => 'Create your first HTML page with proper structure: doctype, html, head, and body tags.',
            'day_number' => 1,
            'estimated_time_minutes' => 90,
            'task_type' => 'exercise',
            'category' => 'HTML',
            'order' => 2,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/Structuring_content/Getting_started',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'HTML Text Formatting',
            'description' => 'Learn headings (h1-h6), paragraphs, bold, italic, and other text formatting tags.',
            'day_number' => 2,
            'estimated_time_minutes' => 120,
            'task_type' => 'video',
            'category' => 'HTML',
            'order' => 3,
            'resources_links' => [
                'https://www.youtube.com/watch?v=UB1O30fR-EE',
                'https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Personal Bio Page',
            'description' => 'Create an HTML page about yourself using headings, paragraphs, lists, and links.',
            'day_number' => 2,
            'estimated_time_minutes' => 180,
            'task_type' => 'project',
            'category' => 'HTML',
            'order' => 4,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'HTML Lists and Links',
            'description' => 'Master ordered lists, unordered lists, and anchor tags for creating navigation.',
            'day_number' => 3,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'HTML',
            'order' => 5,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/ul',
                'https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/a',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'HTML Forms and Input',
            'description' => 'Learn form elements: input, textarea, select, buttons, and form attributes.',
            'day_number' => 4,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'HTML',
            'order' => 6,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Extensions/Forms',
                'https://www.w3schools.com/html/html_forms.asp',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'HTML Tables and Semantic Tags',
            'description' => 'Understand tables, semantic HTML5 tags (header, nav, main, footer, article, section).',
            'day_number' => 5,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'HTML',
            'order' => 7,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Glossary/Semantics',
                'https://www.w3schools.com/html/html5_semantic_elements.asp',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        // Day 6-12: CSS Basics
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Introduction to CSS',
            'description' => 'Learn CSS syntax, selectors, and how to style HTML elements. Understand inline, internal, and external CSS.',
            'day_number' => 6,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'CSS',
            'order' => 8,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/Styling_basics/First_steps',
                'https://web.dev/learn/css/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'CSS Selectors and Specificity',
            'description' => 'Master class, id, element, attribute selectors and understand CSS specificity rules.',
            'day_number' => 7,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'CSS',
            'order' => 9,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Selectors',
                'https://specificity.keegan.st/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'CSS Box Model',
            'description' => 'Understand margin, border, padding, and content. Learn how box-sizing works.',
            'day_number' => 8,
            'estimated_time_minutes' => 120,
            'task_type' => 'video',
            'category' => 'CSS',
            'order' => 10,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/Styling_basics/Building_blocks/The_box_model',
                'https://www.youtube.com/watch?v=rIO5326FgPE',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'CSS Typography and Colors',
            'description' => 'Style text with fonts, sizes, weights. Work with colors, backgrounds, and gradients.',
            'day_number' => 9,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'CSS',
            'order' => 11,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/Styling_basics/Styling_text',
                'https://fonts.google.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'CSS Layout - Display and Position',
            'description' => 'Learn display properties (block, inline, inline-block) and positioning (static, relative, absolute, fixed).',
            'day_number' => 10,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'CSS',
            'order' => 12,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Web/CSS/position',
                'https://developer.mozilla.org/en-US/docs/Web/CSS/display',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Styled Landing Page',
            'description' => 'Create a beautiful landing page using HTML and CSS. Include header, hero section, features, and footer.',
            'day_number' => 11,
            'estimated_time_minutes' => 240,
            'task_type' => 'project',
            'category' => 'CSS',
            'order' => 13,
            'resources_links' => [
                'https://www.frontendmentor.io/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'CSS Transitions and Animations',
            'description' => 'Add smooth transitions and keyframe animations to your web pages.',
            'day_number' => 12,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'CSS',
            'order' => 14,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Transitions',
                'https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Animations',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 13-20: JavaScript Basics
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Introduction to JavaScript',
            'description' => 'Learn what JavaScript is, how to include it in HTML, and basic syntax (variables, data types).',
            'day_number' => 13,
            'estimated_time_minutes' => 150,
            'task_type' => 'reading',
            'category' => 'JavaScript',
            'order' => 15,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/Scripting/Getting_started',
                'https://javascript.info/intro',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'JavaScript Variables and Data Types',
            'description' => 'Work with let, const, var. Understand strings, numbers, booleans, arrays, and objects.',
            'day_number' => 14,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'JavaScript',
            'order' => 16,
            'resources_links' => [
                'https://javascript.info/variables',
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Data_structures',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'JavaScript Operators and Conditionals',
            'description' => 'Learn arithmetic, comparison, logical operators. Master if/else, switch statements.',
            'day_number' => 15,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'JavaScript',
            'order' => 17,
            'resources_links' => [
                'https://javascript.info/operators',
                'https://javascript.info/ifelse',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'JavaScript Loops',
            'description' => 'Master for, while, do-while loops. Learn array iteration methods.',
            'day_number' => 16,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'JavaScript',
            'order' => 18,
            'resources_links' => [
                'https://javascript.info/while-for',
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Loops_and_iteration',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'JavaScript Functions',
            'description' => 'Learn function declarations, expressions, arrow functions, parameters, and return values.',
            'day_number' => 17,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'JavaScript',
            'order' => 19,
            'resources_links' => [
                'https://javascript.info/function-basics',
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Functions',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'JavaScript Arrays and Objects',
            'description' => 'Deep dive into array methods (map, filter, reduce) and object manipulation.',
            'day_number' => 18,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'JavaScript',
            'order' => 20,
            'resources_links' => [
                'https://javascript.info/array-methods',
                'https://javascript.info/object',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'DOM Manipulation Basics',
            'description' => 'Learn to select elements, modify content, change styles, and handle events.',
            'day_number' => 19,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'JavaScript',
            'order' => 21,
            'resources_links' => [
                'https://javascript.info/document',
                'https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Client-side_web_APIs/Manipulating_documents',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build an Interactive To-Do List',
            'description' => 'Create a to-do list app with add, delete, and mark complete functionality using vanilla JavaScript.',
            'day_number' => 20,
            'estimated_time_minutes' => 240,
            'task_type' => 'project',
            'category' => 'JavaScript',
            'order' => 22,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 21-25: Git & GitHub
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Introduction to Git',
            'description' => 'Learn version control basics, why Git is important, and install Git on your system.',
            'day_number' => 21,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Git',
            'order' => 23,
            'resources_links' => [
                'https://git-scm.com/book/en/v2/Getting-Started-What-is-Git%3F',
                'https://www.youtube.com/watch?v=2ReR1YJrNOM',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Git Basic Commands',
            'description' => 'Master git init, add, commit, status, log, diff. Create your first repository.',
            'day_number' => 22,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Git',
            'order' => 24,
            'resources_links' => [
                'https://git-scm.com/docs',
                'https://learngitbranching.js.org/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Git Branching and Merging',
            'description' => 'Learn to create branches, switch between them, merge branches, and resolve conflicts.',
            'day_number' => 23,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Git',
            'order' => 25,
            'resources_links' => [
                'https://git-scm.com/book/en/v2/Git-Branching-Basic-Branching-and-Merging',
                'https://learngitbranching.js.org/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'GitHub Introduction',
            'description' => 'Create a GitHub account, push your first repository, and understand remote repositories.',
            'day_number' => 24,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Git',
            'order' => 26,
            'resources_links' => [
                'https://docs.github.com/en/get-started',
                'https://www.youtube.com/watch?v=RGOj5yH7evk',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Collaborative Git Workflow',
            'description' => 'Learn pull requests, forking, cloning, and collaborating on GitHub projects.',
            'day_number' => 25,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Git',
            'order' => 27,
            'resources_links' => [
                'https://docs.github.com/en/pull-requests',
                'https://www.atlassian.com/git/tutorials/comparing-workflows',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        // Day 26-30: Development Tools & Final Project
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'VS Code Setup and Extensions',
            'description' => 'Set up VS Code with essential extensions: Live Server, Prettier, ESLint, etc.',
            'day_number' => 26,
            'estimated_time_minutes' => 90,
            'task_type' => 'reading',
            'category' => 'Tools',
            'order' => 28,
            'resources_links' => [
                'https://code.visualstudio.com/docs',
                'https://www.youtube.com/watch?v=WPqXP_kLzpo',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Browser DevTools Mastery',
            'description' => 'Learn to use Chrome DevTools: inspect elements, debug JavaScript, check network, and performance.',
            'day_number' => 27,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Tools',
            'order' => 29,
            'resources_links' => [
                'https://developer.chrome.com/docs/devtools/',
                'https://www.youtube.com/watch?v=gTVpBbFWry8',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Web Hosting Basics',
            'description' => 'Deploy your website using GitHub Pages, Netlify, or Vercel.',
            'day_number' => 28,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Deployment',
            'order' => 30,
            'resources_links' => [
                'https://pages.github.com/',
                'https://docs.netlify.com/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Foundations Quiz',
            'description' => 'Test your knowledge of HTML, CSS, JavaScript, and Git fundamentals.',
            'day_number' => 29,
            'estimated_time_minutes' => 60,
            'task_type' => 'quiz',
            'category' => 'Assessment',
            'order' => 31,
            'resources_links' => [],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Final Project - Portfolio Website',
            'description' => 'Build a complete portfolio website with multiple pages, contact form, and deploy it live. Include all projects from this roadmap.',
            'day_number' => 30,
            'estimated_time_minutes' => 360,
            'task_type' => 'project',
            'category' => 'Capstone',
            'order' => 32,
            'resources_links' => [
                'https://www.frontendmentor.io/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);
    }

    private function createFrontendFundamentalsTasks(Roadmap $roadmap): void
    {
        // Day 1-10: Advanced CSS
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'CSS Flexbox Deep Dive',
            'description' => 'Master flexbox layout: flex containers, items, direction, wrap, justify-content, align-items.',
            'day_number' => 1,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced CSS',
            'order' => 1,
            'resources_links' => [
                'https://css-tricks.com/snippets/css/a-guide-to-flexbox/',
                'https://flexboxfroggy.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'CSS Grid Layout',
            'description' => 'Learn CSS Grid for complex 2D layouts: grid-template, areas, gaps, auto-fill, auto-fit.',
            'day_number' => 2,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced CSS',
            'order' => 2,
            'resources_links' => [
                'https://css-tricks.com/snippets/css/complete-guide-grid/',
                'https://cssgridgarden.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Responsive Design Principles',
            'description' => 'Master media queries, mobile-first design, breakpoints, and responsive images.',
            'day_number' => 3,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Advanced CSS',
            'order' => 3,
            'resources_links' => [
                'https://web.dev/responsive-web-design-basics/',
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/Styling_basics/CSS_layout/Responsive_Design',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'CSS Variables and Custom Properties',
            'description' => 'Use CSS custom properties for theming, dynamic styles, and maintainable code.',
            'day_number' => 4,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Advanced CSS',
            'order' => 4,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Web/CSS/Using_CSS_custom_properties',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Introduction to Tailwind CSS',
            'description' => 'Set up Tailwind CSS and learn utility-first CSS approach.',
            'day_number' => 5,
            'estimated_time_minutes' => 150,
            'task_type' => 'reading',
            'category' => 'Advanced CSS',
            'order' => 5,
            'resources_links' => [
                'https://tailwindcss.com/docs/installation',
                'https://www.youtube.com/watch?v=UBOj6rqRUME',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Tailwind Layout and Components',
            'description' => 'Build responsive layouts and reusable components with Tailwind utility classes.',
            'day_number' => 6,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced CSS',
            'order' => 6,
            'resources_links' => [
                'https://tailwindcss.com/docs',
                'https://tailwindui.com/components',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Responsive Dashboard UI',
            'description' => 'Create a complete dashboard interface using Tailwind CSS with sidebar, cards, charts placeholders.',
            'day_number' => 7,
            'estimated_time_minutes' => 240,
            'task_type' => 'project',
            'category' => 'Advanced CSS',
            'order' => 7,
            'resources_links' => [
                'https://tailwindui.com/templates',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 8-20: Advanced JavaScript (ES6+)
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'ES6+ Features Overview',
            'description' => 'Learn let/const, arrow functions, template literals, destructuring, spread/rest operators.',
            'day_number' => 8,
            'estimated_time_minutes' => 180,
            'task_type' => 'reading',
            'category' => 'JavaScript ES6+',
            'order' => 8,
            'resources_links' => [
                'https://javascript.info/intro',
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Array Methods Mastery',
            'description' => 'Deep dive into map, filter, reduce, find, some, every, forEach with real examples.',
            'day_number' => 9,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'JavaScript ES6+',
            'order' => 9,
            'resources_links' => [
                'https://javascript.info/array-methods',
                'https://www.youtube.com/watch?v=rRgD1yVwIvE',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Promises and Async/Await',
            'description' => 'Master asynchronous JavaScript: callbacks, promises, async/await, error handling.',
            'day_number' => 10,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'JavaScript ES6+',
            'order' => 10,
            'resources_links' => [
                'https://javascript.info/async',
                'https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Asynchronous',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Fetch API and Working with APIs',
            'description' => 'Learn to fetch data from REST APIs, handle JSON, display data dynamically.',
            'day_number' => 11,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'JavaScript ES6+',
            'order' => 11,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API',
                'https://jsonplaceholder.typicode.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'JavaScript Modules (Import/Export)',
            'description' => 'Organize code using ES6 modules, named and default exports/imports.',
            'day_number' => 12,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'JavaScript ES6+',
            'order' => 12,
            'resources_links' => [
                'https://javascript.info/modules',
                'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Object-Oriented JavaScript',
            'description' => 'Learn classes, constructors, inheritance, prototypes, this keyword.',
            'day_number' => 13,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'JavaScript ES6+',
            'order' => 13,
            'resources_links' => [
                'https://javascript.info/classes',
                'https://developer.mozilla.org/en-US/docs/Learn_web_development/Extensions/Advanced_JavaScript_objects/Object-oriented_programming',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Local Storage and Session Storage',
            'description' => 'Store and retrieve data in browser using localStorage and sessionStorage.',
            'day_number' => 14,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'JavaScript ES6+',
            'order' => 14,
            'resources_links' => [
                'https://javascript.info/localstorage',
                'https://developer.mozilla.org/en-US/docs/Web/API/Window/localStorage',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Error Handling and Debugging',
            'description' => 'Master try/catch, error types, debugging techniques, console methods.',
            'day_number' => 15,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'JavaScript ES6+',
            'order' => 15,
            'resources_links' => [
                'https://javascript.info/error-handling',
                'https://developer.chrome.com/docs/devtools/javascript/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Weather App',
            'description' => 'Create a weather application using OpenWeather API with search, display current weather, and 5-day forecast.',
            'day_number' => 16,
            'estimated_time_minutes' => 300,
            'task_type' => 'project',
            'category' => 'JavaScript ES6+',
            'order' => 16,
            'resources_links' => [
                'https://openweathermap.org/api',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Movie Search App',
            'description' => 'Create a movie database search app using TMDB or OMDB API with search, details, and favorites.',
            'day_number' => 17,
            'estimated_time_minutes' => 300,
            'task_type' => 'project',
            'category' => 'JavaScript ES6+',
            'order' => 17,
            'resources_links' => [
                'https://www.themoviedb.org/settings/api',
                'https://www.omdbapi.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 18-25: Advanced Projects
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Kanban Board',
            'description' => 'Create a drag-and-drop Kanban board with columns and tasks using vanilla JavaScript.',
            'day_number' => 18,
            'estimated_time_minutes' => 360,
            'task_type' => 'project',
            'category' => 'Projects',
            'order' => 18,
            'resources_links' => [
                'https://developer.mozilla.org/en-US/docs/Web/API/HTML_Drag_and_Drop_API',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build an E-commerce Product Page',
            'description' => 'Create a product page with image gallery, cart functionality, and localStorage persistence.',
            'day_number' => 20,
            'estimated_time_minutes' => 360,
            'task_type' => 'project',
            'category' => 'Projects',
            'order' => 19,
            'resources_links' => [
                'https://www.frontendmentor.io/challenges',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Frontend Fundamentals Quiz',
            'description' => 'Comprehensive quiz on advanced CSS, ES6+, and modern JavaScript concepts.',
            'day_number' => 24,
            'estimated_time_minutes' => 90,
            'task_type' => 'quiz',
            'category' => 'Assessment',
            'order' => 20,
            'resources_links' => [],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Capstone Project - Full Website',
            'description' => 'Build a complete multi-page website (restaurant, agency, or SaaS landing) with Tailwind, API integration, and advanced interactions.',
            'day_number' => 25,
            'estimated_time_minutes' => 480,
            'task_type' => 'project',
            'category' => 'Capstone',
            'order' => 21,
            'resources_links' => [
                'https://www.frontendmentor.io/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);
    }

    private function createReactTasks(Roadmap $roadmap): void
    {
        // Day 1-15: React Basics
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Introduction to React',
            'description' => 'Learn what React is, why use it, and set up your first React app with Vite.',
            'day_number' => 1,
            'estimated_time_minutes' => 150,
            'task_type' => 'reading',
            'category' => 'React Basics',
            'order' => 1,
            'resources_links' => [
                'https://react.dev/learn',
                'https://vitejs.dev/guide/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'JSX and Components',
            'description' => 'Understand JSX syntax, create functional components, and use props.',
            'day_number' => 2,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'React Basics',
            'order' => 2,
            'resources_links' => [
                'https://react.dev/learn/writing-markup-with-jsx',
                'https://react.dev/learn/your-first-component',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Props and Component Composition',
            'description' => 'Learn to pass data with props, prop types, default props, and children.',
            'day_number' => 3,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'React Basics',
            'order' => 3,
            'resources_links' => [
                'https://react.dev/learn/passing-props-to-a-component',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'State with useState Hook',
            'description' => 'Master useState hook for managing component state and re-renders.',
            'day_number' => 4,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'React Basics',
            'order' => 4,
            'resources_links' => [
                'https://react.dev/reference/react/useState',
                'https://react.dev/learn/state-a-components-memory',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Event Handling in React',
            'description' => 'Handle user events: onClick, onChange, onSubmit, and event objects.',
            'day_number' => 5,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'React Basics',
            'order' => 5,
            'resources_links' => [
                'https://react.dev/learn/responding-to-events',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Lists and Keys in React',
            'description' => 'Render lists with map(), understand key prop importance.',
            'day_number' => 6,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'React Basics',
            'order' => 6,
            'resources_links' => [
                'https://react.dev/learn/rendering-lists',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Conditional Rendering',
            'description' => 'Master different ways to conditionally render components and elements.',
            'day_number' => 7,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'React Basics',
            'order' => 7,
            'resources_links' => [
                'https://react.dev/learn/conditional-rendering',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Forms in React',
            'description' => 'Build controlled components, handle form submissions, validation.',
            'day_number' => 8,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'React Basics',
            'order' => 8,
            'resources_links' => [
                'https://react.dev/reference/react-dom/components/input',
                'https://formik.org/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'useEffect Hook',
            'description' => 'Learn side effects, component lifecycle with useEffect, cleanup functions.',
            'day_number' => 9,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'React Basics',
            'order' => 9,
            'resources_links' => [
                'https://react.dev/reference/react/useEffect',
                'https://react.dev/learn/synchronizing-with-effects',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Fetching Data in React',
            'description' => 'Fetch data from APIs using useEffect, handle loading and error states.',
            'day_number' => 10,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'React Basics',
            'order' => 10,
            'resources_links' => [
                'https://react.dev/reference/react/useEffect#fetching-data-with-effects',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a React To-Do App',
            'description' => 'Create a full-featured to-do application with add, edit, delete, filter, and localStorage.',
            'day_number' => 11,
            'estimated_time_minutes' => 300,
            'task_type' => 'project',
            'category' => 'React Basics',
            'order' => 11,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 12-30: Advanced React
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'React Router - Routing Basics',
            'description' => 'Set up React Router, create routes, navigate between pages, route parameters.',
            'day_number' => 12,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced React',
            'order' => 12,
            'resources_links' => [
                'https://reactrouter.com/en/main/start/tutorial',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'React Router - Advanced',
            'description' => 'Learn nested routes, protected routes, programmatic navigation, loaders.',
            'day_number' => 13,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced React',
            'order' => 13,
            'resources_links' => [
                'https://reactrouter.com/en/main',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Context API for State Management',
            'description' => 'Learn Context API to share state across components without prop drilling.',
            'day_number' => 14,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced React',
            'order' => 14,
            'resources_links' => [
                'https://react.dev/learn/passing-data-deeply-with-context',
                'https://react.dev/reference/react/useContext',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'useReducer Hook',
            'description' => 'Manage complex state logic with useReducer hook.',
            'day_number' => 15,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced React',
            'order' => 15,
            'resources_links' => [
                'https://react.dev/reference/react/useReducer',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Custom Hooks',
            'description' => 'Create reusable custom hooks to encapsulate logic.',
            'day_number' => 16,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced React',
            'order' => 16,
            'resources_links' => [
                'https://react.dev/learn/reusing-logic-with-custom-hooks',
                'https://usehooks.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'React Query / TanStack Query',
            'description' => 'Learn modern data fetching with React Query for server state management.',
            'day_number' => 17,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Advanced React',
            'order' => 17,
            'resources_links' => [
                'https://tanstack.com/query/latest/docs/react/overview',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Blog with API',
            'description' => 'Create a blog application fetching posts from JSONPlaceholder API with routing and detailed views.',
            'day_number' => 18,
            'estimated_time_minutes' => 360,
            'task_type' => 'project',
            'category' => 'Advanced React',
            'order' => 18,
            'resources_links' => [
                'https://jsonplaceholder.typicode.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Authentication in React',
            'description' => 'Implement authentication flow: login, logout, protected routes, JWT handling.',
            'day_number' => 20,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Advanced React',
            'order' => 19,
            'resources_links' => [
                'https://react.dev/learn/passing-data-deeply-with-context',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Performance Optimization',
            'description' => 'Learn React.memo, useMemo, useCallback, code splitting, lazy loading.',
            'day_number' => 22,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Advanced React',
            'order' => 20,
            'resources_links' => [
                'https://react.dev/reference/react/memo',
                'https://react.dev/reference/react/useMemo',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'TypeScript with React',
            'description' => 'Add TypeScript to React projects: typing props, state, events, and hooks.',
            'day_number' => 24,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Advanced React',
            'order' => 21,
            'resources_links' => [
                'https://react.dev/learn/typescript',
                'https://www.typescriptlang.org/docs/handbook/react.html',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'React Quiz',
            'description' => 'Test your React knowledge: components, hooks, routing, state management.',
            'day_number' => 28,
            'estimated_time_minutes' => 90,
            'task_type' => 'quiz',
            'category' => 'Assessment',
            'order' => 22,
            'resources_links' => [],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Capstone - E-commerce Frontend',
            'description' => 'Build a complete e-commerce frontend with products, cart, checkout, authentication, and routing.',
            'day_number' => 30,
            'estimated_time_minutes' => 600,
            'task_type' => 'project',
            'category' => 'Capstone',
            'order' => 23,
            'resources_links' => [
                'https://fakestoreapi.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);
    }

    private function createLaravelTasks(Roadmap $roadmap): void
    {
        // Day 1-10: PHP & Laravel Basics
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'PHP Fundamentals Review',
            'description' => 'Review PHP basics: syntax, variables, functions, arrays, loops, OOP concepts.',
            'day_number' => 1,
            'estimated_time_minutes' => 180,
            'task_type' => 'reading',
            'category' => 'PHP Basics',
            'order' => 1,
            'resources_links' => [
                'https://www.php.net/manual/en/langref.php',
                'https://laracasts.com/series/php-for-beginners',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Laravel Installation & Setup',
            'description' => 'Install Laravel, understand project structure, run development server.',
            'day_number' => 2,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Laravel Basics',
            'order' => 2,
            'resources_links' => [
                'https://laravel.com/docs/installation',
                'https://laracasts.com/series/laravel-from-scratch',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Routing in Laravel',
            'description' => 'Learn routes: GET, POST, parameters, named routes, route groups.',
            'day_number' => 3,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Laravel Basics',
            'order' => 3,
            'resources_links' => [
                'https://laravel.com/docs/11.x/routing',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Controllers and MVC Pattern',
            'description' => 'Create controllers, understand MVC architecture, resource controllers.',
            'day_number' => 4,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Laravel Basics',
            'order' => 4,
            'resources_links' => [
                'https://laravel.com/docs/11.x/controllers',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Blade Templates',
            'description' => 'Master Blade templating: layouts, includes, components, directives, slots.',
            'day_number' => 5,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Laravel Basics',
            'order' => 5,
            'resources_links' => [
                'https://laravel.com/docs/11.x/blade',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Database Migrations',
            'description' => 'Create and run migrations, modify tables, rollback, database seeding.',
            'day_number' => 6,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Database',
            'order' => 6,
            'resources_links' => [
                'https://laravel.com/docs/11.x/migrations',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Eloquent ORM Basics',
            'description' => 'Learn Eloquent models, CRUD operations, mass assignment, timestamps.',
            'day_number' => 7,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Database',
            'order' => 7,
            'resources_links' => [
                'https://laravel.com/docs/11.x/eloquent',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Eloquent Relationships',
            'description' => 'Master relationships: one-to-one, one-to-many, many-to-many, polymorphic.',
            'day_number' => 8,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Database',
            'order' => 8,
            'resources_links' => [
                'https://laravel.com/docs/11.x/eloquent-relationships',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Query Builder and Advanced Queries',
            'description' => 'Learn query builder, joins, where clauses, aggregates, raw queries.',
            'day_number' => 9,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Database',
            'order' => 9,
            'resources_links' => [
                'https://laravel.com/docs/11.x/queries',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Blog CRUD',
            'description' => 'Create a complete blog with create, read, update, delete posts functionality.',
            'day_number' => 10,
            'estimated_time_minutes' => 360,
            'task_type' => 'project',
            'category' => 'Laravel Basics',
            'order' => 10,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 11-30: Advanced Laravel
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Form Validation',
            'description' => 'Implement validation rules, custom messages, form requests, validation classes.',
            'day_number' => 11,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced Laravel',
            'order' => 11,
            'resources_links' => [
                'https://laravel.com/docs/11.x/validation',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Authentication with Laravel Breeze',
            'description' => 'Set up authentication: register, login, logout, password reset.',
            'day_number' => 12,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced Laravel',
            'order' => 12,
            'resources_links' => [
                'https://laravel.com/docs/starter-kits',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Authorization and Gates',
            'description' => 'Learn authorization, policies, gates, middleware for access control.',
            'day_number' => 13,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced Laravel',
            'order' => 13,
            'resources_links' => [
                'https://laravel.com/docs/authorization',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'File Upload and Storage',
            'description' => 'Handle file uploads, storage configuration, image manipulation.',
            'day_number' => 14,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced Laravel',
            'order' => 14,
            'resources_links' => [
                'https://laravel.com/docs/filesystem',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'RESTful API Basics',
            'description' => 'Build RESTful APIs: routes, controllers, JSON responses, status codes.',
            'day_number' => 15,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'API Development',
            'order' => 15,
            'resources_links' => [
                'https://laravel.com/docs/11.x/eloquent-resources',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'API Resources and Collections',
            'description' => 'Transform data with API resources, collections, conditional attributes.',
            'day_number' => 16,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'API Development',
            'order' => 16,
            'resources_links' => [
                'https://laravel.com/docs/11.x/eloquent-resources',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'API Authentication with Sanctum',
            'description' => 'Implement API authentication using Laravel Sanctum and tokens.',
            'day_number' => 17,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'API Development',
            'order' => 17,
            'resources_links' => [
                'https://laravel.com/docs/11.x/sanctum',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Pagination and Filtering APIs',
            'description' => 'Add pagination, filtering, sorting to your API endpoints.',
            'day_number' => 18,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'API Development',
            'order' => 18,
            'resources_links' => [
                'https://laravel.com/docs/pagination',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Task Management API',
            'description' => 'Create a complete RESTful API for task management with authentication and CRUD operations.',
            'day_number' => 20,
            'estimated_time_minutes' => 420,
            'task_type' => 'project',
            'category' => 'API Development',
            'order' => 19,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Middleware in Laravel',
            'description' => 'Create custom middleware, understand middleware groups, route middleware.',
            'day_number' => 22,
            'estimated_time_minutes' => 150,
            'task_type' => 'exercise',
            'category' => 'Advanced Laravel',
            'order' => 20,
            'resources_links' => [
                'https://laravel.com/docs/11.x/middleware',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Events and Listeners',
            'description' => 'Learn event-driven programming: create events, listeners, dispatch events.',
            'day_number' => 23,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced Laravel',
            'order' => 21,
            'resources_links' => [
                'https://laravel.com/docs/events',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Queue and Jobs',
            'description' => 'Implement background jobs, queue workers, job batching, failed jobs.',
            'day_number' => 24,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Advanced Laravel',
            'order' => 22,
            'resources_links' => [
                'https://laravel.com/docs/11.x/queues',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Email and Notifications',
            'description' => 'Send emails with Mailables, notifications via email, database, SMS.',
            'day_number' => 25,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Advanced Laravel',
            'order' => 23,
            'resources_links' => [
                'https://laravel.com/docs/mail',
                'https://laravel.com/docs/notifications',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Laravel Quiz',
            'description' => 'Test your Laravel knowledge: routing, Eloquent, authentication, APIs.',
            'day_number' => 28,
            'estimated_time_minutes' => 90,
            'task_type' => 'quiz',
            'category' => 'Assessment',
            'order' => 24,
            'resources_links' => [],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Capstone - Blog API with Admin Panel',
            'description' => 'Build a complete blog system with RESTful API, admin panel, authentication, and authorization.',
            'day_number' => 30,
            'estimated_time_minutes' => 600,
            'task_type' => 'project',
            'category' => 'Capstone',
            'order' => 25,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);
    }

    private function createFullStackTasks(Roadmap $roadmap): void
    {
        // Day 1-15: Integration Basics
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Full Stack Architecture Overview',
            'description' => 'Understand how React frontend communicates with Laravel backend, CORS, API design.',
            'day_number' => 1,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'Architecture',
            'order' => 1,
            'resources_links' => [
                'https://laravel.com/docs/11.x/sanctum#spa-authentication',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Setting Up CORS',
            'description' => 'Configure CORS in Laravel to allow React frontend to communicate with backend.',
            'day_number' => 2,
            'estimated_time_minutes' => 120,
            'task_type' => 'exercise',
            'category' => 'Setup',
            'order' => 2,
            'resources_links' => [
                'https://laravel.com/docs/11.x/routing#cors',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'React + Laravel Authentication Flow',
            'description' => 'Implement full authentication: login, register, logout between React and Laravel using Sanctum.',
            'day_number' => 3,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Authentication',
            'order' => 3,
            'resources_links' => [
                'https://laravel.com/docs/11.x/sanctum#spa-authentication',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Protected Routes in React',
            'description' => 'Create protected routes that require authentication, redirect logic.',
            'day_number' => 4,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Authentication',
            'order' => 4,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'CRUD Operations - Frontend to Backend',
            'description' => 'Build complete CRUD in React consuming Laravel API with React Query.',
            'day_number' => 5,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Integration',
            'order' => 5,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Form Handling and Validation',
            'description' => 'Handle forms in React with backend validation, display errors from Laravel.',
            'day_number' => 6,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Integration',
            'order' => 6,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'File Upload - Frontend to Backend',
            'description' => 'Upload files from React, handle in Laravel, store and serve images.',
            'day_number' => 7,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Integration',
            'order' => 7,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Pagination in Full Stack',
            'description' => 'Implement paginated data from Laravel API in React frontend.',
            'day_number' => 8,
            'estimated_time_minutes' => 180,
            'task_type' => 'exercise',
            'category' => 'Integration',
            'order' => 8,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Search and Filter Full Stack',
            'description' => 'Build search and filtering functionality across frontend and backend.',
            'day_number' => 9,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Integration',
            'order' => 9,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Note-Taking App',
            'description' => 'Create a full-stack note-taking app with authentication, CRUD, rich text editor.',
            'day_number' => 10,
            'estimated_time_minutes' => 420,
            'task_type' => 'project',
            'category' => 'Projects',
            'order' => 10,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Day 11-25: Advanced Integration
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Real-time with Laravel Echo and Pusher',
            'description' => 'Set up real-time notifications and events using Laravel Echo and Pusher.',
            'day_number' => 12,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Real-time',
            'order' => 11,
            'resources_links' => [
                'https://laravel.com/docs/broadcasting',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'WebSockets and Broadcasting',
            'description' => 'Implement WebSocket connections for chat or live updates.',
            'day_number' => 13,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Real-time',
            'order' => 12,
            'resources_links' => [
                'https://beyondco.de/docs/laravel-websockets',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Role-Based Access Control',
            'description' => 'Implement roles and permissions across React frontend and Laravel backend.',
            'day_number' => 15,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Authorization',
            'order' => 13,
            'resources_links' => [
                'https://spatie.be/docs/laravel-permission',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Payment Integration - Stripe',
            'description' => 'Integrate Stripe payment processing in full-stack application.',
            'day_number' => 17,
            'estimated_time_minutes' => 360,
            'task_type' => 'exercise',
            'category' => 'Payments',
            'order' => 14,
            'resources_links' => [
                'https://laravel.com/docs/billing',
                'https://stripe.com/docs',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Email Verification Flow',
            'description' => 'Implement complete email verification from frontend to backend.',
            'day_number' => 19,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Authentication',
            'order' => 15,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Social Authentication (OAuth)',
            'description' => 'Add social login: Google, GitHub using Laravel Socialite.',
            'day_number' => 20,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Authentication',
            'order' => 16,
            'resources_links' => [
                'https://laravel.com/docs/socialite',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Chat Application',
            'description' => 'Create a real-time chat app with WebSockets, typing indicators, online status.',
            'day_number' => 22,
            'estimated_time_minutes' => 480,
            'task_type' => 'project',
            'category' => 'Projects',
            'order' => 17,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Deployment Preparation',
            'description' => 'Prepare app for production: environment variables, optimization, security.',
            'day_number' => 24,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Deployment',
            'order' => 18,
            'resources_links' => [
                'https://laravel.com/docs/11.x/deployment',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Deploy to Production',
            'description' => 'Deploy React frontend (Vercel/Netlify) and Laravel backend (Laravel Forge/DigitalOcean).',
            'day_number' => 25,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Deployment',
            'order' => 19,
            'resources_links' => [
                'https://vercel.com/docs',
                'https://forge.laravel.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Final Project
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Capstone - Project Management System',
            'description' => 'Build a complete project management tool: teams, projects, tasks, comments, file uploads, real-time updates, deployed live.',
            'day_number' => 26,
            'estimated_time_minutes' => 960,
            'task_type' => 'project',
            'category' => 'Capstone',
            'order' => 20,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);
    }

    private function createAdvancedTasks(Roadmap $roadmap): void
    {
        // Testing
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Introduction to Testing',
            'description' => 'Learn testing fundamentals: unit tests, integration tests, TDD principles.',
            'day_number' => 1,
            'estimated_time_minutes' => 180,
            'task_type' => 'reading',
            'category' => 'Testing',
            'order' => 1,
            'resources_links' => [
                'https://laravel.com/docs/11.x/testing',
                'https://testing-library.com/docs/react-testing-library/intro/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Laravel Testing with PHPUnit',
            'description' => 'Write feature tests, unit tests, database testing, mocking in Laravel.',
            'day_number' => 2,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Testing',
            'order' => 2,
            'resources_links' => [
                'https://laravel.com/docs/11.x/testing',
                'https://pestphp.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'React Testing with Jest and Testing Library',
            'description' => 'Test React components, hooks, user interactions, async operations.',
            'day_number' => 3,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Testing',
            'order' => 3,
            'resources_links' => [
                'https://jestjs.io/docs/getting-started',
                'https://testing-library.com/docs/react-testing-library/intro/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'End-to-End Testing with Cypress',
            'description' => 'Write E2E tests for complete user flows using Cypress.',
            'day_number' => 4,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Testing',
            'order' => 4,
            'resources_links' => [
                'https://www.cypress.io/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // CI/CD
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Introduction to CI/CD',
            'description' => 'Learn continuous integration and deployment concepts, benefits, workflows.',
            'day_number' => 5,
            'estimated_time_minutes' => 120,
            'task_type' => 'reading',
            'category' => 'CI/CD',
            'order' => 5,
            'resources_links' => [
                'https://docs.github.com/en/actions',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'GitHub Actions Setup',
            'description' => 'Create GitHub Actions workflows for automated testing and deployment.',
            'day_number' => 6,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'CI/CD',
            'order' => 6,
            'resources_links' => [
                'https://docs.github.com/en/actions',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Docker
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Docker Fundamentals',
            'description' => 'Learn Docker basics: containers, images, Dockerfile, docker-compose.',
            'day_number' => 7,
            'estimated_time_minutes' => 240,
            'task_type' => 'reading',
            'category' => 'Docker',
            'order' => 7,
            'resources_links' => [
                'https://docs.docker.com/get-started/',
                'https://laravel.com/docs/sail',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Dockerize Laravel Application',
            'description' => 'Create Docker setup for Laravel with Laravel Sail or custom Dockerfile.',
            'day_number' => 8,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Docker',
            'order' => 8,
            'resources_links' => [
                'https://laravel.com/docs/sail',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Docker Compose for Full Stack',
            'description' => 'Set up multi-container application: React, Laravel, MySQL, Redis with docker-compose.',
            'day_number' => 9,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Docker',
            'order' => 9,
            'resources_links' => [
                'https://docs.docker.com/compose/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Performance
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Frontend Performance Optimization',
            'description' => 'Optimize React: code splitting, lazy loading, memoization, bundle analysis.',
            'day_number' => 10,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Performance',
            'order' => 10,
            'resources_links' => [
                'https://web.dev/optimize-lcp/',
                'https://react.dev/learn/render-and-commit',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Backend Performance Optimization',
            'description' => 'Optimize Laravel: query optimization, caching, eager loading, indexes.',
            'day_number' => 11,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Performance',
            'order' => 11,
            'resources_links' => [
                'https://laravel.com/docs/11.x/queries#optimizing-queries',
                'https://laravel.com/docs/11.x/cache',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Caching Strategies',
            'description' => 'Implement Redis caching: query caching, route caching, CDN integration.',
            'day_number' => 12,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Performance',
            'order' => 12,
            'resources_links' => [
                'https://laravel.com/docs/11.x/cache',
                'https://redis.io/docs/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Security
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Web Security Fundamentals',
            'description' => 'Learn OWASP Top 10, XSS, CSRF, SQL injection, security best practices.',
            'day_number' => 13,
            'estimated_time_minutes' => 180,
            'task_type' => 'reading',
            'category' => 'Security',
            'order' => 13,
            'resources_links' => [
                'https://owasp.org/www-project-top-ten/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Securing Laravel Applications',
            'description' => 'Implement security measures: CSRF protection, XSS prevention, rate limiting.',
            'day_number' => 14,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Security',
            'order' => 14,
            'resources_links' => [
                'https://laravel.com/docs/11.x/authentication',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'API Security and Rate Limiting',
            'description' => 'Secure APIs: authentication, authorization, rate limiting, API keys.',
            'day_number' => 15,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Security',
            'order' => 15,
            'resources_links' => [
                'https://laravel.com/docs/rate-limiting',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Advanced Topics
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'GraphQL with Laravel',
            'description' => 'Introduction to GraphQL, set up GraphQL API with Laravel Lighthouse.',
            'day_number' => 16,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Advanced Topics',
            'order' => 16,
            'resources_links' => [
                'https://lighthouse-php.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Server-Side Rendering with Next.js',
            'description' => 'Learn SSR/SSG with Next.js, integrate with Laravel API.',
            'day_number' => 17,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Advanced Topics',
            'order' => 17,
            'resources_links' => [
                'https://nextjs.org/docs',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Elasticsearch Integration',
            'description' => 'Implement full-text search with Elasticsearch and Laravel Scout.',
            'day_number' => 18,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Advanced Topics',
            'order' => 18,
            'resources_links' => [
                'https://laravel.com/docs/scout',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Monitoring and Logging',
            'description' => 'Set up application monitoring with Laravel Telescope, logging strategies.',
            'day_number' => 19,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Advanced Topics',
            'order' => 19,
            'resources_links' => [
                'https://laravel.com/docs/telescope',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Advanced Topics Quiz',
            'description' => 'Test your knowledge on testing, CI/CD, Docker, performance, and security.',
            'day_number' => 20,
            'estimated_time_minutes' => 90,
            'task_type' => 'quiz',
            'category' => 'Assessment',
            'order' => 20,
            'resources_links' => [],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Capstone - Production-Ready App',
            'description' => 'Build a complete production-ready application with testing, CI/CD, Docker, monitoring, and security implemented.',
            'day_number' => 21,
            'estimated_time_minutes' => 1200,
            'task_type' => 'project',
            'category' => 'Capstone',
            'order' => 21,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);
    }

    private function createSeniorTasks(Roadmap $roadmap): void
    {
        // System Design
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'System Design Fundamentals',
            'description' => 'Learn system design basics: scalability, availability, consistency, CAP theorem.',
            'day_number' => 1,
            'estimated_time_minutes' => 240,
            'task_type' => 'reading',
            'category' => 'System Design',
            'order' => 1,
            'resources_links' => [
                'https://github.com/donnemartin/system-design-primer',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Database Scaling Strategies',
            'description' => 'Master replication, sharding, partitioning, read replicas, multi-region databases.',
            'day_number' => 2,
            'estimated_time_minutes' => 300,
            'task_type' => 'reading',
            'category' => 'System Design',
            'order' => 2,
            'resources_links' => [
                'https://www.digitalocean.com/community/tutorials/understanding-database-sharding',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Caching Architectures',
            'description' => 'Design caching layers: Redis clusters, CDN strategies, cache invalidation.',
            'day_number' => 3,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'System Design',
            'order' => 3,
            'resources_links' => [
                'https://redis.io/docs/latest/operate/oss_and_stack/management/scaling/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Load Balancing and High Availability',
            'description' => 'Implement load balancers, health checks, failover strategies, auto-scaling.',
            'day_number' => 4,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'System Design',
            'order' => 4,
            'resources_links' => [
                'https://aws.amazon.com/elasticloadbalancing/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Microservices Architecture',
            'description' => 'Learn microservices: service boundaries, communication, API gateways, service mesh.',
            'day_number' => 5,
            'estimated_time_minutes' => 300,
            'task_type' => 'reading',
            'category' => 'Architecture',
            'order' => 5,
            'resources_links' => [
                'https://microservices.io/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Event-Driven Architecture',
            'description' => 'Design event-driven systems: message queues, pub/sub, event sourcing, CQRS.',
            'day_number' => 6,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Architecture',
            'order' => 6,
            'resources_links' => [
                'https://aws.amazon.com/event-driven-architecture/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Design Patterns in Practice',
            'description' => 'Apply design patterns: Repository, Factory, Strategy, Observer, Dependency Injection.',
            'day_number' => 7,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Architecture',
            'order' => 7,
            'resources_links' => [
                'https://refactoring.guru/design-patterns',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Database Mastery
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Advanced SQL and Query Optimization',
            'description' => 'Master complex queries, window functions, CTEs, query execution plans.',
            'day_number' => 8,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Database',
            'order' => 8,
            'resources_links' => [
                'https://use-the-index-luke.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Database Indexing Strategies',
            'description' => 'Design optimal indexes: B-tree, hash, composite, covering indexes, analyze execution.',
            'day_number' => 9,
            'estimated_time_minutes' => 300,
            'task_type' => 'exercise',
            'category' => 'Database',
            'order' => 9,
            'resources_links' => [
                'https://use-the-index-luke.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Database Transactions and Locking',
            'description' => 'Master ACID properties, isolation levels, deadlocks, optimistic/pessimistic locking.',
            'day_number' => 10,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Database',
            'order' => 10,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Cloud & DevOps
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'AWS Fundamentals',
            'description' => 'Learn AWS core services: EC2, S3, RDS, Lambda, CloudFront, Route53.',
            'day_number' => 11,
            'estimated_time_minutes' => 360,
            'task_type' => 'reading',
            'category' => 'Cloud',
            'order' => 11,
            'resources_links' => [
                'https://aws.amazon.com/getting-started/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Infrastructure as Code with Terraform',
            'description' => 'Provision infrastructure using Terraform: resources, modules, state management.',
            'day_number' => 12,
            'estimated_time_minutes' => 360,
            'task_type' => 'exercise',
            'category' => 'DevOps',
            'order' => 12,
            'resources_links' => [
                'https://developer.hashicorp.com/terraform/tutorials',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Kubernetes Basics',
            'description' => 'Learn container orchestration: pods, services, deployments, scaling with K8s.',
            'day_number' => 13,
            'estimated_time_minutes' => 360,
            'task_type' => 'exercise',
            'category' => 'DevOps',
            'order' => 13,
            'resources_links' => [
                'https://kubernetes.io/docs/tutorials/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        // Leadership & Processes
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Code Review Best Practices',
            'description' => 'Learn effective code review: what to look for, feedback techniques, automation.',
            'day_number' => 14,
            'estimated_time_minutes' => 180,
            'task_type' => 'reading',
            'category' => 'Leadership',
            'order' => 14,
            'resources_links' => [
                'https://google.github.io/eng-practices/review/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Technical Documentation',
            'description' => 'Write architecture docs, API documentation, system design documents, ADRs.',
            'day_number' => 15,
            'estimated_time_minutes' => 240,
            'task_type' => 'exercise',
            'category' => 'Leadership',
            'order' => 15,
            'resources_links' => [
                'https://documentation.divio.com/',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Agile & Scrum Methodologies',
            'description' => 'Understand agile practices, sprint planning, estimation, retrospectives.',
            'day_number' => 16,
            'estimated_time_minutes' => 180,
            'task_type' => 'reading',
            'category' => 'Leadership',
            'order' => 16,
            'resources_links' => [
                'https://www.scrum.org/resources/what-is-scrum',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);

        // Senior Projects
        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Design a URL Shortener',
            'description' => 'System design exercise: design scalable URL shortener with analytics.',
            'day_number' => 17,
            'estimated_time_minutes' => 480,
            'task_type' => 'project',
            'category' => 'System Design Projects',
            'order' => 17,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Design a Social Media Feed',
            'description' => 'System design: design news feed system handling millions of users.',
            'day_number' => 18,
            'estimated_time_minutes' => 480,
            'task_type' => 'project',
            'category' => 'System Design Projects',
            'order' => 18,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Design a Video Streaming Platform',
            'description' => 'System design: design YouTube-like platform with video processing, CDN, recommendations.',
            'day_number' => 19,
            'estimated_time_minutes' => 600,
            'task_type' => 'project',
            'category' => 'System Design Projects',
            'order' => 19,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Multi-Tenant SaaS Platform',
            'description' => 'Create a complete SaaS: multi-tenancy, subscriptions, billing, admin dashboard.',
            'day_number' => 20,
            'estimated_time_minutes' => 960,
            'task_type' => 'project',
            'category' => 'Implementation Projects',
            'order' => 20,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Build a Real-Time Analytics Dashboard',
            'description' => 'Create real-time analytics system with data pipeline, visualization, alerts.',
            'day_number' => 25,
            'estimated_time_minutes' => 960,
            'task_type' => 'project',
            'category' => 'Implementation Projects',
            'order' => 21,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Open Source Contribution',
            'description' => 'Contribute to a major open-source project: find issue, submit PR, code review.',
            'day_number' => 30,
            'estimated_time_minutes' => 480,
            'task_type' => 'project',
            'category' => 'Community',
            'order' => 22,
            'resources_links' => [
                'https://github.com/topics/good-first-issue',
            ],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Final Capstone - Enterprise Application',
            'description' => 'Build a production-grade enterprise application: microservices, cloud deployment, monitoring, CI/CD, comprehensive testing, documentation.',
            'day_number' => 35,
            'estimated_time_minutes' => 2400,
            'task_type' => 'project',
            'category' => 'Capstone',
            'order' => 23,
            'resources_links' => [],
            'has_code_submission' => true,
            'has_quality_rating' => true,
        ]);

        Task::create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Senior Developer Interview Prep',
            'description' => 'Prepare for senior interviews: system design practice, behavioral questions, technical deep dives.',
            'day_number' => 40,
            'estimated_time_minutes' => 480,
            'task_type' => 'reading',
            'category' => 'Career',
            'order' => 24,
            'resources_links' => [
                'https://github.com/donnemartin/system-design-primer',
                'https://www.techinterviewhandbook.org/',
            ],
            'has_code_submission' => false,
            'has_quality_rating' => true,
        ]);
    }

}
