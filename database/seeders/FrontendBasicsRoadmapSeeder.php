<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FrontendBasicsRoadmapSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();
        $phase1 = Roadmap::where('slug', 'phase-1-foundation')->first();

        $roadmap = Roadmap::create([
            'creator_id' => 1,
            'title' => 'Phase 2: Frontend Basics',
            'description' => 'Learn HTML, CSS (Flexbox, Grid), responsive design, JavaScript fundamentals, DOM manipulation, ES6+, async programming, Fetch API, and error handling.',
            'slug' => 'phase-2-frontend-basics',
            'creator_id' => $admin->id ?? null,
            'duration_days' => 14,
            'difficulty_level' => 'beginner',
            'is_published' => true,
            'is_featured' => false,
            'order' => 3,
            'prerequisite_roadmap_id' => $phase1->id ?? null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'HTML - Semantic HTML',
                'description' => 'Master HTML5 semantic elements, document structure, accessibility, and best practices for writing clean markup.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'HTML',
                'learning_objectives' => ['Master HTML5 semantic elements', 'Build accessible HTML structure', 'Use proper document hierarchy'],
                'skills_gained' => ['HTML5', 'Semantic Markup', 'Accessibility'],
                'tags' => ['html', 'semantic', 'frontend'],
                'success_criteria' => ['Can structure pages with semantic HTML', 'Understands accessibility', 'Can create valid HTML documents'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=pQN-pnXPaVg', 'title' => 'freeCodeCamp - HTML Full Course', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Learn/Getting_started_with_the_web/HTML_basics', 'title' => 'HTML Basics - MDN', 'type' => 'article'],
                    ['url' => 'https://web.dev/learn/html/semantic-html', 'title' => 'Semantic HTML - web.dev', 'type' => 'article'],
                    ['url' => '#', 'title' => 'HTML and CSS by Jon Duckett (Chapters 1-8)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Learning Web Design by Jennifer Robbins (Part II)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'HTML Forms',
                'description' => 'Learn to create and validate HTML forms, understand form elements, input types, and form submission.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'HTML',
                'learning_objectives' => ['Create complex HTML forms', 'Understand form validation', 'Handle form submission'],
                'skills_gained' => ['HTML Forms', 'Form Validation', 'User Input'],
                'tags' => ['html', 'forms', 'validation'],
                'success_criteria' => ['Can create functional forms', 'Understands form validation', 'Can handle user input'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=fNcJuPIZ2WE', 'title' => 'Web Dev Simplified - HTML Forms', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Learn/Forms', 'title' => 'HTML Forms - MDN', 'type' => 'article'],
                    ['url' => 'https://web.dev/learn/forms/', 'title' => 'Form Validation - web.dev', 'type' => 'article'],
                    ['url' => '#', 'title' => 'HTML and CSS by Jon Duckett (Chapter 7)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Form Design Patterns by Adam Silver (Chapters 1-4)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Accessibility Basics',
                'description' => 'Understand web accessibility principles, ARIA attributes, and inclusive design practices.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'Accessibility',
                'learning_objectives' => ['Understand accessibility principles', 'Implement ARIA attributes', 'Create inclusive designs'],
                'skills_gained' => ['Web Accessibility', 'ARIA', 'Inclusive Design'],
                'tags' => ['accessibility', 'a11y', 'aria'],
                'success_criteria' => ['Can implement accessible features', 'Understands ARIA', 'Can test accessibility'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=z8xUCzToff8', 'title' => 'Traversy Media - Web Accessibility', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Learn/Accessibility', 'title' => 'Accessibility - MDN', 'type' => 'article'],
                    ['url' => 'https://w3.org/WAI/fundamentals/accessibility-intro/', 'title' => 'Web Accessibility Guide - W3C', 'type' => 'article'],
                    ['url' => '#', 'title' => 'A Web for Everyone by Sarah Horton', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Inclusive Design Patterns by Heydon Pickering', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'SEO Basics',
                'description' => 'Learn SEO fundamentals, meta tags, semantic HTML for SEO, and search engine optimization best practices.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'SEO',
                'learning_objectives' => ['Understand SEO basics', 'Implement meta tags', 'Optimize content for search'],
                'skills_gained' => ['SEO', 'Meta Tags', 'Search Optimization'],
                'tags' => ['seo', 'optimization', 'search'],
                'success_criteria' => ['Can optimize pages for SEO', 'Understands meta tags', 'Can implement basic SEO'],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/playlist?list=PLvJ_dXFSpd2vk6rQ4Rta5MhDIRmakFbp6', 'title' => 'Ahrefs - SEO Course for Beginners', 'type' => 'video'],
                    ['url' => 'https://developers.google.com/search/docs/fundamentals/seo-starter-guide', 'title' => 'SEO Starter Guide - Google', 'type' => 'article'],
                    ['url' => 'https://moz.com/beginners-guide-to-seo', 'title' => 'Learn SEO - Moz', 'type' => 'article'],
                    ['url' => '#', 'title' => 'The Art of SEO (Chapters 1-5)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'SEO 2024 by Adam Clarke', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'CSS - Selectors & Box Model',
                'description' => 'Master CSS selectors, specificity, the box model, margin, padding, and border properties.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'CSS',
                'learning_objectives' => ['Master CSS selectors', 'Understand box model', 'Control layout with CSS'],
                'skills_gained' => ['CSS', 'Box Model', 'Layout'],
                'tags' => ['css', 'selectors', 'box-model'],
                'success_criteria' => ['Can use complex selectors', 'Understands box model', 'Can control spacing'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=1Rs2ND1ryYc', 'title' => 'freeCodeCamp - CSS Full Course', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_selectors', 'title' => 'CSS Selectors - MDN', 'type' => 'article'],
                    ['url' => 'https://web.dev/learn/css/box-model', 'title' => 'Box Model - web.dev', 'type' => 'article'],
                    ['url' => '#', 'title' => 'CSS: The Definitive Guide (Chapters 1-8)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'HTML and CSS by Jon Duckett (Chapters 10-13)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'CSS Flexbox',
                'description' => 'Master CSS Flexbox for one-dimensional layouts, flex containers, flex items, and responsive design.',
                'estimated_time_minutes' => 47,
                'task_type' => 'video',
                'category' => 'CSS',
                'learning_objectives' => ['Master Flexbox layouts', 'Create responsive designs', 'Understand flex properties'],
                'skills_gained' => ['Flexbox', 'Responsive Design', 'CSS Layout'],
                'tags' => ['css', 'flexbox', 'layout'],
                'success_criteria' => ['Can create flex layouts', 'Understands flex properties', 'Can build responsive layouts'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=3YW65K6LcIA', 'title' => 'Traversy Media - Flexbox Crash Course', 'type' => 'video'],
                    ['url' => 'https://css-tricks.com/snippets/css/a-guide-to-flexbox/', 'title' => 'Flexbox Guide - CSS-Tricks', 'type' => 'article'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Learn/CSS/CSS_layout/Flexbox', 'title' => 'Flexbox - MDN', 'type' => 'article'],
                    ['url' => '#', 'title' => 'CSS: The Definitive Guide (Chapter 12)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Flexbox in CSS by Estelle Weyl', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'CSS Grid',
                'description' => 'Learn CSS Grid for two-dimensional layouts, grid containers, grid items, and complex layouts.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'CSS',
                'learning_objectives' => ['Master CSS Grid layouts', 'Create 2D layouts', 'Understand grid properties'],
                'skills_gained' => ['CSS Grid', '2D Layouts', 'Advanced CSS'],
                'tags' => ['css', 'grid', 'layout'],
                'success_criteria' => ['Can create grid layouts', 'Understands grid properties', 'Can build complex layouts'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=jV8B24rSN5o', 'title' => 'Traversy Media - CSS Grid Crash Course', 'type' => 'video'],
                    ['url' => 'https://css-tricks.com/snippets/css/complete-guide-grid/', 'title' => 'CSS Grid Guide - CSS-Tricks', 'type' => 'article'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_grid_layout', 'title' => 'Grid - MDN', 'type' => 'article'],
                    ['url' => '#', 'title' => 'CSS: The Definitive Guide (Chapter 13)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Get Ready for CSS Grid Layout by Rachel Andrew', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Responsive Design & Media Queries',
                'description' => 'Master responsive web design principles, media queries, mobile-first approach, and breakpoints.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'CSS',
                'learning_objectives' => ['Create responsive designs', 'Use media queries effectively', 'Implement mobile-first approach'],
                'skills_gained' => ['Responsive Design', 'Media Queries', 'Mobile-First'],
                'tags' => ['responsive', 'media-queries', 'mobile'],
                'success_criteria' => ['Can create responsive layouts', 'Understands breakpoints', 'Can implement mobile-first'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=srvUrASNj0s', 'title' => 'Traversy Media - Responsive Layouts', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Learn/CSS/CSS_layout/Responsive_Design', 'title' => 'Responsive Design - MDN', 'type' => 'article'],
                    ['url' => 'https://web.dev/learn/design/media-queries', 'title' => 'Media Queries - web.dev', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Responsive Web Design by Ethan Marcotte', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Learning Responsive Web Design O\'Reilly', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'JavaScript - DOM Manipulation',
                'description' => 'Learn to manipulate the DOM, select elements, modify content, and create dynamic web pages.',
                'estimated_time_minutes' => 116,
                'task_type' => 'video',
                'category' => 'JavaScript',
                'learning_objectives' => ['Manipulate DOM elements', 'Select elements dynamically', 'Create interactive pages'],
                'skills_gained' => ['DOM Manipulation', 'JavaScript', 'Dynamic Content'],
                'tags' => ['javascript', 'dom', 'manipulation'],
                'success_criteria' => ['Can manipulate DOM', 'Can select elements', 'Can create dynamic content'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/playlist?list=PLillGF-RfqbYE6Ik_EuXA2iZFcE082B3s', 'title' => 'Traversy Media - JavaScript DOM Crash Course', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Document_Object_Model/Introduction', 'title' => 'DOM Introduction - MDN', 'type' => 'article'],
                    ['url' => 'https://javascript.info/dom-nodes', 'title' => 'DOM Tutorial - javascript.info', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Eloquent JavaScript (Chapter 14-15)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'JavaScript and JQuery by Jon Duckett (Chapters 5-7)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'JavaScript Events',
                'description' => 'Master event handling, event listeners, event delegation, and interactive user interfaces.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'JavaScript',
                'learning_objectives' => ['Handle user events', 'Implement event listeners', 'Use event delegation'],
                'skills_gained' => ['Event Handling', 'Event Listeners', 'Interactivity'],
                'tags' => ['javascript', 'events', 'listeners'],
                'success_criteria' => ['Can handle events', 'Understands event delegation', 'Can create interactive UIs'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=ndz6iH6o1ms', 'title' => 'The Net Ninja - JavaScript Events', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Building_blocks/Events', 'title' => 'Events - MDN', 'type' => 'article'],
                    ['url' => 'https://javascript.info/events', 'title' => 'Events - javascript.info', 'type' => 'article'],
                    ['url' => '#', 'title' => 'JavaScript and JQuery by Jon Duckett (Chapter 6)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'JavaScript: The Definitive Guide (Chapter 15)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'ES6+ Features',
                'description' => 'Learn modern JavaScript features: arrow functions, destructuring, spread/rest, template literals, and more.',
                'estimated_time_minutes' => 65,
                'task_type' => 'video',
                'category' => 'JavaScript',
                'learning_objectives' => ['Master ES6+ syntax', 'Use modern JavaScript features', 'Write cleaner code'],
                'skills_gained' => ['ES6+', 'Modern JavaScript', 'Clean Code'],
                'tags' => ['javascript', 'es6', 'modern'],
                'success_criteria' => ['Can use ES6+ features', 'Understands modern syntax', 'Can write clean code'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=nZ1DMMsyVyI', 'title' => 'freeCodeCamp - ES6 Full Course', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference', 'title' => 'ES6 Features - MDN', 'type' => 'article'],
                    ['url' => 'https://javascript.info/', 'title' => 'ES6 Overview - javascript.info', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Understanding ECMAScript 6 by Nicholas Zakas', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Exploring ES6 by Dr. Axel Rauschmayer (Free Online)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Async JavaScript (Promises, Async/Await)',
                'description' => 'Master asynchronous JavaScript, promises, async/await, and handling asynchronous operations.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'JavaScript',
                'learning_objectives' => ['Understand async programming', 'Use promises effectively', 'Master async/await'],
                'skills_gained' => ['Async JavaScript', 'Promises', 'Async/Await'],
                'tags' => ['javascript', 'async', 'promises'],
                'success_criteria' => ['Can handle async operations', 'Understands promises', 'Can use async/await'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=PoRJizFvM7s', 'title' => 'Traversy Media - Async JS', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise', 'title' => 'Promises - MDN', 'type' => 'article'],
                    ['url' => 'https://javascript.info/async-await', 'title' => 'Async/Await - javascript.info', 'type' => 'article'],
                    ['url' => '#', 'title' => 'You Don\'t Know JS: Async & Performance', 'type' => 'book'],
                    ['url' => '#', 'title' => 'JavaScript: The Definitive Guide (Chapter 13)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Fetch API & HTTP Requests',
                'description' => 'Learn to make HTTP requests using Fetch API, handle responses, and work with RESTful APIs.',
                'estimated_time_minutes' => 31,
                'task_type' => 'video',
                'category' => 'JavaScript',
                'learning_objectives' => ['Use Fetch API', 'Make HTTP requests', 'Handle API responses'],
                'skills_gained' => ['Fetch API', 'HTTP Requests', 'REST APIs'],
                'tags' => ['javascript', 'fetch', 'api'],
                'success_criteria' => ['Can use Fetch API', 'Can handle responses', 'Can work with APIs'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=Oive66jrwBs', 'title' => 'Traversy Media - Fetch API', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API', 'title' => 'Fetch API - MDN', 'type' => 'article'],
                    ['url' => 'https://javascript.info/fetch', 'title' => 'Fetch - javascript.info', 'type' => 'article'],
                    ['url' => '#', 'title' => 'JavaScript: The Definitive Guide (Chapter 15)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Learning JavaScript by Ethan Brown (Chapter 18)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Error Handling',
                'description' => 'Master error handling in JavaScript, try/catch blocks, error objects, and debugging techniques.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'JavaScript',
                'learning_objectives' => ['Handle errors properly', 'Use try/catch blocks', 'Debug effectively'],
                'skills_gained' => ['Error Handling', 'Debugging', 'Exception Handling'],
                'tags' => ['javascript', 'errors', 'debugging'],
                'success_criteria' => ['Can handle errors', 'Understands try/catch', 'Can debug code'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=ye-aIwGJKNg', 'title' => 'The Net Ninja - Try Catch', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Control_flow_and_error_handling', 'title' => 'Error Handling - MDN', 'type' => 'article'],
                    ['url' => 'https://javascript.info/error-handling', 'title' => 'Error Handling - javascript.info', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Eloquent JavaScript (Chapter 8)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'JavaScript: The Good Parts (Chapter 7)', 'type' => 'book'],
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
                'has_quality_rating' => false,
            ]));
        }
    }
}
