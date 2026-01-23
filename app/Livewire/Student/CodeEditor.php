<?php

namespace App\Livewire\Student;

use App\Models\CodeSubmission;
use App\Models\Task;
use App\Models\TaskCompletion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class CodeEditor extends Component
{
    use WithFileUploads;

    public $taskId;
    public $task;
    public $taskCompletion;
    public $existingSubmission;

    #[Validate('nullable|file|max:10240')] // 10MB max for single files
    public $file;

    #[Validate('nullable|file|mimes:zip|max:51200')] // 50MB max for ZIP files
    public $zipFile;

    public $submissionNotes = '';

    public function mount($taskId): void
    {
        $this->taskId = $taskId;
        $this->task = Task::with('roadmap')->findOrFail($taskId);

        if (!$this->task->has_code_submission) {
            abort(404, 'This task does not require code submission.');
        }

        // Get active enrollment
        $activeEnrollment = Auth::user()->enrollments()
            ->where('status', 'active')
            ->first();

        if (!$activeEnrollment) {
            abort(403, 'You must be enrolled in a roadmap to submit code.');
        }

        // Get or create task completion
        $this->taskCompletion = TaskCompletion::firstOrCreate(
            [
                'task_id' => $this->taskId,
                'student_id' => Auth::id(),
                'enrollment_id' => $activeEnrollment->id,
            ],
            [
                'status' => 'in_progress',
                'started_at' => now(),
            ]
        );

        // Load existing submission if available
        $this->existingSubmission = CodeSubmission::where('task_completion_id', $this->taskCompletion->id)
            ->latest()
            ->first();

        if ($this->existingSubmission) {
            $this->submissionNotes = $this->existingSubmission->submission_notes ?? '';
        }
    }

    public function submitFile(): void
    {
        $this->validate([
            'file' => 'required|file|max:10240|mimes:html,css,js,py,java,php,cpp,cs,rb,go,rs,ts,txt,json,xml,md',
        ]);

        try {
            // Store the file
            $filePath = $this->file->store('code-submissions/' . Auth::id(), 'local');
            $originalName = $this->file->getClientOriginalName();

            // Delete old file if exists
            if ($this->existingSubmission && $this->existingSubmission->file_path) {
                Storage::disk('local')->delete($this->existingSubmission->file_path);
            }

            // Create or update submission
            if ($this->existingSubmission) {
                $this->existingSubmission->update([
                    'file_path' => $filePath,
                    'original_filename' => $originalName,
                    'submission_notes' => $this->submissionNotes,
                    'submission_status' => 'submitted',
                    'language' => $this->detectLanguage($originalName),
                    'code_content' => null,
                ]);
            } else {
                $this->existingSubmission = CodeSubmission::create([
                    'task_completion_id' => $this->taskCompletion->id,
                    'student_id' => Auth::id(),
                    'file_path' => $filePath,
                    'original_filename' => $originalName,
                    'submission_notes' => $this->submissionNotes,
                    'submission_status' => 'submitted',
                    'language' => $this->detectLanguage($originalName),
                ]);
            }

            // Mark task as completed
            $this->taskCompletion->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            $this->file = null;
            session()->flash('message', 'File submitted successfully! Waiting for instructor review.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error uploading file: ' . $e->getMessage());
        }
    }

    public function submitZip(): void
    {
        $this->validate([
            'zipFile' => 'required|file|mimes:zip|max:51200',
        ]);

        try {
            // Store the ZIP file
            $filePath = $this->zipFile->store('code-submissions/' . Auth::id(), 'local');
            $originalName = $this->zipFile->getClientOriginalName();

            // Delete old file if exists
            if ($this->existingSubmission && $this->existingSubmission->file_path) {
                Storage::disk('local')->delete($this->existingSubmission->file_path);
            }

            // Create or update submission
            if ($this->existingSubmission) {
                $this->existingSubmission->update([
                    'file_path' => $filePath,
                    'original_filename' => $originalName,
                    'submission_notes' => $this->submissionNotes,
                    'submission_status' => 'submitted',
                    'language' => 'zip',
                    'code_content' => null,
                ]);
            } else {
                $this->existingSubmission = CodeSubmission::create([
                    'task_completion_id' => $this->taskCompletion->id,
                    'student_id' => Auth::id(),
                    'file_path' => $filePath,
                    'original_filename' => $originalName,
                    'submission_notes' => $this->submissionNotes,
                    'submission_status' => 'submitted',
                    'language' => 'zip',
                ]);
            }

            // Mark task as completed
            $this->taskCompletion->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            $this->zipFile = null;
            session()->flash('message', 'ZIP file submitted successfully! Waiting for instructor review.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error uploading ZIP: ' . $e->getMessage());
        }
    }

    public function deleteSubmission(): void
    {
        if (!$this->existingSubmission) {
            return;
        }

        try {
            // Delete file from storage
            if ($this->existingSubmission->file_path) {
                Storage::disk('local')->delete($this->existingSubmission->file_path);
            }

            $this->existingSubmission->delete();
            $this->existingSubmission = null;

            // Reset task status
            $this->taskCompletion->update([
                'status' => 'in_progress',
                'completed_at' => null,
            ]);

            session()->flash('message', 'Submission deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting submission: ' . $e->getMessage());
        }
    }

    public function downloadSubmission()
    {
        if (!$this->existingSubmission || !$this->existingSubmission->file_path) {
            session()->flash('error', 'No file to download.');
            return;
        }

        return Storage::disk('local')->download(
            $this->existingSubmission->file_path,
            $this->existingSubmission->original_filename
        );
    }

    private function detectLanguage(string $filename): string
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $languageMap = [
            'html' => 'html',
            'htm' => 'html',
            'css' => 'css',
            'js' => 'javascript',
            'ts' => 'typescript',
            'py' => 'python',
            'java' => 'java',
            'cpp' => 'cpp',
            'cc' => 'cpp',
            'cs' => 'csharp',
            'php' => 'php',
            'rb' => 'ruby',
            'go' => 'go',
            'rs' => 'rust',
        ];

        return $languageMap[$extension] ?? 'text';
    }

    public function getReviewsProperty()
    {
        if (!$this->existingSubmission) {
            return collect([]);
        }

        return $this->existingSubmission->codeReviews()
            ->with('reviewer')
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.student.code-editor', [
            'reviews' => $this->reviews,
        ]);
    }
}
