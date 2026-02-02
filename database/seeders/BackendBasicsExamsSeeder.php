<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskExam;
use App\Models\ExamQuestion;
use Illuminate\Database\Seeder;

class BackendBasicsExamsSeeder extends Seeder
{
    public function run(): void
    {
        $roadmapId = 5; // Backend Basics

        $this->command->info("🎯 Creating exams for Backend Basics Roadmap...");

        $examsData = $this->getExamsData();

        $createdCount = 0;
        foreach ($examsData as $taskTitle => $questions) {
            $task = Task::where('roadmap_id', $roadmapId)
                ->where('title', 'like', '%' . $taskTitle . '%')
                ->first();

            if (!$task) {
                $this->command->warn("⚠️  Task not found: {$taskTitle}");
                continue;
            }

            if ($task->exam) {
                $task->exam->questions()->delete();
                $task->exam->delete();
            }

            $exam = TaskExam::create([
                'task_id' => $task->id,
                'questions_count' => 5,
                'passing_score' => 60,
            ]);

            foreach ($questions as $q) {
                ExamQuestion::create([
                    'task_exam_id' => $exam->id,
                    'question' => $q['question'],
                    'options' => $q['options'],
                    'correct_answer' => $q['correct_answer'],
                ]);
            }

            $this->command->info("✅ {$task->title}");
            $createdCount++;
        }

        $this->command->newLine();
        $this->command->info("✨ Created {$createdCount} exams for Backend Basics!");
    }

