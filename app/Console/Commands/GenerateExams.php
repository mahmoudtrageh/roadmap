<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\TaskExam;
use App\Models\ExamQuestion;
use App\Services\ExamQuestionGenerator;
use Illuminate\Console\Command;

class GenerateExams extends Command
{
    protected $signature = 'exams:generate {--regenerate : Regenerate all exams, deleting existing ones}';
    protected $description = 'Generate exams for all tasks with topic-specific questions';

    public function handle()
    {
        $this->info('🎯 Generating topic-specific exams for all tasks...');

        $generator = new ExamQuestionGenerator();

        if ($this->option('regenerate')) {
            $this->warn('⚠️  Regenerating all exams - this will delete existing exams and attempts!');
            if (!$this->confirm('Are you sure you want to continue?')) {
                $this->info('Operation cancelled.');
                return;
            }

            // Delete all existing exams
            TaskExam::query()->delete();
            $tasks = Task::all();
        } else {
            $tasks = Task::whereDoesntHave('exam')->get();
        }

        if ($tasks->isEmpty()) {
            $this->info('✅ All tasks already have exams!');
            return;
        }

        $bar = $this->output->createProgressBar($tasks->count());
        $bar->start();

        foreach ($tasks as $task) {
            $exam = TaskExam::create([
                'task_id' => $task->id,
                'questions_count' => 5,
                'passing_score' => 60,
            ]);

            // Generate questions based on task content
            $questions = $generator->generateQuestionsForTask($task);

            foreach ($questions as $questionData) {
                ExamQuestion::create([
                    'task_exam_id' => $exam->id,
                    'question' => $questionData['question'],
                    'options' => $questionData['options'],
                    'correct_answer' => $questionData['correct_answer'],
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Generated topic-specific exams for {$tasks->count()} tasks!");
        $this->info('📚 Questions are automatically generated based on task category and title.');
        $this->info('💡 You can further customize questions through the admin panel if needed.');
    }
}
