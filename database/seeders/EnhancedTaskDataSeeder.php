<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskChecklist;
use App\Models\TaskHint;
use App\Models\TaskQuiz;
use App\Models\TaskExample;
use Illuminate\Database\Seeder;

class EnhancedTaskDataSeeder extends Seeder
{
    /**
     * Seed enhanced data (checklists, hints, quizzes, examples) for tasks.
     */
    public function run(): void
    {
        $this->command->info('Adding enhanced data to tasks...');

        // Get some sample tasks to enhance
        $tasks = Task::with('roadmap')->take(20)->get();

        if ($tasks->isEmpty()) {
            $this->command->warn('No tasks found to enhance. Run ProgrammingFundamentalsSeeder first.');
            return;
        }

        $enhancedCount = 0;

        foreach ($tasks as $task) {
            // Add checklists for exercise and project tasks
            if (in_array($task->task_type, ['exercise', 'project'])) {
                $this->addChecklistsForTask($task);
            }

            // Add hints for all tasks
            $this->addHintsForTask($task);

            // Add quiz for reading tasks
            if ($task->task_type === 'reading') {
                $this->addQuizForTask($task);
            }

            // Add examples for exercise tasks
            if ($task->task_type === 'exercise') {
                $this->addExamplesForTask($task);
            }

            $enhancedCount++;
        }

        $this->command->info("✓ Enhanced $enhancedCount tasks with checklists, hints, quizzes, and examples");
    }

    private function addChecklistsForTask(Task $task): void
    {
        $items = $this->getChecklistsForTaskType($task);

        TaskChecklist::create([
            'task_id' => $task->id,
            'items' => $items,
            'description' => 'Complete these steps to finish this task successfully.',
            'is_active' => true,
        ]);
    }

    private function addHintsForTask(Task $task): void
    {
        $hints = $this->getHintsForTaskType($task);

        TaskHint::create([
            'task_id' => $task->id,
            'hints' => $hints,
            'introduction' => 'Need help? Reveal hints one at a time to guide you through this task.',
            'is_active' => true,
        ]);
    }

    private function addQuizForTask(Task $task): void
    {
        $questions = $this->getQuizQuestionsForTask($task);

        TaskQuiz::create([
            'task_id' => $task->id,
            'questions' => $questions,
            'introduction' => 'Test your understanding of the concepts covered in this task.',
            'passing_score' => 60,
            'is_active' => true,
        ]);
    }

    private function addExamplesForTask(Task $task): void
    {
        $examples = $this->getExamplesForTask($task);

        foreach ($examples as $index => $exampleData) {
            TaskExample::create([
                'task_id' => $task->id,
                'title' => $exampleData['title'],
                'code' => $exampleData['code'],
                'explanation' => $exampleData['explanation'],
                'language' => $exampleData['language'] ?? 'javascript',
                'order' => $index,
            ]);
        }
    }

    private function getChecklistsForTaskType(Task $task): array
    {
        if ($task->task_type === 'project') {
            return [
                'Read and understand all requirements',
                'Break down the problem into smaller parts',
                'Create a plan or pseudocode',
                'Implement the solution step by step',
                'Test with multiple test cases',
                'Review and refactor your code',
                'Document your approach and decisions',
            ];
        }

        if ($task->task_type === 'exercise') {
            return [
                'Read the exercise requirements carefully',
                'Identify the key concepts being tested',
                'Write pseudocode or outline your approach',
                'Implement the solution',
                'Test with sample inputs',
                'Check edge cases',
            ];
        }

        return [
            'Complete the reading material',
            'Take notes on key concepts',
            'Try explaining the concept to yourself',
        ];
    }

    private function getHintsForTaskType(Task $task): array
    {
        $category = $task->category;

        if (str_contains($category, 'Problem Solving') || str_contains($category, 'Computational')) {
            return [
                [
                    'level' => 'gentle',
                    'text' => 'Start by breaking down the problem into smaller, manageable steps. What is the first thing you need to do?',
                ],
                [
                    'level' => 'moderate',
                    'text' => 'Think about similar problems you\'ve solved before. Can you apply the same approach here? Consider drawing a flowchart.',
                ],
                [
                    'level' => 'detailed',
                    'text' => 'Try writing pseudocode first before implementing the solution. List all inputs, outputs, and intermediate steps needed.',
                ],
            ];
        }

        if (str_contains($category, 'Data Structures') || str_contains($category, 'Algorithms')) {
            return [
                [
                    'level' => 'gentle',
                    'text' => 'What data structure would be most efficient for this task? Think about how you need to access and modify the data.',
                ],
                [
                    'level' => 'moderate',
                    'text' => 'Consider the time complexity of your approach. Can you optimize it? Try tracing through your algorithm with a small example.',
                ],
                [
                    'level' => 'detailed',
                    'text' => 'Review the common operations for this data structure. Make sure you understand how to iterate, search, insert, and delete elements.',
                ],
            ];
        }

        if (str_contains($category, 'OOP')) {
            return [
                [
                    'level' => 'gentle',
                    'text' => 'Think about what properties (data) and methods (behavior) your class should have. What does this object represent in the real world?',
                ],
                [
                    'level' => 'moderate',
                    'text' => 'Consider the relationships between classes. Should one class inherit from another? What properties should be private vs public?',
                ],
                [
                    'level' => 'detailed',
                    'text' => 'Review the four pillars of OOP: Encapsulation, Abstraction, Inheritance, and Polymorphism. Which apply to this task?',
                ],
            ];
        }

        // Default hints
        return [
            [
                'level' => 'gentle',
                'text' => 'Re-read the task description and resources. Make sure you understand what\'s being asked.',
            ],
            [
                'level' => 'moderate',
                'text' => 'Break the task into smaller sub-tasks. Try completing each one individually.',
            ],
            [
                'level' => 'detailed',
                'text' => 'If you\'re stuck, try explaining the problem out loud or to someone else. This often helps clarify your thinking.',
            ],
        ];
    }

