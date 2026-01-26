<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ThemeToggle extends Component
{
    public string $theme;

    public function mount(): void
    {
        $this->theme = Auth::user()->theme_preference ?? 'auto';
    }

    public function setTheme(string $theme): void
    {
        $this->theme = $theme;

        $user = Auth::user();
        $user->theme_preference = $theme;
        $user->save();

        $this->dispatch('theme-changed', theme: $theme);
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}
