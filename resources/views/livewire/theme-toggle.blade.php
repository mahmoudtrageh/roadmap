<div class="flex items-center gap-2">
    <button
        wire:click="setTheme('light')"
        class="p-2 rounded-lg transition-colors {{ $theme === 'light' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
        title="Light mode"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    </button>

    <button
        wire:click="setTheme('dark')"
        class="p-2 rounded-lg transition-colors {{ $theme === 'dark' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
        title="Dark mode"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
    </button>

    <button
        wire:click="setTheme('auto')"
        class="p-2 rounded-lg transition-colors {{ $theme === 'auto' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
        title="Auto (system preference)"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
    </button>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('theme-changed', (event) => {
            applyTheme(event.theme);
        });
    });

    // Apply theme on page load
    function applyTheme(preference) {
        let isDark = false;

        if (preference === 'dark') {
            isDark = true;
        } else if (preference === 'auto') {
            isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        }

        if (isDark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }

    // Initial theme application
    @if(auth()->check())
        applyTheme('{{ auth()->user()->theme_preference ?? "auto" }}');
    @endif
</script>
