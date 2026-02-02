<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskExam;
use App\Models\ExamQuestion;
use Illuminate\Database\Seeder;

class BackendIntermediateExamsSeeder extends Seeder
{
    public function run(): void
    {
        $roadmapId = 6; // Backend Intermediate

        $examsData = [
            // Day 1: Database Optimization & Indexing
            'Database Optimization & Indexing' => [
                [
                    'question' => 'What is the primary purpose of a database index?',
                    'options' => [
                        'To backup data automatically',
                        'To speed up data retrieval operations',
                        'To encrypt sensitive data',
                        'To compress database files'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'Which type of index is best for columns frequently used in WHERE clauses?',
                    'options' => [
                        'Full-text index',
                        'B-Tree index',
                        'Hash index',
                        'Spatial index'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is the trade-off of adding too many indexes to a table?',
                    'options' => [
                        'Faster queries but slower writes (INSERT/UPDATE/DELETE)',
                        'Slower queries but faster writes',
                        'No impact on performance',
                        'Increased security risks'
                    ],
                    'correct_answer' => 0,
                ],
                [
                    'question' => 'What does the EXPLAIN statement do in SQL?',
                    'options' => [
                        'Deletes query history',
                        'Shows how the database will execute a query',
                        'Encrypts query results',
                        'Validates table structure'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is query optimization?',
                    'options' => [
                        'Writing queries in uppercase',
                        'Improving query performance by restructuring or indexing',
                        'Removing all indexes',
                        'Using only SELECT * statements'
                    ],
                    'correct_answer' => 1,
                ],
            ],

            // RESTful API Design
            'RESTful API Design' => [
                [
                    'question' => 'What does REST stand for?',
                    'options' => [
                        'Remote Execution State Transfer',
                        'Representational State Transfer',
                        'Rapid Execution System Technology',
                        'Resource Execution Standard Type'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'Which HTTP method should be used to create a new resource?',
                    'options' => ['GET', 'POST', 'PUT', 'DELETE'],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is the correct HTTP status code for a successful resource creation?',
                    'options' => ['200 OK', '201 Created', '204 No Content', '202 Accepted'],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is the difference between PUT and PATCH?',
                    'options' => [
                        'No difference, they are the same',
                        'PUT replaces entire resource, PATCH partially updates',
                        'PATCH replaces entire resource, PUT partially updates',
                        'PUT is for reading, PATCH is for writing'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is an idempotent operation in REST?',
                    'options' => [
                        'An operation that can only run once',
                        'An operation that produces the same result no matter how many times executed',
                        'An operation that never succeeds',
                        'An operation that requires authentication'
                    ],
                    'correct_answer' => 1,
                ],
            ],

            // API Authentication & Security
            'API Authentication & Security' => [
                [
                    'question' => 'What does JWT stand for?',
                    'options' => [
                        'Java Web Token',
                        'JSON Web Token',
                        'JavaScript Web Tool',
                        'Join Web Transfer'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'Which part of a JWT contains the user payload/claims?',
                    'options' => ['Header', 'Payload', 'Signature', 'Token'],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is the main purpose of the signature in a JWT?',
                    'options' => [
                        'To encrypt the payload',
                        'To verify the token has not been tampered with',
                        'To store user credentials',
                        'To set token expiration'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'Which HTTP header is used to send a JWT token?',
                    'options' => ['Content-Type', 'Authorization', 'Accept', 'X-API-Key'],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is OAuth 2.0 primarily used for?',
                    'options' => [
                        'Database encryption',
                        'Third-party authorization and delegated access',
                        'Password hashing',
                        'File compression'
                    ],
                    'correct_answer' => 1,
                ],
            ],

            // Caching Strategies
            'Caching Strategies' => [
                [
                    'question' => 'What is the main benefit of caching?',
                    'options' => [
                        'Better security',
                        'Reduced latency and improved performance',
                        'More storage space',
                        'Easier debugging'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is Redis commonly used for?',
                    'options' => [
                        'Relational database',
                        'In-memory data structure store and cache',
                        'Static file hosting',
                        'Email service'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What does TTL stand for in caching?',
                    'options' => [
                        'Total Transfer Limit',
                        'Time To Live',
                        'Token Trust Level',
                        'Type Transfer Layer'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is cache invalidation?',
                    'options' => [
                        'Creating a new cache',
                        'Removing or updating stale data from cache',
                        'Encrypting cache data',
                        'Backing up cache'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is the "cache-aside" pattern?',
                    'options' => [
                        'Never using cache',
                        'Application reads from cache, loads from DB on miss',
                        'Database automatically manages cache',
                        'Caching only error messages'
                    ],
                    'correct_answer' => 1,
                ],
            ],

            // Message Queues & Background Jobs
            'Message Queues & Background Jobs' => [
                [
                    'question' => 'What is the main purpose of a message queue?',
                    'options' => [
                        'To store user passwords',
                        'To enable asynchronous processing and decouple services',
                        'To cache API responses',
                        'To encrypt messages'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'Which of these is a popular message queue system?',
                    'options' => ['MySQL', 'RabbitMQ', 'Apache', 'Nginx'],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is a background job?',
                    'options' => [
                        'A job that runs in the foreground',
                        'A task executed asynchronously outside the request-response cycle',
                        'A database query',
                        'A frontend animation'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'Why use queues for sending emails?',
                    'options' => [
                        'To make emails more secure',
                        'To avoid blocking the user request while sending',
                        'To reduce email size',
                        'To change email format'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What does Laravel Queue worker do?',
                    'options' => [
                        'Creates database tables',
                        'Processes jobs from the queue',
                        'Compiles CSS files',
                        'Generates API documentation'
                    ],
                    'correct_answer' => 1,
                ],
            ],

            // Microservices Architecture
            'Microservices Architecture' => [
                [
                    'question' => 'What is a microservice?',
                    'options' => [
                        'A small database',
                        'An independently deployable service that handles a specific business capability',
                        'A tiny HTML file',
                        'A CSS framework'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is the main advantage of microservices over monolithic architecture?',
                    'options' => [
                        'Always faster',
                        'Independent scaling and deployment of services',
                        'Requires less code',
                        'No need for testing'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'How do microservices typically communicate?',
                    'options' => [
                        'Direct database access',
                        'HTTP/REST APIs or message queues',
                        'Shared memory',
                        'Global variables'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is service discovery in microservices?',
                    'options' => [
                        'Finding bugs in services',
                        'Mechanism for services to find and communicate with each other',
                        'Deleting unused services',
                        'Creating new services'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is an API Gateway in microservices?',
                    'options' => [
                        'A database connection',
                        'Single entry point that routes requests to appropriate microservices',
                        'A caching layer',
                        'A testing tool'
                    ],
                    'correct_answer' => 1,
                ],
            ],

            // Testing & TDD
            'Testing & TDD' => [
                [
                    'question' => 'What does TDD stand for?',
                    'options' => [
                        'Technical Design Document',
                        'Test-Driven Development',
                        'Type Definition Data',
                        'Total Development Deployment'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'In TDD, when do you write tests?',
                    'options' => [
                        'After writing all code',
                        'Before writing the implementation code',
                        'Never',
                        'Only for bug fixes'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is a unit test?',
                    'options' => [
                        'Testing the entire application',
                        'Testing individual functions or methods in isolation',
                        'Testing user interface only',
                        'Testing database connections'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is the purpose of mocking in tests?',
                    'options' => [
                        'To make fun of code',
                        'To simulate external dependencies and isolate the unit being tested',
                        'To slow down tests',
                        'To skip tests'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is an integration test?',
                    'options' => [
                        'Testing a single function',
                        'Testing how multiple components work together',
                        'Testing only the UI',
                        'Testing third-party libraries'
                    ],
                    'correct_answer' => 1,
                ],
            ],

            // Docker & Containerization
            'Docker & Containerization' => [
                [
                    'question' => 'What is Docker?',
                    'options' => [
                        'A programming language',
                        'A platform for developing, shipping, and running applications in containers',
                        'A database system',
                        'A web server'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is the difference between a Docker image and a container?',
                    'options' => [
                        'No difference',
                        'Image is a template, container is a running instance of an image',
                        'Container is bigger than image',
                        'Image runs code, container stores code'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is a Dockerfile?',
                    'options' => [
                        'A database file',
                        'A text file with instructions to build a Docker image',
                        'A log file',
                        'A configuration for web servers'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What command is used to build a Docker image?',
                    'options' => [
                        'docker run',
                        'docker build',
                        'docker create',
                        'docker make'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is Docker Compose used for?',
                    'options' => [
                        'Writing Dockerfiles',
                        'Defining and running multi-container Docker applications',
                        'Deleting containers',
                        'Compressing images'
                    ],
                    'correct_answer' => 1,
                ],
            ],

            // CI/CD Pipeline
            'CI/CD Pipeline' => [
                [
                    'question' => 'What does CI/CD stand for?',
                    'options' => [
                        'Code Integration/Code Deployment',
                        'Continuous Integration/Continuous Deployment',
                        'Central Installation/Central Distribution',
                        'Computer Integration/Computer Development'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is the main goal of Continuous Integration?',
                    'options' => [
                        'To deploy once a year',
                        'To automatically merge and test code changes frequently',
                        'To avoid using version control',
                        'To write less code'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What happens in a typical CI/CD pipeline?',
                    'options' => [
                        'Code is written manually',
                        'Code is built, tested, and deployed automatically',
                        'Developers manually copy files to servers',
                        'Nothing, it is just documentation'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'Which of these is a popular CI/CD tool?',
                    'options' => ['MySQL', 'GitHub Actions', 'Redis', 'Nginx'],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is the benefit of automated deployment?',
                    'options' => [
                        'More manual work',
                        'Faster, more reliable, and consistent releases',
                        'Slower releases',
                        'More bugs in production'
                    ],
                    'correct_answer' => 1,
                ],
            ],

            // GraphQL APIs
            'GraphQL APIs' => [
                [
                    'question' => 'What is GraphQL?',
                    'options' => [
                        'A database',
                        'A query language for APIs',
                        'A programming language',
                        'A web server'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is the main advantage of GraphQL over REST?',
                    'options' => [
                        'Always faster',
                        'Clients can request exactly the data they need',
                        'No need for a server',
                        'Automatically generates UI'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'In GraphQL, what is a resolver?',
                    'options' => [
                        'A type of database',
                        'A function that handles fetching data for a field',
                        'A caching mechanism',
                        'A security token'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What is a GraphQL schema?',
                    'options' => [
                        'A database table',
                        'Definition of types and operations available in the API',
                        'A CSS file',
                        'A log file'
                    ],
                    'correct_answer' => 1,
                ],
                [
                    'question' => 'What are the main operation types in GraphQL?',
                    'options' => [
                        'GET, POST, PUT, DELETE',
                        'Query, Mutation, Subscription',
                        'SELECT, INSERT, UPDATE, DELETE',
                        'READ, WRITE, EXECUTE'
                    ],
                    'correct_answer' => 1,
                ],
            ],
        ];

        foreach ($examsData as $taskTitlePart => $questions) {
            $task = Task::where('roadmap_id', $roadmapId)
                ->where('title', 'like', '%' . $taskTitlePart . '%')
                ->first();

            if (!$task) {
                echo "⚠️  Task not found: {$taskTitlePart}\n";
                continue;
            }

            // Delete existing exam if any
            if ($task->exam) {
                $task->exam->questions()->delete();
                $task->exam->delete();
            }

            // Create new exam
            $exam = TaskExam::create([
                'task_id' => $task->id,
                'questions_count' => 5,
                'passing_score' => 60,
            ]);

            // Add questions
            foreach ($questions as $questionData) {
                ExamQuestion::create([
                    'task_exam_id' => $exam->id,
                    'question' => $questionData['question'],
                    'options' => $questionData['options'],
                    'correct_answer' => $questionData['correct_answer'],
                ]);
            }

            echo "✅ Created exam for: {$task->title}\n";
        }

        echo "\n✨ Backend Intermediate exams seeded successfully!\n";
    }
}