    private function getQuizQuestionsForTask(Task $task): array
    {
        $category = $task->category;

        if (str_contains($category, 'Computational Thinking') || str_contains($category, 'Problem Solving')) {
            return [
                [
                    'question' => 'What is the first step in computational thinking?',
                    'options' => [
                        'Writing code immediately',
                        'Decomposing the problem into smaller parts',
                        'Choosing a programming language',
                        'Testing the solution',
                    ],
                    'correct_answer' => 'Decomposing the problem into smaller parts',
                    'explanation' => 'Decomposition is breaking down a complex problem into smaller, more manageable sub-problems. This makes it easier to understand and solve.',
                ],
                [
                    'question' => 'What does abstraction mean in problem-solving?',
                    'options' => [
                        'Making problems more complex',
                        'Focusing on important details and ignoring irrelevant information',
                        'Writing abstract art',
                        'Using only variables',
                    ],
                    'correct_answer' => 'Focusing on important details and ignoring irrelevant information',
                    'explanation' => 'Abstraction helps us focus on what\'s important by removing unnecessary details that don\'t affect the solution.',
                ],
            ];
        }

        if (str_contains($category, 'OOP')) {
            return [
                [
                    'question' => 'What is encapsulation in OOP?',
                    'options' => [
                        'Making all variables public',
                        'Bundling data and methods together and hiding internal details',
                        'Creating multiple classes',
                        'Using inheritance',
                    ],
                    'correct_answer' => 'Bundling data and methods together and hiding internal details',
                    'explanation' => 'Encapsulation is about bundling related data and behavior together in a class while hiding the internal implementation details.',
                ],
            ];
        }

        // Default quiz questions
        return [
            [
                'question' => 'What is the main concept covered in this task?',
                'options' => [
                    'Understanding the fundamentals',
                    'Advanced optimization',
                    'Database design',
                    'Network protocols',
                ],
                'correct_answer' => 'Understanding the fundamentals',
                'explanation' => 'This task focuses on building a strong foundation in the core concepts.',
            ],
        ];
    }

    private function getExamplesForTask(Task $task): array
    {
        $category = $task->category;

        if (str_contains($task->title, 'Variables') || str_contains($category, 'Syntax')) {
            return [
                [
                    'title' => 'Basic Variable Declaration',
                    'code' => "// Declaring variables\nlet name = 'Alice';\nlet age = 25;\nlet isStudent = true;\n\nconsole.log(name); // Output: Alice\nconsole.log(age);  // Output: 25",
                    'explanation' => 'Variables are containers for storing data values. Use descriptive names to make your code more readable.',
                    'language' => 'javascript',
                ],
                [
                    'title' => 'Variable Reassignment',
                    'code' => "let score = 0;\nconsole.log(score); // 0\n\nscore = 10;\nconsole.log(score); // 10\n\nscore = score + 5;\nconsole.log(score); // 15",
                    'explanation' => 'Variables declared with let can be reassigned to new values. The variable takes on the new value immediately.',
                    'language' => 'javascript',
                ],
            ];
        }

        if (str_contains($task->title, 'Loop') || str_contains($task->title, 'Conditional')) {
            return [
                [
                    'title' => 'For Loop Example',
                    'code' => "// Print numbers 1 to 5\nfor (let i = 1; i <= 5; i++) {\n    console.log(i);\n}\n// Output: 1, 2, 3, 4, 5",
                    'explanation' => 'A for loop repeats a block of code a specific number of times. It has initialization, condition, and increment sections.',
                    'language' => 'javascript',
                ],
                [
                    'title' => 'If-Else Example',
                    'code' => "let age = 18;\n\nif (age >= 18) {\n    console.log('You are an adult');\n} else {\n    console.log('You are a minor');\n}",
                    'explanation' => 'Conditional statements execute different code based on whether a condition is true or false.',
                    'language' => 'javascript',
                ],
            ];
        }

        if (str_contains($task->title, 'Array') || str_contains($category, 'Data Structures')) {
            return [
                [
                    'title' => 'Creating and Accessing Arrays',
                    'code' => "let fruits = ['apple', 'banana', 'orange'];\n\nconsole.log(fruits[0]); // 'apple'\nconsole.log(fruits[1]); // 'banana'\nconsole.log(fruits.length); // 3",
                    'explanation' => 'Arrays store multiple values in a single variable. Use index (starting at 0) to access elements.',
                    'language' => 'javascript',
                ],
                [
                    'title' => 'Array Methods',
                    'code' => "let numbers = [1, 2, 3];\n\nnumbers.push(4);      // Add to end: [1,2,3,4]\nnumbers.pop();        // Remove from end: [1,2,3]\nnumbers.unshift(0);   // Add to start: [0,1,2,3]\nnumbers.shift();      // Remove from start: [1,2,3]",
                    'explanation' => 'Arrays have built-in methods for adding and removing elements from both ends.',
                    'language' => 'javascript',
                ],
            ];
        }

        // Default example
        return [
            [
                'title' => 'Example Solution',
                'code' => "// Sample code example\nfunction greet(name) {\n    return `Hello, \${name}!`;\n}\n\nconsole.log(greet('World')); // Hello, World!",
                'explanation' => 'This is a simple example to demonstrate the concepts covered in this task.',
                'language' => 'javascript',
            ],
        ];
    }
}
