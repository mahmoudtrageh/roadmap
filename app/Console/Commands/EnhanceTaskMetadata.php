<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;

class EnhanceTaskMetadata extends Command
{
    protected $signature = 'tasks:enhance-metadata';
    protected $description = 'Add enhanced metadata to all tasks (learning objectives, success criteria, tips, etc.)';

    public function handle()
    {
        $this->info('Enhancing task metadata...');

        $tasks = Task::all();
        $updated = 0;

        foreach ($tasks as $task) {
            $metadata = $this->generateMetadata($task);

            $task->update($metadata);
            $updated++;

            $this->info("✓ Enhanced: {$task->title}");
        }

        $this->info("\n✅ Completed! Enhanced {$updated} tasks.");
    }

    private function generateMetadata(Task $task)
    {
        $metadata = [];

        // Generate learning objectives if not present
        if (empty($task->learning_objectives)) {
            $metadata['learning_objectives'] = $this->generateLearningObjectives($task);
        }

        // Generate skills gained if not present
        if (empty($task->skills_gained)) {
            $metadata['skills_gained'] = $this->generateSkillsGained($task);
        }

        // Generate success criteria
        if (empty($task->success_criteria)) {
            $metadata['success_criteria'] = $this->generateSuccessCriteria($task);
        }

        // Generate common mistakes
        if (empty($task->common_mistakes)) {
            $metadata['common_mistakes'] = $this->generateCommonMistakes($task);
        }

        // Generate quick tips
        if (empty($task->quick_tips)) {
            $metadata['quick_tips'] = $this->generateQuickTips($task);
        }

        // Generate prerequisites based on task order
        if (empty($task->prerequisites)) {
            $metadata['prerequisites'] = $this->generatePrerequisites($task);
        }

        return $metadata;
    }

    private function generateLearningObjectives(Task $task)
    {
        // Extract key concepts from description
        $objectives = [];

        if (str_contains($task->description, 'Understand')) {
            $objectives[] = 'Understand ' . strtolower(str_replace('Understand ', '', $task->description));
        } elseif (str_contains($task->description, 'Learn')) {
            $objectives[] = 'Learn ' . strtolower(str_replace('Learn ', '', $task->description));
        } else {
            $objectives[] = $task->description;
        }

        // Add task-type specific objectives
        if ($task->task_type === 'reading') {
            $objectives[] = 'Gain theoretical knowledge of ' . strtolower($task->category);
        } elseif ($task->task_type === 'exercise') {
            $objectives[] = 'Practice ' . strtolower($task->category) . ' through hands-on exercises';
        } elseif ($task->task_type === 'project') {
            $objectives[] = 'Build a real-world project demonstrating ' . strtolower($task->category);
        } elseif ($task->task_type === 'video') {
            $objectives[] = 'Watch and understand visual explanations of ' . strtolower($task->category);
        }

        return array_slice($objectives, 0, 3);
    }

    private function generateSkillsGained(Task $task)
    {
        $skills = [];

        // Base skill from category
        $skills[] = $task->category;

        // Add task-type specific skills
        if ($task->task_type === 'exercise') {
            $skills[] = 'Practical application';
            $skills[] = 'Problem-solving';
        } elseif ($task->task_type === 'project') {
            $skills[] = 'Project development';
            $skills[] = 'Real-world implementation';
        } elseif ($task->task_type === 'reading') {
            $skills[] = 'Conceptual understanding';
        }

        return array_slice(array_unique($skills), 0, 3);
    }

    private function generateSuccessCriteria(Task $task)
    {
        $criteria = [];

        // General criteria
        $criteria[] = 'Complete all required reading/viewing materials';

        if ($task->has_code_submission) {
            $criteria[] = 'Submit working code that meets the requirements';
            $criteria[] = 'Code passes all test cases';
        }

        if ($task->task_type === 'exercise') {
            $criteria[] = 'Successfully complete the practice exercise';
            $criteria[] = 'Understand the solution approach';
        } elseif ($task->task_type === 'project') {
            $criteria[] = 'Build a functional project';
            $criteria[] = 'Implement all required features';
        } elseif ($task->task_type === 'reading') {
            $criteria[] = 'Can explain key concepts in your own words';
        }

        $criteria[] = 'Review and understand all resources provided';

        return array_slice($criteria, 0, 5);
    }

    private function generateCommonMistakes(Task $task)
    {
        $mistakes = [];

        if ($task->task_type === 'reading') {
            $mistakes[] = "Don't rush through the reading material. Take notes and try to understand concepts deeply rather than memorizing facts.";
        } elseif ($task->task_type === 'exercise') {
            $mistakes[] = "Many students copy solutions without understanding. Make sure you can explain why the solution works.";
        } elseif ($task->task_type === 'project') {
            $mistakes[] = "Don't skip planning. Spend time understanding requirements before coding. Breaking down the project into smaller steps prevents overwhelm.";
        }

        if ($task->has_code_submission) {
            $mistakes[] = "Test your code with different inputs, not just the example provided. Edge cases often reveal bugs.";
        }

        $mistakes[] = "If stuck for more than 30 minutes, use the hint system or review resources again. Struggling is good, but spinning wheels isn't productive.";

        return implode(' ', array_slice($mistakes, 0, 3));
    }

    private function generateQuickTips(Task $task)
    {
        $tips = [];

        $tips[] = "Take breaks every 25-30 minutes to stay focused.";

        if ($task->task_type === 'reading') {
            $tips[] = "Take notes in your own words - this helps solidify understanding.";
        } elseif ($task->task_type === 'exercise' || $task->task_type === 'project') {
            $tips[] = "Start with the simplest version first, then add complexity.";
        }

        $tips[] = "Check the resource ratings to see which materials other students found most helpful.";

        if ($task->has_code_submission) {
            $tips[] = "Write comments explaining your code - it helps you think clearly.";
        }

        return implode(' ', array_slice($tips, 0, 3));
    }

    private function generatePrerequisites(Task $task)
    {
        $prerequisites = [];

        // Tasks must be completed in order within the same day
        if ($task->order > 1) {
            $previousTask = Task::where('roadmap_id', $task->roadmap_id)
                ->where('day_number', $task->day_number)
                ->where('order', '<', $task->order)
                ->orderBy('order', 'desc')
                ->first();

            if ($previousTask) {
                $prerequisites[] = $previousTask->id;
            }
        }

        return $prerequisites;
    }
}
