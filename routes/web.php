<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    return match($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'instructor' => redirect()->route('instructor.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        'company' => redirect()->route('company.dashboard'),
        default => view('dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', App\Livewire\Student\Dashboard::class)->name('dashboard');
    Route::get('/roadmaps', App\Livewire\Student\RoadmapsList::class)->name('roadmaps');
    Route::get('/roadmaps/{roadmapId}', App\Livewire\Student\RoadmapView::class)->name('roadmap.view');
    Route::get('/tasks', App\Livewire\Student\TaskList::class)->name('tasks');
    Route::get('/progress', App\Livewire\Student\ProgressTracker::class)->name('progress');
    Route::get('/jobs', App\Livewire\Student\JobListings::class)->name('jobs');
    Route::get('/jobs/{jobId}', App\Livewire\Student\JobView::class)->name('job.view');
    // Route::get('/achievements', App\Livewire\Student\AchievementBoard::class)->name('achievements'); // Removed for MVP simplicity
    Route::get('/code-editor/{taskId}', App\Livewire\Student\CodeEditor::class)->name('code-editor');
});

// Instructor Routes
Route::middleware(['auth', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', function () { return view('instructor.dashboard'); })->name('dashboard');
    Route::get('/code-review', App\Livewire\Instructor\CodeReviewQueue::class)->name('code-review');
    Route::get('/questions', App\Livewire\Instructor\StudentQuestions::class)->name('questions');
    Route::get('/student-progress', App\Livewire\Instructor\StudentProgress::class)->name('student-progress');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
    Route::get('/roadmaps', App\Livewire\Admin\RoadmapBuilder::class)->name('roadmaps');
    Route::get('/roadmaps/{roadmapId}/tasks', App\Livewire\Admin\TaskBuilder::class)->name('tasks');
    Route::get('/users', App\Livewire\Admin\UserManagement::class)->name('users');
    Route::get('/content-management', App\Livewire\Admin\ContentManagement::class)->name('content-management');
});

// Company Routes
Route::middleware(['auth', 'role:company'])->prefix('company')->name('company.')->group(function () {
    Route::get('/dashboard', function () { return view('company.dashboard'); })->name('dashboard');
    Route::get('/jobs', App\Livewire\Company\JobManagement::class)->name('jobs');
    Route::get('/applications', App\Livewire\Company\ApplicationReview::class)->name('applications');
});

require __DIR__.'/auth.php';
