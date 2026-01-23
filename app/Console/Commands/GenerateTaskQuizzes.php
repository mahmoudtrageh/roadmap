<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateTaskQuizzes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:generate-quizzes
                            {--task= : Generate quiz for specific task ID}
                            {--force : Overwrite existing quizzes}
                            {--limit=50 : Limit number of quizzes to generate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate self-assessment quizzes for tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎯 Generating Task Quizzes...');
        $this->newLine();

        $query = \App\Models\Task::query();

        if ($taskId = $this->option('task')) {
            $query->where('id', $taskId);
        }

        $limit = (int) $this->option('limit');
        $tasks = $query->limit($limit)->get();

        if ($tasks->isEmpty()) {
            $this->error('No tasks found');
            return 1;
        }

        $this->info("Generating quizzes for {$tasks->count()} tasks");
        $this->newLine();

        $generated = 0;
        $skipped = 0;

        $progressBar = $this->output->createProgressBar($tasks->count());
        $progressBar->start();

        foreach ($tasks as $task) {
            $existing = \App\Models\TaskQuiz::where('task_id', $task->id)->exists();

            if ($existing && !$this->option('force')) {
                $skipped++;
                $progressBar->advance();
                continue;
            }

            $questions = $this->generateQuestions($task);

            \App\Models\TaskQuiz::updateOrCreate(
                ['task_id' => $task->id],
                [
                    'questions' => $questions,
                    'introduction' => 'Test your understanding of this topic with these questions.',
                    'passing_score' => 60,
                    'is_active' => true,
                ]
            );

            $generated++;
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("✅ Generated: {$generated}");
        $this->info("⏭  Skipped: {$skipped}");

        return 0;
    }

    private function generateQuestions($task): array
    {
        // Generate 5 questions based on task title and type
        $questions = [];
        $taskTitle = $task->title;

        // Generic educational questions - in production, these would be AI-generated or manually curated
        $questions[] = [
            'question' => "What is the main concept covered in '{$taskTitle}'?",
            'options' => [
                "Understanding the fundamentals and core principles",
                "Memorizing syntax without understanding",
                "Skipping the basics",
                "Only watching videos"
            ],
            'correct_answer' => 0,
            'explanation' => "Understanding fundamentals is key to mastering any programming concept."
        ];

        $questions[] = [
            'question' => "Why is this topic important?",
            'options' => [
                "It's not important",
                "It builds foundation for advanced concepts",
                "Only for exams",
                "Just to fill time"
            ],
            'correct_answer' => 1,
            'explanation' => "Each topic builds your foundation for more advanced programming skills."
        ];

        $questions[] = [
            'question' => "What's the best way to learn this material?",
            'options' => [
                "Just read without practice",
                "Only watch videos",
                "Combine reading, practice, and hands-on coding",
                "Skip the difficult parts"
            ],
            'correct_answer' => 2,
            'explanation' => "Active learning through multiple methods leads to better understanding."
        ];

        $questions[] = [
            'question' => "When should you move to the next topic?",
            'options' => [
                "After understanding the concepts and practicing",
                "Immediately without understanding",
                "When you feel frustrated",
                "Never"
            ],
            'correct_answer' => 0,
            'explanation' => "Ensure you grasp current concepts before moving forward."
        ];

        $questions[] = [
            'question' => "What should you do if you don't understand something?",
            'options' => [
                "Give up immediately",
                "Skip it and hope for the best",
                "Review resources, practice more, and ask questions",
                "Ignore it completely"
            ],
            'correct_answer' => 2,
            'explanation' => "Persistence and using available resources are key to overcoming challenges."
        ];

        return $questions;
    }
}
