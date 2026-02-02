<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskExam;
use App\Models\ExamQuestion;

class ExamQuestionGenerator
{
    /**
     * Generate exam questions based on task topic and category
     */
    public function generateQuestionsForTask(Task $task): array
    {
        $questions = [];

        // Generate questions based on task category and type (case-insensitive)
        $category = strtolower($task->category ?? '');

        switch ($category) {
            case 'backend':
                $questions = $this->generateBackendQuestions($task);
                break;
            case 'frontend':
                $questions = $this->generateFrontendQuestions($task);
                break;
            case 'database':
                $questions = $this->generateDatabaseQuestions($task);
                break;
            case 'devops':
                $questions = $this->generateDevOpsQuestions($task);
                break;
            case 'security':
                $questions = $this->generateSecurityQuestions($task);
                break;
            default:
                $questions = $this->generateGeneralQuestions($task);
                break;
        }

        return $questions;
    }

    private function generateBackendQuestions(Task $task): array
    {
        $title = strtolower($task->title);
        $description = strtolower($task->description ?? '');
        $combined = $title . ' ' . $description;
        $questions = [];

        // API related
        if (str_contains($combined, 'api') || str_contains($combined, 'rest')) {
            $questions[] = [
                'question' => 'What is the correct HTTP method for retrieving data from a REST API?',
                'options' => ['POST', 'GET', 'PUT', 'DELETE'],
                'correct_answer' => 1,
            ];
            $questions[] = [
                'question' => 'Which HTTP status code indicates a successful resource creation?',
                'options' => ['200 OK', '201 Created', '204 No Content', '202 Accepted'],
                'correct_answer' => 1,
            ];
        }

        // Authentication & Security
        if (str_contains($combined, 'auth') || str_contains($combined, 'login') || str_contains($combined, 'jwt') || str_contains($combined, 'security')) {
            $questions[] = [
                'question' => 'What does JWT stand for?',
                'options' => ['Java Web Token', 'JSON Web Token', 'JavaScript Web Tool', 'Join Web Transfer'],
                'correct_answer' => 1,
            ];
            $questions[] = [
                'question' => 'Which part of a JWT contains the actual user data?',
                'options' => ['Header', 'Payload', 'Signature', 'Token'],
                'correct_answer' => 1,
            ];
            $questions[] = [
                'question' => 'What is the purpose of API authentication?',
                'options' => [
                    'To make APIs slower',
                    'To verify the identity of users/applications accessing the API',
                    'To encrypt database',
                    'To style the interface'
                ],
                'correct_answer' => 1,
            ];
            $questions[] = [
                'question' => 'Which HTTP header is commonly used to send authentication tokens?',
                'options' => ['Content-Type', 'Authorization', 'Accept', 'Cookie'],
                'correct_answer' => 1,
            ];
            $questions[] = [
                'question' => 'What is the main difference between authentication and authorization?',
                'options' => [
                    'There is no difference',
                    'Authentication verifies identity, authorization verifies permissions',
                    'Authorization verifies identity, authentication verifies permissions',
                    'Both are the same process'
                ],
                'correct_answer' => 1,
            ];
        }

        // Validation
        if (str_contains($combined, 'valid')) {
            $questions[] = [
                'question' => 'What is the purpose of server-side validation?',
                'options' => [
                    'To improve UI/UX only',
                    'To ensure data integrity and security',
                    'To make the website faster',
                    'To reduce server load'
                ],
                'correct_answer' => 1,
            ];
        }

        // Middleware
        if (str_contains($combined, 'middleware')) {
            $questions[] = [
                'question' => 'What is the primary purpose of middleware in web applications?',
                'options' => [
                    'To store data in database',
                    'To process requests before they reach the controller',
                    'To render HTML templates',
                    'To cache API responses'
                ],
                'correct_answer' => 1,
            ];
        }

        // Error Handling
        if (str_contains($combined, 'error')) {
            $questions[] = [
                'question' => 'What is the best practice for handling errors in production?',
                'options' => [
                    'Display full error messages to users',
                    'Log errors and show generic messages to users',
                    'Ignore errors silently',
                    'Restart the server on every error'
                ],
                'correct_answer' => 1,
            ];
        }

        return $this->ensureFiveQuestions($questions, $task);
    }