    private function getExamsData(): array
    {
        return [
            'PHP Fundamentals' => [
                ['question' => 'What does PHP stand for?', 'options' => ['Personal Home Page', 'PHP: Hypertext Preprocessor', 'Private Home Page', 'Programming Hypertext Processor'], 'correct_answer' => 1],
                ['question' => 'Which symbol is used to start a variable in PHP?', 'options' => ['@', '#', '$', '&'], 'correct_answer' => 2],
                ['question' => 'How do you output text in PHP?', 'options' => ['print()', 'echo', 'document.write()', 'console.log()'], 'correct_answer' => 1],
                ['question' => 'Which PHP tag is correct?', 'options' => ['<php></php>', '<?php ?>', '<? ?>', '<%php%>'], 'correct_answer' => 1],
                ['question' => 'What is the correct way to end a PHP statement?', 'options' => ['.', ';', ':', 'end'], 'correct_answer' => 1],
            ],

            'PHP OOP' => [
                ['question' => 'What does OOP stand for?', 'options' => ['Object Oriented PHP', 'Object Oriented Programming', 'Only One Programming', 'Open Object Protocol'], 'correct_answer' => 1],
                ['question' => 'Which keyword is used to create a class in PHP?', 'options' => ['function', 'class', 'object', 'new'], 'correct_answer' => 1],
                ['question' => 'What is a constructor in PHP?', 'options' => ['Method that destroys object', 'Method called when object is created', 'Property of class', 'Static method'], 'correct_answer' => 1],
                ['question' => 'Which keyword is used to inherit a class?', 'options' => ['implements', 'uses', 'extends', 'inherits'], 'correct_answer' => 2],
                ['question' => 'What is encapsulation in OOP?', 'options' => ['Creating classes', 'Bundling data and methods together', 'Deleting objects', 'Looping through arrays'], 'correct_answer' => 1],
            ],

            'Composer' => [
                ['question' => 'What is Composer?', 'options' => ['Text editor', 'Dependency manager for PHP', 'Web server', 'Database'], 'correct_answer' => 1],
                ['question' => 'Which file does Composer use to manage dependencies?', 'options' => ['package.json', 'composer.json', 'dependencies.json', 'vendor.json'], 'correct_answer' => 1],
                ['question' => 'What command installs dependencies using Composer?', 'options' => ['composer get', 'composer install', 'composer download', 'composer add'], 'correct_answer' => 1],
                ['question' => 'What is the vendor directory?', 'options' => ['Configuration folder', 'Folder where Composer installs packages', 'Database folder', 'Log folder'], 'correct_answer' => 1],
                ['question' => 'What does "composer update" do?', 'options' => ['Deletes packages', 'Updates packages to latest versions', 'Creates composer.json', 'Fixes bugs'], 'correct_answer' => 1],
            ],

            'Laravel Fundamentals' => [
                ['question' => 'What is Laravel?', 'options' => ['Database', 'PHP web framework', 'JavaScript library', 'CSS framework'], 'correct_answer' => 1],
                ['question' => 'What does MVC stand for?', 'options' => ['Model View Controller', 'Main Visual Code', 'Multiple View Class', 'Model Variable Control'], 'correct_answer' => 0],
                ['question' => 'Which artisan command starts Laravel development server?', 'options' => ['php artisan start', 'php artisan serve', 'php artisan run', 'php artisan server'], 'correct_answer' => 1],
                ['question' => 'What is Artisan in Laravel?', 'options' => ['Database', 'Command-line interface', 'Web server', 'Template engine'], 'correct_answer' => 1],
                ['question' => 'Where are routes defined in Laravel?', 'options' => ['app/Routes', 'routes/web.php', 'config/routes.php', 'public/routes.php'], 'correct_answer' => 1],
            ],

            'Laravel Blade' => [
                ['question' => 'What is Blade in Laravel?', 'options' => ['Database tool', 'Templating engine', 'Routing system', 'ORM'], 'correct_answer' => 1],
                ['question' => 'How do you echo a variable in Blade?', 'options' => ['<?= $var ?>', '{{ $var }}', '<% $var %>', 'echo $var'], 'correct_answer' => 1],
                ['question' => 'What does @extends do in Blade?', 'options' => ['Includes file', 'Inherits from layout', 'Creates loop', 'Defines variable'], 'correct_answer' => 1],
                ['question' => 'How do you create a foreach loop in Blade?', 'options' => ['@for', '@foreach', '@loop', '@each'], 'correct_answer' => 1],
                ['question' => 'What is @yield used for in Blade?', 'options' => ['Output variable', 'Define section placeholder', 'Include file', 'Create loop'], 'correct_answer' => 1],
            ],

            'Database Basics & SQL' => [
                ['question' => 'What does SQL stand for?', 'options' => ['Simple Query Language', 'Structured Query Language', 'Standard Question Logic', 'System Query List'], 'correct_answer' => 1],
                ['question' => 'Which SQL statement retrieves data from a database?', 'options' => ['GET', 'SELECT', 'RETRIEVE', 'FETCH'], 'correct_answer' => 1],
                ['question' => 'Which SQL statement inserts new data?', 'options' => ['ADD', 'INSERT', 'PUT', 'NEW'], 'correct_answer' => 1],
                ['question' => 'What does WHERE clause do in SQL?', 'options' => ['Sorts results', 'Filters results based on condition', 'Joins tables', 'Counts rows'], 'correct_answer' => 1],
                ['question' => 'What is a primary key?', 'options' => ['Encrypted key', 'Unique identifier for table row', 'Password', 'Foreign key'], 'correct_answer' => 1],
            ],

            'Laravel Migrations' => [
                ['question' => 'What are migrations in Laravel?', 'options' => ['Data backup', 'Version control for database schema', 'User authentication', 'File uploads'], 'correct_answer' => 1],
                ['question' => 'Which command creates a new migration?', 'options' => ['php artisan create:migration', 'php artisan make:migration', 'php artisan new:migration', 'php artisan migration:create'], 'correct_answer' => 1],
                ['question' => 'Which command runs pending migrations?', 'options' => ['php artisan migrate', 'php artisan migration:run', 'php artisan run:migrations', 'php artisan start:migrate'], 'correct_answer' => 0],
                ['question' => 'What does migration rollback do?', 'options' => ['Creates table', 'Reverts last migration batch', 'Runs migrations', 'Deletes database'], 'correct_answer' => 1],
                ['question' => 'Where are migration files stored?', 'options' => ['app/Migrations', 'database/migrations', 'config/migrations', 'storage/migrations'], 'correct_answer' => 1],
            ],

            'Eloquent ORM' => [
                ['question' => 'What is Eloquent in Laravel?', 'options' => ['Template engine', 'ORM for database interactions', 'Routing system', 'Cache system'], 'correct_answer' => 1],
                ['question' => 'What does ORM stand for?', 'options' => ['Object Relational Mapping', 'Only Remote Methods', 'Open Resource Management', 'Object Resource Model'], 'correct_answer' => 0],
                ['question' => 'How do you fetch all records using Eloquent?', 'options' => ['Model::get()', 'Model::all()', 'Model::fetch()', 'Model::select()'], 'correct_answer' => 1],
                ['question' => 'What is a model in Laravel?', 'options' => ['View file', 'Class representing database table', 'Controller method', 'Route definition'], 'correct_answer' => 1],
                ['question' => 'How do you save a model instance?', 'options' => ['$model->insert()', '$model->save()', '$model->store()', '$model->create()'], 'correct_answer' => 1],
            ],

            'Eloquent Relationships' => [
                ['question' => 'What is a hasMany relationship?', 'options' => ['One-to-one', 'One-to-many', 'Many-to-many', 'No relationship'], 'correct_answer' => 1],
                ['question' => 'What is a belongsTo relationship?', 'options' => ['Parent relationship', 'Inverse of hasOne or hasMany', 'Many-to-many', 'Self-referencing'], 'correct_answer' => 1],
                ['question' => 'What is a belongsToMany relationship?', 'options' => ['One-to-one', 'One-to-many', 'Many-to-many', 'None'], 'correct_answer' => 2],
                ['question' => 'What is a pivot table?', 'options' => ['Main table', 'Intermediate table for many-to-many', 'View', 'Index'], 'correct_answer' => 1],
                ['question' => 'How do you eager load relationships?', 'options' => ['load()', 'with()', 'include()', 'join()'], 'correct_answer' => 1],
            ],

            'Laravel Validation' => [
                ['question' => 'Why is validation important?', 'options' => ['For styling', 'To ensure data integrity and security', 'For faster loading', 'For SEO'], 'correct_answer' => 1],
                ['question' => 'Where can you define validation rules?', 'options' => ['Model only', 'Controller or FormRequest', 'View only', 'Routes'], 'correct_answer' => 1],
                ['question' => 'What does "required" validation rule do?', 'options' => ['Makes field optional', 'Ensures field is not empty', 'Encrypts field', 'Validates format'], 'correct_answer' => 1],
                ['question' => 'How do you validate email format?', 'options' => ['format:email', 'email', 'valid_email', 'check_email'], 'correct_answer' => 1],
                ['question' => 'What happens when validation fails?', 'options' => ['Data saved anyway', 'User redirected with errors', 'Server crashes', 'Nothing'], 'correct_answer' => 1],
            ],

            'RESTful APIs' => [
                ['question' => 'What does REST stand for?', 'options' => ['Remote Execution State', 'Representational State Transfer', 'Resource Execution Standard', 'Rapid Exchange System'], 'correct_answer' => 1],
                ['question' => 'Which HTTP method retrieves data?', 'options' => ['POST', 'GET', 'PUT', 'DELETE'], 'correct_answer' => 1],
                ['question' => 'Which HTTP method creates new resource?', 'options' => ['GET', 'POST', 'PUT', 'DELETE'], 'correct_answer' => 1],
                ['question' => 'What is an API endpoint?', 'options' => ['Database', 'URL where API can be accessed', 'Server name', 'Port number'], 'correct_answer' => 1],
                ['question' => 'What format do RESTful APIs commonly return?', 'options' => ['HTML', 'JSON', 'PDF', 'CSV'], 'correct_answer' => 1],
            ],

            'Authentication & Authorization' => [
                ['question' => 'What is authentication?', 'options' => ['Granting permissions', 'Verifying user identity', 'Encryption', 'Database query'], 'correct_answer' => 1],
                ['question' => 'What is authorization?', 'options' => ['Login process', 'Determining user permissions', 'Password reset', 'Session management'], 'correct_answer' => 1],
                ['question' => 'How are passwords stored securely?', 'options' => ['Plain text', 'Hashed', 'Encrypted', 'In cookies'], 'correct_answer' => 1],
                ['question' => 'What is middleware in authentication?', 'options' => ['Database table', 'Filter that runs before controller', 'View component', 'Model method'], 'correct_answer' => 1],
                ['question' => 'What does "Auth::check()" do?', 'options' => ['Logs in user', 'Checks if user is authenticated', 'Logs out user', 'Creates user'], 'correct_answer' => 1],
            ],
        ];
    }
}
