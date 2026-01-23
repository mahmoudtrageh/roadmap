<div>
    @if($examples && count($examples) > 0)
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 mb-4">
        <!-- Header -->
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
            </svg>
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Code Examples</h4>
        </div>

        <!-- Example Tabs (if multiple examples) -->
        @if(count($examples) > 1)
        <div class="flex gap-2 mb-4 flex-wrap">
            @foreach($examples as $index => $example)
            <button
                type="button"
                @click="$wire.selectExample({{ $index }})"
                class="px-4 py-2 rounded-lg border-2 transition-all text-sm font-medium
                    {{ $selectedExample === $index
                        ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300'
                        : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-indigo-300' }}">
                <div class="flex items-center gap-2">
                    <span>{{ $example['title'] }}</span>
                    @if($example['difficulty'])
                    <span class="text-xs px-2 py-0.5 rounded
                        {{ $example['difficulty'] === 'beginner' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : '' }}
                        {{ $example['difficulty'] === 'intermediate' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                        {{ $example['difficulty'] === 'advanced' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' : '' }}">
                        {{ ucfirst($example['difficulty']) }}
                    </span>
                    @endif
                </div>
            </button>
            @endforeach
        </div>
        @endif

        @if(isset($examples[$selectedExample]))
        @php
            $current = $examples[$selectedExample];
        @endphp

        <!-- Example Content -->
        <div class="space-y-4">
            <!-- Title & Description -->
            @if(count($examples) === 1)
            <div class="flex items-center gap-2">
                <h5 class="text-base font-semibold text-gray-800 dark:text-gray-200">{{ $current['title'] }}</h5>
                @if($current['difficulty'])
                <span class="text-xs px-2 py-1 rounded
                    {{ $current['difficulty'] === 'beginner' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : '' }}
                    {{ $current['difficulty'] === 'intermediate' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                    {{ $current['difficulty'] === 'advanced' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' : '' }}">
                    {{ ucfirst($current['difficulty']) }}
                </span>
                @endif
            </div>
            @endif

            @if($current['description'])
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $current['description'] }}</p>
            @endif

            <!-- Code Block -->
            <div class="relative">
                <div class="absolute top-2 right-2 flex items-center gap-2 z-10">
                    @if($current['language'])
                    <span class="px-2 py-1 text-xs font-medium bg-gray-800 dark:bg-gray-700 text-gray-200 rounded">
                        {{ strtoupper($current['language']) }}
                    </span>
                    @endif
                    <button
                        type="button"
                        @click="
                            navigator.clipboard.writeText({{ json_encode($current['code']) }});
                            $el.querySelector('.copy-text').textContent = 'Copied!';
                            setTimeout(() => {
                                $el.querySelector('.copy-text').textContent = 'Copy';
                            }, 2000);
                        "
                        class="px-3 py-1 text-xs font-medium bg-indigo-600 hover:bg-indigo-700 text-white rounded transition-colors flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <span class="copy-text">Copy</span>
                    </button>
                </div>
                <pre class="bg-gray-900 dark:bg-gray-950 text-gray-100 p-4 rounded-lg overflow-x-auto text-sm"><code class="language-{{ $current['language'] }}">{{ $current['code'] }}</code></pre>
            </div>

            <!-- Explanation -->
            @if($current['explanation'])
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h6 class="font-semibold text-blue-900 dark:text-blue-300 mb-1">Explanation</h6>
                        <p class="text-sm text-blue-800 dark:text-blue-200">{{ $current['explanation'] }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Output -->
            @if($current['output'])
            <div class="bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h6 class="font-semibold text-gray-900 dark:text-gray-200 mb-1">Expected Output</h6>
                        <pre class="text-sm text-gray-700 dark:text-gray-300 font-mono">{{ $current['output'] }}</pre>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
    @endif
</div>
