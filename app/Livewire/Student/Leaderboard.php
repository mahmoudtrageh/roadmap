<?php

namespace App\Livewire\Student;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Leaderboard extends Component
{
    public string $selectedBoard = 'points';
    public array $topUsers = [];
    public ?array $currentUserRank = null;

    public function mount(): void
    {
        $this->loadLeaderboard();
    }

    public function switchBoard(string $board): void
    {
        $this->selectedBoard = $board;
        $this->loadLeaderboard();
    }

    public function loadLeaderboard(): void
    {
        $query = User::where('role', 'student')
            ->where('show_on_leaderboard', true);

        switch ($this->selectedBoard) {
            case 'points':
                $query->orderBy('total_points', 'desc');
                break;

            case 'streak':
                $query->orderBy('current_streak', 'desc')
                    ->orderBy('longest_streak', 'desc');
                break;

            case 'completion':
                $query->withCount(['taskCompletions as completed_count' => function ($q) {
                    $q->where('status', 'completed');
                }])
                ->orderBy('completed_count', 'desc');
                break;

            case 'quality':
                $query->withAvg(['taskCompletions as avg_quality' => function ($q) {
                    $q->where('status', 'completed')
                        ->whereNotNull('quality_rating');
                }], 'quality_rating')
                ->orderBy('avg_quality', 'desc');
                break;
        }

        $this->topUsers = $query->take(10)
            ->get()
            ->map(function ($user, $index) {
                return [
                    'rank' => $index + 1,
                    'name' => $user->leaderboard_display_name ?: $user->name,
                    'avatar' => $user->avatar,
                    'level' => $user->current_level,
                    'level_title' => $user->level_title,
                    'points' => $user->total_points,
                    'streak' => $user->current_streak,
                    'longest_streak' => $user->longest_streak,
                    'completed_count' => $user->completed_count ?? 0,
                    'avg_quality' => $user->avg_quality ? round($user->avg_quality, 1) : 0,
                    'is_current_user' => $user->id === Auth::id(),
                ];
            })
            ->toArray();

        // Find current user's rank if not in top 10
        $currentUser = Auth::user();
        if ($currentUser->show_on_leaderboard) {
            $topUserIds = collect($this->topUsers)->pluck('is_current_user');
            if (!$topUserIds->contains(true)) {
                $this->currentUserRank = $this->getCurrentUserRank($currentUser);
            }
        }
    }

    private function getCurrentUserRank(User $user): ?array
    {
        $allUsers = User::where('role', 'student')
            ->where('show_on_leaderboard', true);

        switch ($this->selectedBoard) {
            case 'points':
                $allUsers->orderBy('total_points', 'desc');
                break;

            case 'streak':
                $allUsers->orderBy('current_streak', 'desc')
                    ->orderBy('longest_streak', 'desc');
                break;

            case 'completion':
                $allUsers->withCount(['taskCompletions as completed_count' => function ($q) {
                    $q->where('status', 'completed');
                }])
                ->orderBy('completed_count', 'desc');
                break;

            case 'quality':
                $allUsers->withAvg(['taskCompletions as avg_quality' => function ($q) {
                    $q->where('status', 'completed')
                        ->whereNotNull('quality_rating');
                }], 'quality_rating')
                ->orderBy('avg_quality', 'desc');
                break;
        }

        $users = $allUsers->get();
        $rank = $users->search(function ($u) use ($user) {
            return $u->id === $user->id;
        });

        if ($rank === false) {
            return null;
        }

        $userData = $users[$rank];

        return [
            'rank' => $rank + 1,
            'name' => $user->leaderboard_display_name ?: $user->name,
            'level' => $user->current_level,
            'level_title' => $user->level_title,
            'points' => $user->total_points,
            'streak' => $user->current_streak,
            'completed_count' => $userData->completed_count ?? 0,
            'avg_quality' => $userData->avg_quality ? round($userData->avg_quality, 1) : 0,
        ];
    }

    public function render(): View
    {
        return view('livewire.student.leaderboard');
    }
}
