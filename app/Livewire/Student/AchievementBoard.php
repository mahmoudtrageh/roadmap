<?php

namespace App\Livewire\Student;

use App\Services\AchievementService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class AchievementBoard extends Component
{
    public array $achievements = [];
    public int $totalAchievements = 0;
    public int $earnedAchievements = 0;
    public int $totalPoints = 0;
    public array $nextAchievements = [];
    public string $filterType = 'all'; // all, earned, locked
    public string $sortBy = 'points'; // points, name, type, progress

    protected AchievementService $achievementService;

    public function boot(AchievementService $achievementService): void
    {
        $this->achievementService = $achievementService;
    }

    public function mount(): void
    {
        $this->loadAchievements();
    }

    public function loadAchievements(): void
    {
        $user = Auth::user();

        // Get achievement progress from service
        $progressData = $this->achievementService->getUserAchievementProgress($user);

        $this->totalAchievements = $progressData['total_achievements'];
        $this->earnedAchievements = $progressData['earned_achievements'];
        $this->totalPoints = $progressData['total_points'];
        $this->achievements = $progressData['achievements'];

        // Find next achievements (locked achievements with highest progress)
        $this->nextAchievements = collect($this->achievements)
            ->filter(fn($a) => !$a['earned'] && $a['progress'] > 0)
            ->sortByDesc('progress')
            ->take(3)
            ->values()
            ->toArray();

        // Apply filters and sorting
        $this->applyFiltersAndSorting();
    }

    public function applyFiltersAndSorting(): void
    {
        $achievements = collect($this->achievements);

        // Apply filter
        if ($this->filterType === 'earned') {
            $achievements = $achievements->filter(fn($a) => $a['earned']);
        } elseif ($this->filterType === 'locked') {
            $achievements = $achievements->filter(fn($a) => !$a['earned']);
        }

        // Apply sorting
        $achievements = match($this->sortBy) {
            'name' => $achievements->sortBy('name'),
            'type' => $achievements->sortBy('type'),
            'progress' => $achievements->sortByDesc('progress'),
            default => $achievements->sortByDesc('points'),
        };

        $this->achievements = $achievements->values()->toArray();
    }

    public function setFilter(string $filter): void
    {
        $this->filterType = $filter;
        $this->loadAchievements();
    }

    public function setSorting(string $sort): void
    {
        $this->sortBy = $sort;
        $this->applyFiltersAndSorting();
    }

    public function checkForNewAchievements(): void
    {
        $user = Auth::user();
        $this->achievementService->checkAndAwardAchievements($user);
        $this->loadAchievements();
        session()->flash('message', 'Achievements checked and updated!');
    }

    public function render(): View
    {
        return view('livewire.student.achievement-board');
    }
}