    private function generateFrontendQuestions(Task $task): array
    {
        $title = strtolower($task->title);
        $questions = [];

        // HTML
        if (str_contains($title, 'html')) {
            $questions[] = [
                'question' => 'What is the correct HTML element for the largest heading?',
                'options' => ['<head>', '<h6>', '<h1>', '<heading>'],
                'correct_answer' => 2,
            ];
            $questions[] = [
                'question' => 'Which HTML attribute specifies an alternate text for an image?',
                'options' => ['title', 'alt', 'src', 'longdesc'],
                'correct_answer' => 1,
            ];
        }

        // CSS
        if (str_contains($title, 'css') || str_contains($title, 'style')) {
            $questions[] = [
                'question' => 'Which CSS property controls the text size?',
                'options' => ['text-style', 'font-size', 'text-size', 'font-style'],
                'correct_answer' => 1,
            ];
            $questions[] = [
                'question' => 'What is the correct syntax for adding a comment in CSS?',
                'options' => ['// comment', '/* comment */', '<!-- comment -->', '# comment'],
                'correct_answer' => 1,
            ];
        }

        // JavaScript
        if (str_contains($title, 'javascript') || str_contains($title, 'js')) {
            $questions[] = [
                'question' => 'Which keyword is used to declare a block-scoped variable in JavaScript?',
                'options' => ['var', 'int', 'let', 'variable'],
                'correct_answer' => 2,
            ];
            $questions[] = [
                'question' => 'What does DOM stand for?',
                'options' => ['Document Object Model', 'Data Object Management', 'Digital Oriented Mode', 'Document Ordering Method'],
                'correct_answer' => 0,
            ];
        }

        // React/Vue
        if (str_contains($title, 'react') || str_contains($title, 'component')) {
            $questions[] = [
                'question' => 'What is a component in React?',
                'options' => [
                    'A database table',
                    'A reusable piece of UI',
                    'A CSS framework',
                    'A server-side function'
                ],
                'correct_answer' => 1,
            ];
        }

        return $this->ensureFiveQuestions($questions, $task);
    }

    private function generateDatabaseQuestions(Task $task): array
    {
        $title = strtolower($task->title);
        $questions = [];

        // SQL basics
        if (str_contains($title, 'sql') || str_contains($title, 'query')) {
            $questions[] = [
                'question' => 'Which SQL statement is used to retrieve data from a database?',
                'options' => ['GET', 'SELECT', 'OPEN', 'EXTRACT'],
                'correct_answer' => 1,
            ];
            $questions[] = [
                'question' => 'What does SQL stand for?',
                'options' => ['Structured Query Language', 'Simple Question Language', 'Standard Query Logic', 'System Quality Language'],
                'correct_answer' => 0,
            ];
        }

        // Joins
        if (str_contains($title, 'join')) {
            $questions[] = [
                'question' => 'Which type of JOIN returns all records from the left table and matched records from the right table?',
                'options' => ['INNER JOIN', 'LEFT JOIN', 'RIGHT JOIN', 'FULL JOIN'],
                'correct_answer' => 1,
            ];
        }

        // Indexes
        if (str_contains($title, 'index') || str_contains($title, 'optimiz')) {
            $questions[] = [
                'question' => 'What is the primary purpose of database indexes?',
                'options' => [
                    'To backup data',
                    'To improve query performance',
                    'To encrypt data',
                    'To compress tables'
                ],
                'correct_answer' => 1,
            ];
        }

        // Migrations
        if (str_contains($title, 'migration')) {
            $questions[] = [
                'question' => 'What is a database migration?',
                'options' => [
                    'Moving data between servers',
                    'A version-controlled way to modify database schema',
                    'Exporting database to CSV',
                    'Deleting old records'
                ],
                'correct_answer' => 1,
            ];
        }

        return $this->ensureFiveQuestions($questions, $task);
    }

    private function generateDevOpsQuestions(Task $task): array
    {
        $title = strtolower($task->title);
        $questions = [];

        // Git
        if (str_contains($title, 'git')) {
            $questions[] = [
                'question' => 'What Git command is used to save your changes to the local repository?',
                'options' => ['git save', 'git commit', 'git push', 'git update'],
                'correct_answer' => 1,
            ];
            $questions[] = [
                'question' => 'What does "git pull" do?',
                'options' => [
                    'Pushes local changes to remote',
                    'Fetches and merges changes from remote',
                    'Creates a new branch',
                    'Deletes local changes'
                ],
                'correct_answer' => 1,
            ];
        }

        // Docker
        if (str_contains($title, 'docker')) {
            $questions[] = [
                'question' => 'What is a Docker container?',
                'options' => [
                    'A virtual machine',
                    'A lightweight, standalone executable package',
                    'A cloud storage service',
                    'A database system'
                ],
                'correct_answer' => 1,
            ];
        }

        // CI/CD
        if (str_contains($title, 'ci') || str_contains($title, 'deploy')) {
            $questions[] = [
                'question' => 'What does CI/CD stand for?',
                'options' => [
                    'Computer Integration/Computer Deployment',
                    'Continuous Integration/Continuous Deployment',
                    'Central Installation/Central Distribution',
                    'Code Integration/Code Delivery'
                ],
                'correct_answer' => 1,
            ];
        }

        return $this->ensureFiveQuestions($questions, $task);
    }

