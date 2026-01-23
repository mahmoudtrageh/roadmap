<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Locked;

class CodeExampleBox extends Component
{
    #[Locked]
    public $taskId;

    public $examples = [];
    public $selectedExample = 0;

    public function mount($taskId)
    {
        $this->taskId = $taskId;
        $this->loadExamples();
    }

    public function loadExamples()
    {
        $taskExamples = \App\Models\TaskExample::where('task_id', $this->taskId)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        $this->examples = $taskExamples->map(function ($example) {
            return [
                'id' => $example->id,
                'title' => $example->title,
                'description' => $example->description,
                'code' => $example->code,
                'language' => $example->language,
                'difficulty' => $example->difficulty,
                'explanation' => $example->explanation,
                'output' => $example->output,
            ];
        })->toArray();
    }

    public function selectExample($index)
    {
        if (isset($this->examples[$index])) {
            $this->selectedExample = $index;
        }
    }

    public function render()
    {
        return view('livewire.student.code-example-box');
    }
}
