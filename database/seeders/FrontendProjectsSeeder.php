<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class FrontendProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();
        $frontendIntermediate = Roadmap::where('slug', 'phase-3-frontend-intermediate')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? 1,
            'title' => 'Frontend Projects Portfolio',
            'description' => 'Build real-world frontend projects to solidify your skills and create an impressive portfolio. Each project focuses on different aspects of modern frontend development.',
            'slug' => 'frontend-projects',
            'duration_days' => 10,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 4,
            'prerequisite_roadmap_id' => $frontendIntermediate->id ?? null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'Project 1: Landing Page with Animations',
                'description' => 'Build a modern, responsive landing page with smooth animations and transitions using CSS animations and JavaScript.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Frontend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['CSS Animations', 'Responsive Design', 'UI/UX'],
                'tags' => ['html', 'css', 'animations', 'responsive'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=0YFrGy_mzjY', 'title' => 'Animated Landing Page Tutorial', 'type' => 'video'],
                    ['url' => 'https://animate.style/', 'title' => 'Animate.css Library', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 2: Interactive Dashboard UI',
                'description' => 'Create an interactive admin dashboard with charts, data tables, and responsive sidebar navigation.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Frontend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Dashboard Design', 'Data Visualization', 'Component Structure'],
                'tags' => ['dashboard', 'charts', 'data-visualization', 'ui'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=PkZNo7MFNFg', 'title' => 'Build Responsive Admin Dashboard', 'type' => 'video'],
                    ['url' => 'https://www.chartjs.org/', 'title' => 'Chart.js Documentation', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 3: Weather App with API Integration',
                'description' => 'Build a weather application that fetches real-time data from a weather API and displays it beautifully.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Frontend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['API Integration', 'Async JavaScript', 'Error Handling'],
                'tags' => ['api', 'fetch', 'async', 'javascript'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=MIYQR-Ybrn4', 'title' => 'Weather App with API', 'type' => 'video'],
                    ['url' => 'https://openweathermap.org/api', 'title' => 'OpenWeather API', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 4: Todo App with Local Storage',
                'description' => 'Create a full-featured todo application with CRUD operations, filters, and local storage persistence.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Frontend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['State Management', 'Local Storage', 'CRUD Operations'],
                'tags' => ['todo', 'crud', 'local-storage', 'javascript'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=Ttf3CEsEwMQ', 'title' => 'Todo App Tutorial', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Window/localStorage', 'title' => 'Local Storage API', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 5: E-commerce Product Page',
                'description' => 'Build a product page with image gallery, variant selection, cart functionality, and responsive design.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Frontend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['E-commerce UI', 'Shopping Cart', 'Product Display'],
                'tags' => ['e-commerce', 'product-page', 'cart', 'javascript'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=023Psne_-_4', 'title' => 'Product Page Tutorial', 'type' => 'video'],
                    ['url' => 'https://swiperjs.com/', 'title' => 'Swiper Image Gallery', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 6: Portfolio Website',
                'description' => 'Create your own portfolio website showcasing your projects, skills, and contact information.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Frontend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Portfolio Design', 'Personal Branding', 'Form Handling'],
                'tags' => ['portfolio', 'personal-website', 'showcase'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=sUKptmUVIBM', 'title' => 'Portfolio Website Tutorial', 'type' => 'video'],
                    ['url' => 'https://formspree.io/', 'title' => 'Formspree - Contact Forms', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 7: Quiz Application',
                'description' => 'Build an interactive quiz app with timer, score tracking, and results display.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Frontend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Game Logic', 'Timer Implementation', 'Score Tracking'],
                'tags' => ['quiz', 'game', 'timer', 'javascript'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=riDzcEQbX6k', 'title' => 'Quiz App Tutorial', 'type' => 'video'],
                    ['url' => 'https://opentdb.com/', 'title' => 'Open Trivia Database API', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 8: Movie Search App',
                'description' => 'Create a movie search application using TMDB API with search, filters, and detailed movie pages.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Frontend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Search Implementation', 'API Integration', 'Routing'],
                'tags' => ['api', 'search', 'movies', 'javascript'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=9Bvt6BFf6_U', 'title' => 'Movie App Tutorial', 'type' => 'video'],
                    ['url' => 'https://www.themoviedb.org/documentation/api', 'title' => 'TMDB API', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 9: Recipe App with Filters',
                'description' => 'Build a recipe application with search, category filters, and detailed recipe views using a recipe API.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Frontend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Filtering Logic', 'Card Layouts', 'API Management'],
                'tags' => ['recipes', 'filters', 'api', 'javascript'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=x8EY0BlhPGk', 'title' => 'Recipe App Tutorial', 'type' => 'video'],
                    ['url' => 'https://www.themealdb.com/api.php', 'title' => 'TheMealDB API', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 10: Blog with Dark Mode',
                'description' => 'Create a blog layout with article cards, reading view, dark mode toggle, and local storage for theme preference.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Frontend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Theme Switching', 'Blog Design', 'State Persistence'],
                'tags' => ['blog', 'dark-mode', 'theme', 'css'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=xodD0nw2veQ', 'title' => 'Dark Mode Tutorial', 'type' => 'video'],
                    ['url' => 'https://css-tricks.com/a-complete-guide-to-dark-mode-on-the-web/', 'title' => 'Dark Mode Guide', 'type' => 'article'],
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
                'has_quality_rating' => true,
            ]));
        }
    }
}