    private function generateSecurityQuestions(Task $task): array
    {
        $title = strtolower($task->title);
        $questions = [];

        if (str_contains($title, 'xss')) {
            $questions[] = [
                'question' => 'What does XSS stand for?',
                'options' => ['Extra Security System', 'Cross-Site Scripting', 'XML Style Sheet', 'Extended Server Side'],
                'correct_answer' => 1,
            ];
        }

        if (str_contains($title, 'sql injection')) {
            $questions[] = [
                'question' => 'How can you prevent SQL injection attacks?',
                'options' => [
                    'Use plain text passwords',
                    'Use prepared statements and parameterized queries',
                    'Disable database logging',
                    'Use simple passwords'
                ],
                'correct_answer' => 1,
            ];
        }

        if (str_contains($title, 'csrf')) {
            $questions[] = [
                'question' => 'What is CSRF?',
                'options' => [
                    'A type of database',
                    'Cross-Site Request Forgery',
                    'A CSS framework',
                    'A JavaScript library'
                ],
                'correct_answer' => 1,
            ];
        }

        return $this->ensureFiveQuestions($questions, $task);
    }

    private function generateGeneralQuestions(Task $task): array
    {
        $title = strtolower($task->title);
        $description = strtolower($task->description ?? '');
        $questions = [];

        // Programming fundamentals
        $questions[] = [
            'question' => "What is the main topic covered in the task: {$task->title}?",
            'options' => [
                'Database management',
                'User interface design',
                'Backend development',
                'General programming concepts'
            ],
            'correct_answer' => 3,
        ];

        // Variables
        if (str_contains($title, 'variable')) {
            $questions[] = [
                'question' => 'What is a variable in programming?',
                'options' => [
                    'A type of loop',
                    'A container for storing data values',
                    'A function parameter only',
                    'A database table'
                ],
                'correct_answer' => 1,
            ];
        }

        // Functions
        if (str_contains($title, 'function')) {
            $questions[] = [
                'question' => 'What is the purpose of a function?',
                'options' => [
                    'To style web pages',
                    'To reuse code and organize logic',
                    'To store data permanently',
                    'To connect to databases'
                ],
                'correct_answer' => 1,
            ];
        }

        // Loops
        if (str_contains($title, 'loop') || str_contains($title, 'iteration')) {
            $questions[] = [
                'question' => 'What is a loop used for in programming?',
                'options' => [
                    'To style elements',
                    'To repeat code execution',
                    'To delete variables',
                    'To import libraries'
                ],
                'correct_answer' => 1,
            ];
        }

        return $this->ensureFiveQuestions($questions, $task);
    }

    private function ensureFiveQuestions(array $questions, Task $task): array
    {
        // If we have fewer than 5 questions, add generic questions
        while (count($questions) < 5) {
            $genericQuestions = [
                [
                    'question' => "Which of the following best describes the focus of: {$task->title}?",
                    'options' => [
                        'Understanding basic concepts',
                        'Advanced optimization techniques',
                        'Theory without practice',
                        'Unrelated topics'
                    ],
                    'correct_answer' => 0,
                ],
                [
                    'question' => "What is an important consideration when working on: {$task->title}?",
                    'options' => [
                        'Ignoring best practices',
                        'Following coding standards and best practices',
                        'Skipping documentation',
                        'Avoiding testing'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is a best practice in software development?',
                    'options' => [
                        'Writing comments and documentation',
                        'Never testing code',
                        'Using random variable names',
                        'Ignoring errors'
                    ],
                    'correct_answer' => 0,
                ],
                [
                    'question' => 'Why is it important to test your code?',
                    'options' => [
                        'It wastes time',
                        'To ensure code works as expected and catch bugs',
                        'It is not important',
                        'Only for large projects'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What should you do when encountering an error?',
                    'options' => [
                        'Ignore it and continue',
                        'Read the error message and debug systematically',
                        'Delete the code',
                        'Give up immediately'
                    ],
                    'correct_answer' => 1,
                ],
            ];

            // Add questions that haven't been added yet
            foreach ($genericQuestions as $q) {
                if (count($questions) >= 5) break;

                // Check if question already exists
                $exists = false;
                foreach ($questions as $existing) {
                    if ($existing['question'] === $q['question']) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    $questions[] = $q;
                }
            }
        }

        // Return only first 5 questions
        return array_slice($questions, 0, 5);
    }
}
