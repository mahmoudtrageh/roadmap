<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateTaskExamples extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:generate-examples
                            {--task= : Generate examples for specific task ID}
                            {--force : Overwrite existing examples}
                            {--limit=100 : Limit number of tasks to process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate code examples for coding tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('💻 Generating Code Examples...');
        $this->newLine();

        $query = \App\Models\Task::query()
            ->whereIn('task_type', ['coding', 'exercise', 'project']);

        if ($taskId = $this->option('task')) {
            $query->where('id', $taskId);
        }

        $limit = (int) $this->option('limit');
        $tasks = $query->limit($limit)->get();

        if ($tasks->isEmpty()) {
            $this->error('No coding tasks found');
            return 1;
        }

        $this->info("Generating examples for {$tasks->count()} coding tasks");
        $this->newLine();

        $generated = 0;
        $skipped = 0;

        $progressBar = $this->output->createProgressBar($tasks->count());
        $progressBar->start();

        foreach ($tasks as $task) {
            $existing = \App\Models\TaskExample::where('task_id', $task->id)->exists();

            if ($existing && !$this->option('force')) {
                $skipped++;
                $progressBar->advance();
                continue;
            }

            if ($existing && $this->option('force')) {
                \App\Models\TaskExample::where('task_id', $task->id)->delete();
            }

            $examples = $this->generateExamples($task);

            foreach ($examples as $index => $example) {
                \App\Models\TaskExample::create([
                    'task_id' => $task->id,
                    'title' => $example['title'],
                    'description' => $example['description'],
                    'code' => $example['code'],
                    'language' => $example['language'],
                    'difficulty' => $example['difficulty'],
                    'order' => $index,
                    'explanation' => $example['explanation'],
                    'output' => $example['output'] ?? null,
                    'is_active' => true,
                ]);
            }

            $generated++;
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("✅ Generated: {$generated}");
        $this->info("⏭  Skipped: {$skipped}");

        return 0;
    }

    private function generateExamples($task): array
    {
        $examples = [];
        $taskTitle = strtolower($task->title);
        $language = $this->detectLanguage($taskTitle, $task->description);

        // Determine how many examples based on task type
        $exampleCount = $task->task_type === 'project' ? 3 : 2;

        if ($task->task_type === 'coding' || $task->task_type === 'exercise') {
            $examples[] = $this->generateBeginnerExample($task, $language);
            if ($exampleCount > 1) {
                $examples[] = $this->generateIntermediateExample($task, $language);
            }
        } elseif ($task->task_type === 'project') {
            $examples[] = $this->generateBeginnerExample($task, $language);
            $examples[] = $this->generateIntermediateExample($task, $language);
            $examples[] = $this->generateAdvancedExample($task, $language);
        }

        return $examples;
    }

    private function detectLanguage($title, $description): string
    {
        $text = strtolower($title . ' ' . ($description ?? ''));

        if (str_contains($text, 'python')) return 'python';
        if (str_contains($text, 'java') && !str_contains($text, 'javascript')) return 'java';
        if (str_contains($text, 'javascript') || str_contains($text, 'js')) return 'javascript';
        if (str_contains($text, 'php')) return 'php';
        if (str_contains($text, 'c++') || str_contains($text, 'cpp')) return 'cpp';
        if (str_contains($text, 'c#') || str_contains($text, 'csharp')) return 'csharp';
        if (str_contains($text, 'html')) return 'html';
        if (str_contains($text, 'css')) return 'css';
        if (str_contains($text, 'sql') || str_contains($text, 'database')) return 'sql';

        return 'javascript'; // Default
    }

    private function generateBeginnerExample($task, $language): array
    {
        $examples = [
            'javascript' => [
                'title' => 'Basic Example',
                'description' => 'A simple example to get you started',
                'code' => '// Basic example' . "\n" . 'function greet(name) {' . "\n" . '    return `Hello, ${name}!`;' . "\n" . '}' . "\n\n" . 'console.log(greet(\'Ahmed\'));',
                'explanation' => 'This example shows the basic structure and syntax. Notice how we define the function, use parameters, and return a value.',
                'output' => 'Hello, Ahmed!',
            ],
            'python' => [
                'title' => 'Basic Example',
                'description' => 'A simple example to get you started',
                'code' => '# Basic example' . "\n" . 'def greet(name):' . "\n" . '    return f"Hello, {name}!"' . "\n\n" . 'print(greet(\'Ahmed\'))',
                'explanation' => 'This example shows the basic structure and syntax. Notice the function definition, parameter usage, and f-string formatting.',
                'output' => 'Hello, Ahmed!',
            ],
            'php' => [
                'title' => 'Basic Example',
                'description' => 'A simple example to get you started',
                'code' => '<?php' . "\n" . '// Basic example' . "\n" . 'function greet($name) {' . "\n" . '    return "Hello, " . $name . "!";' . "\n" . '}' . "\n\n" . 'echo greet(\'Ahmed\');',
                'explanation' => 'This example demonstrates basic PHP syntax including function definition, string concatenation, and output.',
                'output' => 'Hello, Ahmed!',
            ],
        ];

        $template = $examples[$language] ?? $examples['javascript'];
        $template['language'] = $language;
        $template['difficulty'] = 'beginner';

        return $template;
    }

    private function generateIntermediateExample($task, $language): array
    {
        $examples = [
            'javascript' => [
                'title' => 'Practical Example',
                'description' => 'A more realistic use case',
                'code' => '// Practical example with validation' . "\n" . 'function processUserData(users) {' . "\n" . '    return users' . "\n" . '        .filter(user => user.age >= 18)' . "\n" . '        .map(user => ({' . "\n" . '            ...user,' . "\n" . '            status: \'active\'' . "\n" . '        }));' . "\n" . '}' . "\n\n" . 'const users = [{name: \'Ahmed\', age: 20}];' . "\n" . 'console.log(processUserData(users));',
                'explanation' => 'This example shows array methods, filtering, mapping, and the spread operator. These are common patterns in real applications.',
                'output' => "[{name: 'Ahmed', age: 20, status: 'active'}]",
            ],
            'python' => [
                'title' => 'Practical Example',
                'description' => 'A more realistic use case',
                'code' => '# Practical example with list comprehension' . "\n" . 'def process_user_data(users):' . "\n" . '    return [' . "\n" . '        {**user, \'status\': \'active\'}' . "\n" . '        for user in users' . "\n" . '        if user[\'age\'] >= 18' . "\n" . '    ]' . "\n\n" . 'users = [{\'name\': \'Ahmed\', \'age\': 20}]' . "\n" . 'print(process_user_data(users))',
                'explanation' => 'This example demonstrates list comprehensions, dictionary unpacking, and filtering. These patterns make Python code clean and readable.',
                'output' => "[{'name': 'Ahmed', 'age': 20, 'status': 'active'}]",
            ],
            'php' => [
                'title' => 'Practical Example',
                'description' => 'A more realistic use case',
                'code' => '<?php' . "\n" . '// Practical example with filtering' . "\n" . 'function processUserData($users) {' . "\n" . '    return array_map(function($user) {' . "\n" . '        $user[\'status\'] = \'active\';' . "\n" . '        return $user;' . "\n" . '    }, array_filter($users, fn($u) => $u[\'age\'] >= 18));' . "\n" . '}' . "\n\n" . '$users = [[\'name\' => \'Ahmed\', \'age\' => 20]];' . "\n" . 'print_r(processUserData($users));',
                'explanation' => 'This example uses array_filter and array_map for data processing, along with arrow functions for concise code.',
                'output' => "Array ( [0] => Array ( [name] => Ahmed [age] => 20 [status] => active ) )",
            ],
        ];

        $template = $examples[$language] ?? $examples['javascript'];
        $template['language'] = $language;
        $template['difficulty'] = 'intermediate';

        return $template;
    }

    private function generateAdvancedExample($task, $language): array
    {
        $examples = [
            'javascript' => [
                'title' => 'Advanced Example',
                'description' => 'Production-ready implementation',
                'code' => '// Advanced example with error handling' . "\n" . 'class UserManager {' . "\n" . '    constructor() {' . "\n" . '        this.users = [];' . "\n" . '    }' . "\n\n" . '    async addUser(userData) {' . "\n" . '        try {' . "\n" . '            if (!userData.name || !userData.email) {' . "\n" . '                throw new Error(\'Invalid user data\');' . "\n" . '            }' . "\n" . '            this.users.push(userData);' . "\n" . '            return { success: true, user: userData };' . "\n" . '        } catch (error) {' . "\n" . '            return { success: false, error: error.message };' . "\n" . '        }' . "\n" . '    }' . "\n" . '}' . "\n\n" . 'const manager = new UserManager();' . "\n" . 'manager.addUser({name: \'Ahmed\', email: \'ahmed@example.com\'});',
                'explanation' => 'This advanced example shows object-oriented programming, async/await, error handling, and validation. These patterns are essential for production code.',
                'output' => "{ success: true, user: {name: 'Ahmed', email: 'ahmed@example.com'} }",
            ],
            'python' => [
                'title' => 'Advanced Example',
                'description' => 'Production-ready implementation',
                'code' => '# Advanced example with class and error handling' . "\n" . 'class UserManager:' . "\n" . '    def __init__(self):' . "\n" . '        self.users = []' . "\n\n" . '    def add_user(self, user_data):' . "\n" . '        try:' . "\n" . '            if not user_data.get(\'name\') or not user_data.get(\'email\'):' . "\n" . '                raise ValueError(\'Invalid user data\')' . "\n" . '            self.users.append(user_data)' . "\n" . '            return {\'success\': True, \'user\': user_data}' . "\n" . '        except ValueError as e:' . "\n" . '            return {\'success\': False, \'error\': str(e)}' . "\n\n" . 'manager = UserManager()' . "\n" . 'result = manager.add_user({\'name\': \'Ahmed\', \'email\': \'ahmed@example.com\'})' . "\n" . 'print(result)',
                'explanation' => 'This advanced example demonstrates OOP principles, exception handling, and validation. These are critical skills for building robust applications.',
                'output' => "{'success': True, 'user': {'name': 'Ahmed', 'email': 'ahmed@example.com'}}",
            ],
            'php' => [
                'title' => 'Advanced Example',
                'description' => 'Production-ready implementation',
                'code' => '<?php' . "\n" . '// Advanced example with class and exception handling' . "\n" . 'class UserManager {' . "\n" . '    private $users = [];' . "\n\n" . '    public function addUser(array $userData): array {' . "\n" . '        try {' . "\n" . '            if (empty($userData[\'name\']) || empty($userData[\'email\'])) {' . "\n" . '                throw new InvalidArgumentException(\'Invalid user data\');' . "\n" . '            }' . "\n" . '            $this->users[] = $userData;' . "\n" . '            return [\'success\' => true, \'user\' => $userData];' . "\n" . '        } catch (InvalidArgumentException $e) {' . "\n" . '            return [\'success\' => false, \'error\' => $e->getMessage()];' . "\n" . '        }' . "\n" . '    }' . "\n" . '}' . "\n\n" . '$manager = new UserManager();' . "\n" . '$result = $manager->addUser([\'name\' => \'Ahmed\', \'email\' => \'ahmed@example.com\']);' . "\n" . 'print_r($result);',
                'explanation' => 'This advanced example showcases OOP, type hints, exception handling, and validation. These patterns create maintainable and reliable code.',
                'output' => "Array ( [success] => 1 [user] => Array ( [name] => Ahmed [email] => ahmed@example.com ) )",
            ],
        ];

        $template = $examples[$language] ?? $examples['javascript'];
        $template['language'] = $language;
        $template['difficulty'] = 'advanced';

        return $template;
    }
}
