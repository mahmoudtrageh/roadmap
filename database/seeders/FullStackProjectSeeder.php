<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class FullStackProjectSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();
        $backendIntermediate = Roadmap::where('slug', 'phase-5-backend-intermediate')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? 1,
            'title' => 'Full Stack Capstone Project',
            'description' => 'Build a complete full-stack application from scratch. This capstone project combines all your skills: frontend, backend, database, authentication, deployment, and best practices.',
            'slug' => 'fullstack-capstone',
            'duration_days' => 15,
            'difficulty_level' => 'advanced',
            'is_published' => true,
            'is_featured' => false,
            'order' => 12,
            'prerequisite_roadmap_id' => null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'Day 1: Project Planning & Requirements',
                'description' => 'Define your project idea (e-commerce, social media, SaaS, etc.), create user stories, wireframes, and database schema. Plan features and tech stack.',
                'estimated_time_minutes' => 120,
                'task_type' => 'exercise',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['Project Planning', 'Requirements Analysis', 'System Design'],
                'tags' => ['planning', 'design', 'wireframes', 'schema'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://excalidraw.com/', 'title' => 'Excalidraw - Wireframing Tool', 'type' => 'article'],
                    ['url' => 'https://dbdiagram.io/', 'title' => 'dbdiagram.io - Database Design', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 2: Setup Development Environment',
                'description' => 'Setup project structure, initialize Git repository, configure frontend (React/Vue) and backend (Node.js/Laravel) projects, and setup database.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['Project Setup', 'Environment Configuration', 'Git'],
                'tags' => ['setup', 'git', 'environment', 'configuration'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://create-react-app.dev/', 'title' => 'Create React App', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/installation', 'title' => 'Laravel Installation', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 3: Database Design & Models',
                'description' => 'Create database migrations, models, and relationships. Setup seeders for test data and implement database validations.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['Database Design', 'ORM', 'Data Modeling'],
                'tags' => ['database', 'migrations', 'models', 'orm'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://laravel.com/docs/migrations', 'title' => 'Laravel Migrations', 'type' => 'article'],
                    ['url' => 'https://sequelize.org/docs/v6/core-concepts/model-basics/', 'title' => 'Sequelize Models', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 4: Authentication System',
                'description' => 'Implement complete authentication: user registration, login, JWT tokens, password reset, email verification, and protected routes.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['Authentication', 'JWT', 'Security', 'Email Verification'],
                'tags' => ['auth', 'jwt', 'security', 'email'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=mbsmsi7l3r4', 'title' => 'JWT Authentication', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/authentication', 'title' => 'Laravel Authentication', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 5: Core Backend API - Part 1',
                'description' => 'Build main CRUD endpoints for your core entities with validation, error handling, and proper HTTP status codes.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['REST API', 'Validation', 'Error Handling'],
                'tags' => ['api', 'crud', 'validation', 'rest'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://restfulapi.net/', 'title' => 'REST API Best Practices', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/validation', 'title' => 'Laravel Validation', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 6: Core Backend API - Part 2',
                'description' => 'Add advanced features: pagination, filtering, sorting, search, and relationships endpoints.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['Pagination', 'Filtering', 'Search', 'Advanced Queries'],
                'tags' => ['pagination', 'search', 'filter', 'api'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://laravel.com/docs/pagination', 'title' => 'Laravel Pagination', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/eloquent-relationships', 'title' => 'Eloquent Relationships', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 7: Frontend Layout & Routing',
                'description' => 'Create main layout, navigation, routing structure, and responsive design. Setup state management (Redux/Vuex/Context).',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['React Router', 'Layout Design', 'State Management'],
                'tags' => ['frontend', 'routing', 'layout', 'state'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://reactrouter.com/', 'title' => 'React Router', 'type' => 'article'],
                    ['url' => 'https://redux.js.org/', 'title' => 'Redux Documentation', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 8: Authentication UI',
                'description' => 'Build login, registration, password reset forms. Implement form validation, error display, and success messages.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['Form Handling', 'Validation', 'Auth UI'],
                'tags' => ['forms', 'validation', 'auth', 'ui'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://react-hook-form.com/', 'title' => 'React Hook Form', 'type' => 'article'],
                    ['url' => 'https://formik.org/', 'title' => 'Formik - Form Library', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 9: Main Features UI - Part 1',
                'description' => 'Build UI components for main features: list views, cards, tables, and detail pages. Connect to API.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['Component Design', 'API Integration', 'Data Display'],
                'tags' => ['components', 'api', 'ui', 'frontend'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://axios-http.com/', 'title' => 'Axios HTTP Client', 'type' => 'article'],
                    ['url' => 'https://tanstack.com/query/latest', 'title' => 'TanStack Query', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 10: Main Features UI - Part 2',
                'description' => 'Implement create/edit forms, modals, delete confirmations, and real-time updates. Add loading states and error handling.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['CRUD UI', 'State Management', 'Error Handling'],
                'tags' => ['forms', 'crud', 'state', 'ui'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://headlessui.com/', 'title' => 'Headless UI - Modals', 'type' => 'article'],
                    ['url' => 'https://react-hot-toast.com/', 'title' => 'React Hot Toast', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 11: Advanced Features',
                'description' => 'Add advanced features: file upload, image handling, search with debounce, filters, sorting, and pagination UI.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['File Upload', 'Search', 'Advanced Features'],
                'tags' => ['upload', 'search', 'pagination', 'filters'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://github.com/rpldy/react-uploady', 'title' => 'React Uploady', 'type' => 'article'],
                    ['url' => 'https://lodash.com/docs/#debounce', 'title' => 'Lodash Debounce', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 12: Testing & Quality Assurance',
                'description' => 'Write tests for backend (unit, integration) and frontend (components, integration). Achieve good test coverage.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['Testing', 'Jest', 'PHPUnit', 'Quality Assurance'],
                'tags' => ['testing', 'jest', 'phpunit', 'qa'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://jestjs.io/', 'title' => 'Jest Documentation', 'type' => 'article'],
                    ['url' => 'https://testing-library.com/react', 'title' => 'React Testing Library', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 13: Performance Optimization',
                'description' => 'Optimize application: lazy loading, code splitting, database query optimization, caching, image optimization, and bundle size reduction.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['Performance', 'Optimization', 'Caching', 'Code Splitting'],
                'tags' => ['performance', 'optimization', 'caching', 'lazy-loading'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://web.dev/performance/', 'title' => 'Web Performance Guide', 'type' => 'article'],
                    ['url' => 'https://react.dev/reference/react/lazy', 'title' => 'React Lazy Loading', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 14: Deployment & CI/CD',
                'description' => 'Deploy frontend (Vercel/Netlify), backend (Heroku/Railway), database (MongoDB Atlas/PlanetScale). Setup CI/CD with GitHub Actions.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['Deployment', 'CI/CD', 'DevOps', 'Production'],
                'tags' => ['deployment', 'ci-cd', 'production', 'devops'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://vercel.com/docs', 'title' => 'Vercel Deployment', 'type' => 'article'],
                    ['url' => 'https://docs.github.com/en/actions', 'title' => 'GitHub Actions', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Day 15: Documentation & Final Polish',
                'description' => 'Write comprehensive README, API documentation, setup instructions, and deployment guide. Add final UI polish and bug fixes.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Full Stack Project',
                'learning_objectives' => [],
                'skills_gained' => ['Documentation', 'Technical Writing', 'Project Completion'],
                'tags' => ['documentation', 'readme', 'polish', 'completion'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://readme.so/', 'title' => 'README Generator', 'type' => 'article'],
                    ['url' => 'https://swagger.io/', 'title' => 'Swagger API Documentation', 'type' => 'article'],
                ],
            ],
        ];

        $dayNumber = 1;
        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, [
                'roadmap_id' => $roadmap->id,
                'day_number' => $dayNumber++,
                'order' => 1,
                'difficulty_level' => 'advanced',
                'has_code_submission' => $taskData['has_code_submission'] ?? false,
                'has_quality_rating' => true,
            ]));
        }
    }
}
