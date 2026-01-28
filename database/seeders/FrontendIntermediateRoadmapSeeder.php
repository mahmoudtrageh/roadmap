<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FrontendIntermediateRoadmapSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();
        $phase2 = Roadmap::where('slug', 'phase-2-frontend-basics')->first();

        $roadmap = Roadmap::create([
            'creator_id' => 1,
            'title' => 'Phase 3: Frontend Intermediate',
            'description' => 'Master SASS/SCSS, Tailwind CSS, BEM, advanced JavaScript (closures, prototypes, event loop), modules, Web APIs, NPM, build tools (Vite/Webpack), and React with hooks, state management, and routing.',
            'slug' => 'phase-3-frontend-intermediate',
            'creator_id' => $admin->id ?? null,
            'duration_days' => 13,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 4,
            'prerequisite_roadmap_id' => $phase2->id ?? null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'SASS/SCSS',
                'description' => 'Master SASS/SCSS preprocessor, variables, nesting, mixins, functions, and modular CSS architecture.',
                'estimated_time_minutes' => 48,
                'task_type' => 'video',
                'category' => 'CSS',
                'learning_objectives' => ['Master SASS syntax', 'Use variables and mixins', 'Create modular stylesheets'],
                'skills_gained' => ['SASS', 'SCSS', 'CSS Preprocessing', 'Modular CSS'],
                'tags' => ['sass', 'scss', 'css', 'preprocessor'],
                'success_criteria' => ['Can write SASS code', 'Understands nesting and mixins', 'Can organize styles modularly'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=nu5mdN2JIwM', 'title' => 'Traversy Media - SASS Crash Course', 'type' => 'video'],
                    ['url' => 'https://sass-lang.com/documentation', 'title' => 'SASS Documentation', 'type' => 'article'],
                    ['url' => 'https://sass-guidelin.es/', 'title' => 'SASS Guidelines', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Jump Start Sass by Hugo Giraudel', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Sass and Compass in Action', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Tailwind CSS',
                'description' => 'Learn utility-first CSS with Tailwind, rapid UI development, customization, and responsive design.',
                'estimated_time_minutes' => 96,
                'task_type' => 'video',
                'category' => 'CSS',
                'learning_objectives' => ['Master Tailwind utilities', 'Build UIs rapidly', 'Customize Tailwind configuration'],
                'skills_gained' => ['Tailwind CSS', 'Utility-First CSS', 'Rapid Development'],
                'tags' => ['tailwind', 'css', 'utility-first', 'framework'],
                'success_criteria' => ['Can use Tailwind classes', 'Can customize configuration', 'Can build responsive UIs'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=dFgzHOX84xQ', 'title' => 'Traversy Media - Tailwind Crash Course', 'type' => 'video'],
                    ['url' => 'https://tailwindcss.com/docs', 'title' => 'Tailwind Documentation', 'type' => 'article'],
                    ['url' => 'https://tailwindcss.com/docs/utility-first', 'title' => 'Tailwind Best Practices', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Tailwind CSS by Noel Rappin', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Refactoring UI by Adam Wathan', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'CSS Architecture (BEM)',
                'description' => 'Master CSS naming conventions, BEM methodology, and scalable CSS architecture patterns.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'CSS',
                'learning_objectives' => ['Understand BEM methodology', 'Write maintainable CSS', 'Organize large stylesheets'],
                'skills_gained' => ['BEM', 'CSS Architecture', 'Naming Conventions'],
                'tags' => ['bem', 'css', 'architecture', 'methodology'],
                'success_criteria' => ['Can use BEM naming', 'Understands CSS organization', 'Can maintain large codebases'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=SLjHSVwXYq4', 'title' => 'Kevin Powell - BEM Explained', 'type' => 'video'],
                    ['url' => 'https://getbem.com/', 'title' => 'BEM Documentation', 'type' => 'article'],
                    ['url' => 'https://css-tricks.com/bem-101/', 'title' => 'BEM 101 - CSS-Tricks', 'type' => 'article'],
                    ['url' => '#', 'title' => 'CSS Refactoring by Steve Lindstrom', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Enduring CSS by Ben Frain', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'JavaScript Deep Dive - Closures & Prototypes',
                'description' => 'Master advanced JavaScript concepts: closures, prototypes, prototype chain, and object-oriented patterns.',
                'estimated_time_minutes' => 61,
                'task_type' => 'video',
                'category' => 'JavaScript',
                'learning_objectives' => ['Master closures', 'Understand prototypes', 'Grasp prototype chain'],
                'skills_gained' => ['Closures', 'Prototypes', 'Advanced JavaScript', 'OOP'],
                'tags' => ['javascript', 'closures', 'prototypes', 'advanced'],
                'success_criteria' => ['Can use closures effectively', 'Understands prototype chain', 'Can implement OOP patterns'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=2ZphE5HcQPQ', 'title' => 'Programming with Mosh - JavaScript Prototypes', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Closures', 'title' => 'Closures - MDN', 'type' => 'article'],
                    ['url' => 'https://javascript.info/prototypes', 'title' => 'Prototypes - javascript.info', 'type' => 'article'],
                    ['url' => '#', 'title' => 'You Don\'t Know JS: Scope & Closures', 'type' => 'book'],
                    ['url' => '#', 'title' => 'JavaScript: The Good Parts (Chapters 4-5)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Event Loop & Asynchronous Patterns',
                'description' => 'Understand JavaScript event loop, call stack, callback queue, and asynchronous execution patterns.',
                'estimated_time_minutes' => 42,
                'task_type' => 'video',
                'category' => 'JavaScript',
                'learning_objectives' => ['Understand event loop', 'Master async patterns', 'Debug async code'],
                'skills_gained' => ['Event Loop', 'Async Patterns', 'JavaScript Internals'],
                'tags' => ['javascript', 'event-loop', 'async', 'patterns'],
                'success_criteria' => ['Can explain event loop', 'Understands async execution', 'Can debug async code'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=8zKuNo4ay8E', 'title' => 'Akshay Saini - Event Loop', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Event_loop', 'title' => 'Event Loop - MDN', 'type' => 'article'],
                    ['url' => 'https://javascript.info/event-loop', 'title' => 'Event Loop - javascript.info', 'type' => 'article'],
                    ['url' => '#', 'title' => 'You Don\'t Know JS: Async & Performance (Chapters 1-2)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'JavaScript: The Definitive Guide (Chapter 13)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'JavaScript Modules',
                'description' => 'Master ES6 modules, import/export, module patterns, and code organization.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'JavaScript',
                'learning_objectives' => ['Use ES6 modules', 'Organize code with modules', 'Understand module bundling'],
                'skills_gained' => ['ES6 Modules', 'Code Organization', 'Module Patterns'],
                'tags' => ['javascript', 'modules', 'es6', 'organization'],
                'success_criteria' => ['Can use import/export', 'Understands module patterns', 'Can organize large projects'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=cRHQNNcYf6s', 'title' => 'Traversy Media - ES6 Modules', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules', 'title' => 'Modules - MDN', 'type' => 'article'],
                    ['url' => 'https://javascript.info/modules-intro', 'title' => 'Modules - javascript.info', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Exploring ES6 - Modules Chapter', 'type' => 'book'],
                    ['url' => '#', 'title' => 'JavaScript: The Definitive Guide (Chapter 10)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Web APIs & Browser Storage',
                'description' => 'Master browser APIs: LocalStorage, SessionStorage, IndexedDB, Web Storage, and browser features.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'JavaScript',
                'learning_objectives' => ['Use browser storage APIs', 'Implement data persistence', 'Work with Web APIs'],
                'skills_gained' => ['Web APIs', 'LocalStorage', 'Browser Storage', 'Data Persistence'],
                'tags' => ['javascript', 'web-apis', 'storage', 'browser'],
                'success_criteria' => ['Can use LocalStorage', 'Understands storage options', 'Can persist data'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=AUOzvFzdIk4', 'title' => 'Traversy Media - Local Storage', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Web_Storage_API', 'title' => 'Web Storage API - MDN', 'type' => 'article'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/API', 'title' => 'Web APIs Overview - MDN', 'type' => 'article'],
                    ['url' => '#', 'title' => 'JavaScript: The Definitive Guide (Chapter 15)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'High Performance Browser Networking (Chapters 14-16)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'NPM & Package Management',
                'description' => 'Learn NPM package management, package.json, dependency management, and npm scripts.',
                'estimated_time_minutes' => 42,
                'task_type' => 'video',
                'category' => 'Tools',
                'learning_objectives' => ['Use NPM effectively', 'Manage dependencies', 'Create npm scripts'],
                'skills_gained' => ['NPM', 'Package Management', 'Dependencies', 'Build Scripts'],
                'tags' => ['npm', 'packages', 'dependencies', 'tools'],
                'success_criteria' => ['Can use NPM commands', 'Can manage dependencies', 'Can create scripts'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=jHDhaSSKmB0', 'title' => 'Traversy Media - NPM Crash Course', 'type' => 'video'],
                    ['url' => 'https://docs.npmjs.com/', 'title' => 'NPM Documentation', 'type' => 'article'],
                    ['url' => 'https://digitalocean.com/community/tutorials/how-to-use-node-js-modules-with-npm-and-package-json', 'title' => 'NPM Guide - DigitalOcean', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Node.js Design Patterns (Chapter 1-2)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Learning Node.js Development (Chapter 2)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Build Tools (Vite, Webpack)',
                'description' => 'Master modern build tools, bundlers, Vite for fast development, and Webpack configuration.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'Tools',
                'learning_objectives' => ['Use Vite for development', 'Understand bundling', 'Configure build tools'],
                'skills_gained' => ['Vite', 'Webpack', 'Build Tools', 'Module Bundling'],
                'tags' => ['vite', 'webpack', 'build-tools', 'bundlers'],
                'success_criteria' => ['Can use Vite', 'Understands bundling', 'Can configure tools'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=89NJdbYTgJ8', 'title' => 'Traversy Media - Vite Crash Course', 'type' => 'video'],
                    ['url' => 'https://vitejs.dev/guide/', 'title' => 'Vite Documentation', 'type' => 'article'],
                    ['url' => 'https://webpack.js.org/guides/getting-started/', 'title' => 'Webpack Getting Started', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Webpack 5 Up and Running', 'type' => 'book'],
                    ['url' => '#', 'title' => 'SurviveJS - Webpack (Free Online)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'React Fundamentals',
                'description' => 'Master React basics: components, JSX, props, state, and component lifecycle.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'React',
                'learning_objectives' => ['Build React components', 'Manage component state', 'Pass data with props'],
                'skills_gained' => ['React', 'Components', 'JSX', 'State Management'],
                'tags' => ['react', 'components', 'jsx', 'frontend'],
                'success_criteria' => ['Can create React components', 'Understands state and props', 'Can build React apps'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=LDB4uaJ87e0', 'title' => 'Traversy Media - React Crash Course', 'type' => 'video'],
                    ['url' => 'https://react.dev/learn', 'title' => 'React Documentation', 'type' => 'article'],
                    ['url' => 'https://w3schools.com/react/', 'title' => 'React Tutorial - W3Schools', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Learning React by Alex Banks', 'type' => 'book'],
                    ['url' => '#', 'title' => 'The Road to React by Robin Wieruch', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'React Hooks',
                'description' => 'Master React Hooks: useState, useEffect, useContext, custom hooks, and functional components.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'React',
                'learning_objectives' => ['Master React Hooks', 'Use useState and useEffect', 'Create custom hooks'],
                'skills_gained' => ['React Hooks', 'Functional Components', 'Custom Hooks'],
                'tags' => ['react', 'hooks', 'usestate', 'useeffect'],
                'success_criteria' => ['Can use React Hooks', 'Can create custom hooks', 'Understands hooks lifecycle'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/playlist?list=PLZlA0Gpn_vH8EtggFGERCwMY5u5hOjf-h', 'title' => 'Web Dev Simplified - React Hooks', 'type' => 'video'],
                    ['url' => 'https://react.dev/reference/react/hooks', 'title' => 'Hooks at a Glance - React', 'type' => 'article'],
                    ['url' => 'https://legacy.reactjs.org/docs/hooks-faq.html', 'title' => 'Hooks FAQ - React', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Learning React (Chapters 6-7)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'React Hooks in Action by John Larsen', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'React State Management',
                'description' => 'Master state management in React: Context API, Redux, Redux Toolkit, and global state patterns.',
                'estimated_time_minutes' => 69,
                'task_type' => 'video',
                'category' => 'React',
                'learning_objectives' => ['Manage global state', 'Use Context API', 'Implement Redux'],
                'skills_gained' => ['State Management', 'Redux', 'Context API', 'Global State'],
                'tags' => ['react', 'redux', 'state', 'context'],
                'success_criteria' => ['Can manage global state', 'Understands Redux', 'Can use Context API'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=93p3LxR9xfM', 'title' => 'Traversy Media - Redux Crash Course', 'type' => 'video'],
                    ['url' => 'https://redux.js.org/introduction/getting-started', 'title' => 'Redux Documentation', 'type' => 'article'],
                    ['url' => 'https://react.dev/reference/react/useContext', 'title' => 'Context API - React', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Learning Redux by Daniel Bugl', 'type' => 'book'],
                    ['url' => '#', 'title' => 'The Road to Redux by Robin Wieruch', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'React Router',
                'description' => 'Master React Router for single-page applications, routing, navigation, and protected routes.',
                'estimated_time_minutes' => 46,
                'task_type' => 'video',
                'category' => 'React',
                'learning_objectives' => ['Implement routing', 'Create protected routes', 'Handle navigation'],
                'skills_gained' => ['React Router', 'Routing', 'Navigation', 'SPA'],
                'tags' => ['react', 'router', 'navigation', 'spa'],
                'success_criteria' => ['Can implement routing', 'Can create protected routes', 'Can handle navigation'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=Ul3y1LXxzdU', 'title' => 'Traversy Media - React Router v6', 'type' => 'video'],
                    ['url' => 'https://reactrouter.com/en/main', 'title' => 'React Router Documentation', 'type' => 'article'],
                    ['url' => 'https://reactrouter.com/en/main/start/tutorial', 'title' => 'React Router Tutorial', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Learning React (Chapter 11)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'React Router Quick Start Guide', 'type' => 'book'],
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
                'has_quality_rating' => false,
            ]));
        }
    }
}
