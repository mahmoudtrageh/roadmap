<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskExam;
use App\Models\ExamQuestion;
use Illuminate\Database\Seeder;

class ComprehensiveBackendExamsSeeder extends Seeder
{
    public function run(): void
    {
        $roadmapId = 6; // Backend Intermediate

        $this->command->info("🎯 Creating comprehensive exams for Backend Intermediate Roadmap...");

        $examsData = $this->getExamsData();

        $createdCount = 0;
        $skippedCount = 0;

        foreach ($examsData as $taskTitle => $questions) {
            $task = Task::where('roadmap_id', $roadmapId)
                ->where('title', $taskTitle)
                ->first();

            if (!$task) {
                $this->command->warn("⚠️  Task not found: {$taskTitle}");
                $skippedCount++;
                continue;
            }

            // Delete existing exam
            if ($task->exam) {
                $task->exam->questions()->delete();
                $task->exam->delete();
            }

            // Create exam
            $exam = TaskExam::create([
                'task_id' => $task->id,
                'questions_count' => 5,
                'passing_score' => 60,
            ]);

            // Add questions
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
        $this->command->info("✨ Created {$createdCount} exams, skipped {$skippedCount}");
    }

    private function getExamsData(): array
    {
        return [
            'Database Optimization & Indexing' => [
                ['question' => 'What is the primary purpose of a database index?', 'options' => ['To backup data', 'To speed up data retrieval', 'To encrypt data', 'To compress files'], 'correct_answer' => 1],
                ['question' => 'Which index type is best for equality searches?', 'options' => ['Full-text', 'B-Tree', 'Hash', 'Spatial'], 'correct_answer' => 2],
                ['question' => 'What is the downside of having too many indexes?', 'options' => ['Faster queries', 'Slower INSERT/UPDATE/DELETE operations', 'Less disk space', 'Better security'], 'correct_answer' => 1],
                ['question' => 'What does EXPLAIN do in SQL?', 'options' => ['Deletes data', 'Shows query execution plan', 'Creates backups', 'Validates schema'], 'correct_answer' => 1],
                ['question' => 'What is a composite index?', 'options' => ['Index on single column', 'Index on multiple columns', 'Temporary index', 'Virtual index'], 'correct_answer' => 1],
            ],

            'Laravel Cashier & Subscription Management' => [
                ['question' => 'What is Laravel Cashier?', 'options' => ['Payment processor', 'Package for subscription billing management', 'Shopping cart system', 'Cash register app'], 'correct_answer' => 1],
                ['question' => 'Which payment providers does Cashier support?', 'options' => ['Only PayPal', 'Stripe and Paddle', 'Only Bitcoin', 'Cash only'], 'correct_answer' => 1],
                ['question' => 'What is a subscription grace period?', 'options' => ['Free trial', 'Time after failed payment before cancellation', 'Discount period', 'Refund window'], 'correct_answer' => 1],
                ['question' => 'How does Cashier handle invoices?', 'options' => ['Manually only', 'Automatically generates and stores them', 'Ignores them', 'Sends via fax'], 'correct_answer' => 1],
                ['question' => 'What is prorating in subscriptions?', 'options' => ['Full charge', 'Charging proportional amount for partial period', 'Free upgrade', 'Cancellation fee'], 'correct_answer' => 1],
            ],

            'Webhook Handling & Payment Events' => [
                ['question' => 'What is a webhook?', 'options' => ['Database hook', 'HTTP callback to notify events', 'PHP function', 'CSS selector'], 'correct_answer' => 1],
                ['question' => 'Why are webhooks important for payments?', 'options' => ['They are not', 'To receive real-time payment status updates', 'To process refunds', 'To calculate taxes'], 'correct_answer' => 1],
                ['question' => 'How should you verify webhook authenticity?', 'options' => ['Trust all requests', 'Verify signature from payment provider', 'Check IP only', 'Use passwords'], 'correct_answer' => 1],
                ['question' => 'What should webhook endpoints return?', 'options' => ['Full HTML page', 'Quick 200 OK response', 'Redirect', 'Error always'], 'correct_answer' => 1],
                ['question' => 'What happens if webhook processing fails?', 'options' => ['Payment cancels', 'Provider retries webhook delivery', 'Nothing', 'Account deleted'], 'correct_answer' => 1],
            ],

            'Payment Security & PCI Compliance' => [
                ['question' => 'What does PCI DSS stand for?', 'options' => ['Personal Credit Info', 'Payment Card Industry Data Security Standard', 'Private Card Integration', 'Public Credit Interface'], 'correct_answer' => 1],
                ['question' => 'Should you store full credit card numbers?', 'options' => ['Yes always', 'No, use tokenization from payment providers', 'Only encrypted', 'In session only'], 'correct_answer' => 1],
                ['question' => 'What is tokenization in payments?', 'options' => ['Password hashing', 'Replacing sensitive data with unique identifiers', 'Encryption', 'Database indexing'], 'correct_answer' => 1],
                ['question' => 'What is 3D Secure?', 'options' => ['Encryption method', 'Additional authentication layer for card payments', 'Database type', 'Server protocol'], 'correct_answer' => 1],
                ['question' => 'How should payment data be transmitted?', 'options' => ['Plain HTTP', 'Over HTTPS/TLS only', 'Via email', 'In URL parameters'], 'correct_answer' => 1],
            ],

            'Message Queues with RabbitMQ/Redis' => [
                ['question' => 'What is RabbitMQ?', 'options' => ['Database', 'Message broker for queuing', 'Web server', 'Cache system'], 'correct_answer' => 1],
                ['question' => 'What is the main benefit of message queues?', 'options' => ['Slower processing', 'Asynchronous task processing', 'More bugs', 'Less scalability'], 'correct_answer' => 1],
                ['question' => 'What is a queue in RabbitMQ?', 'options' => ['Database table', 'Buffer that stores messages', 'API endpoint', 'Configuration file'], 'correct_answer' => 1],
                ['question' => 'What happens when a queue worker fails?', 'options' => ['Job is lost', 'Job can be retried from queue', 'System crashes', 'Queue deleted'], 'correct_answer' => 1],
                ['question' => 'What is a dead letter queue?', 'options' => ['Deleted queue', 'Queue for failed/rejected messages', 'Archived queue', 'Temporary queue'], 'correct_answer' => 1],
            ],

            'Advanced Caching Patterns' => [
                ['question' => 'What is cache-aside pattern?', 'options' => ['No caching', 'App checks cache, loads from DB on miss', 'Database manages cache', 'Cache only'], 'correct_answer' => 1],
                ['question' => 'What is write-through caching?', 'options' => ['Read only', 'Data written to cache and DB simultaneously', 'Cache after DB', 'No write'], 'correct_answer' => 1],
                ['question' => 'What is cache stampede?', 'options' => ['Cache hit', 'Multiple requests regenerate same expired cache simultaneously', 'Fast cache', 'Cache delete'], 'correct_answer' => 1],
                ['question' => 'How to prevent cache stampede?', 'options' => ['Remove cache', 'Use locks or probabilistic early expiration', 'Increase TTL to 1 year', 'Disable cache'], 'correct_answer' => 1],
                ['question' => 'What is distributed caching?', 'options' => ['Single server cache', 'Cache shared across multiple servers', 'No cache', 'Browser cache'], 'correct_answer' => 1],
            ],

            'Cloud Storage & CDN Integration' => [
                ['question' => 'What is a CDN?', 'options' => ['Database', 'Content Delivery Network for distributing content', 'Programming language', 'Framework'], 'correct_answer' => 1],
                ['question' => 'What is the main benefit of using a CDN?', 'options' => ['More storage', 'Faster content delivery by serving from nearest location', 'Better security only', 'Cheaper storage'], 'correct_answer' => 1],
                ['question' => 'What is Amazon S3?', 'options' => ['Database', 'Object storage service', 'Web server', 'Email service'], 'correct_answer' => 1],
                ['question' => 'What are presigned URLs?', 'options' => ['Public URLs', 'Temporary URLs granting limited access to private objects', 'Shortened URLs', 'Encrypted URLs'], 'correct_answer' => 1],
                ['question' => 'What is CloudFront?', 'options' => ['Database', 'AWS CDN service', 'Email service', 'Payment processor'], 'correct_answer' => 1],
            ],

            'WebSockets & Real-time Communication' => [
                ['question' => 'What are WebSockets?', 'options' => ['Database sockets', 'Full-duplex communication protocol over TCP', 'HTTP requests', 'File protocol'], 'correct_answer' => 1],
                ['question' => 'What is the main advantage of WebSockets over HTTP polling?', 'options' => ['Slower', 'Real-time bidirectional communication', 'More bandwidth', 'Less secure'], 'correct_answer' => 1],
                ['question' => 'What is Laravel Echo?', 'options' => ['Database', 'JavaScript library for subscribing to channels and events', 'Payment library', 'Testing tool'], 'correct_answer' => 1],
                ['question' => 'What is Pusher?', 'options' => ['Database', 'Hosted WebSocket service', 'Framework', 'Language'], 'correct_answer' => 1],
                ['question' => 'What is broadcasting in Laravel?', 'options' => ['Email sending', 'Pushing events to WebSocket connections', 'Database queries', 'File uploads'], 'correct_answer' => 1],
            ],

            'API Rate Limiting & Throttling' => [
                ['question' => 'What is API rate limiting?', 'options' => ['Speed boost', 'Restricting number of requests in time period', 'Caching', 'Authentication'], 'correct_answer' => 1],
                ['question' => 'Why implement rate limiting?', 'options' => ['Slow down users', 'Prevent abuse and ensure fair usage', 'Increase costs', 'Break APIs'], 'correct_answer' => 1],
                ['question' => 'What HTTP status code indicates rate limit exceeded?', 'options' => ['200', '429 Too Many Requests', '404', '500'], 'correct_answer' => 1],
                ['question' => 'What is the token bucket algorithm?', 'options' => ['Authentication', 'Rate limiting by allowing burst of requests', 'Caching', 'Encryption'], 'correct_answer' => 1],
                ['question' => 'What header informs clients about rate limits?', 'options' => ['Content-Type', 'X-RateLimit-Limit and X-RateLimit-Remaining', 'Authorization', 'Accept'], 'correct_answer' => 1],
            ],

            'Testing & Test-Driven Development' => [
                ['question' => 'What is TDD?', 'options' => ['Testing at end', 'Writing tests before implementation', 'No testing', 'Manual testing'], 'correct_answer' => 1],
                ['question' => 'What is a unit test?', 'options' => ['Full app test', 'Testing individual methods/functions in isolation', 'UI testing', 'Load testing'], 'correct_answer' => 1],
                ['question' => 'What is test coverage?', 'options' => ['Test speed', 'Percentage of code executed by tests', 'Number of tests', 'Test duration'], 'correct_answer' => 1],
                ['question' => 'What is mocking?', 'options' => ['Making fun', 'Simulating dependencies in tests', 'Deleting tests', 'Running tests'], 'correct_answer' => 1],
                ['question' => 'What is a feature test?', 'options' => ['Unit test', 'Testing complete features/workflows', 'Database test', 'Speed test'], 'correct_answer' => 1],
            ],

            'File Uploads & Storage' => [
                ['question' => 'What is Laravel Storage facade used for?', 'options' => ['Database', 'File system operations', 'Caching', 'Routing'], 'correct_answer' => 1],
                ['question' => 'What file upload validation should you implement?', 'options' => ['None', 'Type, size, and security checks', 'Size only', 'Trust all files'], 'correct_answer' => 1],
                ['question' => 'What is a storage disk in Laravel?', 'options' => ['Hard drive', 'Configured file storage location', 'Database', 'Cache'], 'correct_answer' => 1],
                ['question' => 'How to prevent file upload vulnerabilities?', 'options' => ['Allow all files', 'Validate file type, sanitize names, store outside public', 'Store in public root', 'No validation'], 'correct_answer' => 1],
                ['question' => 'What is chunked upload?', 'options' => ['Small files', 'Splitting large files into chunks for upload', 'Compressed upload', 'Encrypted upload'], 'correct_answer' => 1],
            ],
        ];
    }
}
