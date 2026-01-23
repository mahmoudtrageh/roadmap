<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Job Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-8">
                    <div class="flex items-start gap-6 mb-6">
                        @if($job->company->logo)
                        <img src="{{ Storage::url($job->company->logo) }}" alt="{{ $job->company->name }}" class="w-24 h-24 rounded-lg object-cover">
                        @else
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-4xl">
                            {{ substr($job->company->name, 0, 1) }}
                        </div>
                        @endif

                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $job->title }}</h1>
                            <p class="text-lg text-gray-600 dark:text-gray-400 mb-3">{{ $job->company->name }}</p>

                            <div class="flex flex-wrap items-center gap-2">
                                @if($job->location)
                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded-full">
                                    📍 {{ $job->location }}
                                </span>
                                @endif
                                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm font-semibold rounded-full">
                                    {{ ucfirst(str_replace('_', ' ', $job->job_type)) }}
                                </span>
                                <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-sm font-semibold rounded-full">
                                    {{ ucfirst($job->experience_level) }} Level
                                </span>
                                @if($job->salary_min && $job->salary_max)
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-sm font-semibold rounded-full">
                                    💰 ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            @if($hasApplied)
                            <span class="inline-block px-6 py-3 bg-green-100 text-green-700 font-semibold rounded-lg">
                                ✓ Applied
                            </span>
                            @else
                            <button
                                wire:click="toggleApplicationForm"
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                                Apply Now
                            </button>
                            @endif
                        </div>
                    </div>

                    @if($job->deadline)
                    <div class="mb-6 p-4 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg">
                        <p class="text-sm text-orange-800 dark:text-orange-300">
                            ⏰ <strong>Application Deadline:</strong> {{ $job->deadline->format('F d, Y') }}
                        </p>
                    </div>
                    @endif

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Job Description</h3>
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $job->description }}</p>
                        </div>

                        @if($job->responsibilities)
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Responsibilities</h3>
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $job->responsibilities }}</p>
                        </div>
                        @endif

                        @if($job->requirements)
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Requirements</h3>
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $job->requirements }}</p>
                        </div>
                        @endif

                        @if($job->benefits)
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Benefits</h3>
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $job->benefits }}</p>
                        </div>
                        @endif

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">About {{ $job->company->name }}</h3>
                            <p class="text-gray-700 dark:text-gray-300">{{ $job->company->description ?? 'No company description available.' }}</p>
                            @if($job->company->website)
                            <p class="mt-2">
                                <a href="{{ $job->company->website }}" target="_blank" class="text-blue-600 hover:text-blue-700">
                                    🌐 Visit Company Website →
                                </a>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            @if($showApplicationForm && !$hasApplied)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Submit Your Application</h2>

                    <form wire:submit.prevent="submitApplication" class="space-y-6">
                        <!-- CV Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Resume/CV * <span class="text-xs text-gray-500">(PDF, DOC, DOCX - Max 2MB)</span>
                            </label>
                            <input
                                type="file"
                                wire:model="cv"
                                accept=".pdf,.doc,.docx"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                            >
                            @error('cv')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <div wire:loading wire:target="cv" class="mt-1 text-sm text-blue-600">Uploading...</div>
                        </div>

                        <!-- Cover Letter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Cover Letter (Optional)
                            </label>
                            <textarea
                                wire:model="coverLetter"
                                rows="5"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                placeholder="Tell us why you're a great fit for this role..."
                            ></textarea>
                            @error('coverLetter')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Application Questions -->
                        @if($job->questions->count() > 0)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Application Questions</h3>
                            <div class="space-y-4">
                                @foreach($job->questions as $question)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ $question->question }}
                                        @if($question->is_required)
                                        <span class="text-red-500">*</span>
                                        @endif
                                    </label>

                                    @if($question->type === 'text')
                                        <textarea
                                            wire:model="answers.{{ $question->id }}"
                                            rows="3"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                        ></textarea>
                                    @elseif($question->type === 'yes_no')
                                        <select
                                            wire:model="answers.{{ $question->id }}"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                        >
                                            <option value="">Select...</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    @elseif($question->type === 'multiple_choice' && $question->options)
                                        <select
                                            wire:model="answers.{{ $question->id }}"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                        >
                                            <option value="">Select an option...</option>
                                            @foreach($question->options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    @endif

                                    @error('answers.' . $question->id)
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Submit Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button
                                type="submit"
                                class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors"
                            >
                                Submit Application
                            </button>
                            <button
                                type="button"
                                wire:click="toggleApplicationForm"
                                class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
