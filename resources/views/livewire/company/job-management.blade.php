<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Job Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <div class="mb-6">
                <button wire:click="createJob" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                    + Create New Job
                </button>
            </div>

            <!-- Job Listings -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Your Job Postings</h3>

                @if($jobs->count() > 0)
                    <div class="space-y-4">
                        @foreach($jobs as $job)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $job->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $job->location }} • {{ ucfirst(str_replace('_', ' ', $job->job_type)) }} • {{ ucfirst($job->experience_level) }}
                                    </p>
                                    <div class="flex items-center gap-4 mt-3">
                                        <span class="px-3 py-1 bg-{{ $job->status === 'open' ? 'green' : 'gray' }}-100 dark:bg-{{ $job->status === 'open' ? 'green' : 'gray' }}-900/30 text-{{ $job->status === 'open' ? 'green' : 'gray' }}-700 dark:text-{{ $job->status === 'open' ? 'green' : 'gray' }}-300 text-xs font-semibold rounded-full">
                                            {{ ucfirst($job->status) }}
                                        </span>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $job->applications_count }} Application(s)
                                        </span>
                                        @if($job->deadline)
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            Deadline: {{ $job->deadline->format('M d, Y') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button wire:click="editJob({{ $job->id }})" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg">
                                        Edit
                                    </button>
                                    <button wire:click="deleteJob({{ $job->id }})" wire:confirm="Are you sure?" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $jobs->links() }}
                    </div>
                @else
                    <p class="text-center text-gray-500 dark:text-gray-400 py-8">No jobs posted yet. Create your first job posting!</p>
                @endif
            </div>

            <!-- Job Form Modal (Simplified) -->
            @if($showJobForm)
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto p-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">{{ $editingJobId ? 'Edit' : 'Create' }} Job</h3>

                    <form wire:submit.prevent="saveJob" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Job Title *</label>
                            <input wire:model="title" type="text" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" required>
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description *</label>
                            <textarea wire:model="description" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" required></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Location</label>
                                <input wire:model="location" type="text" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Job Type *</label>
                                <select wire:model="jobType" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                    <option value="full_time">Full Time</option>
                                    <option value="part_time">Part Time</option>
                                    <option value="contract">Contract</option>
                                    <option value="internship">Internship</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Experience Level *</label>
                                <select wire:model="experienceLevel" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                    <option value="entry">Entry</option>
                                    <option value="mid">Mid</option>
                                    <option value="senior">Senior</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Min Salary</label>
                                <input wire:model="salaryMin" type="number" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Salary</label>
                                <input wire:model="salaryMax" type="number" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Requirements</label>
                            <textarea wire:model="requirements" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Responsibilities</label>
                            <textarea wire:model="responsibilities" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Benefits</label>
                            <textarea wire:model="benefits" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                                <select wire:model="status" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                    <option value="open">Open</option>
                                    <option value="closed">Closed</option>
                                    <option value="filled">Filled</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deadline</label>
                                <input wire:model="deadline" type="date" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Positions Available *</label>
                            <input wire:model="positionsAvailable" type="number" min="1" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" required>
                        </div>

                        <!-- Custom Questions Section -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Application Questions</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add custom questions for applicants to answer</p>
                                </div>
                                <button type="button" wire:click="addQuestion" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg">
                                    + Add Question
                                </button>
                            </div>

                            @if(count($questions) > 0)
                            <div class="space-y-4">
                                @foreach($questions as $index => $question)
                                <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-900">
                                    <div class="flex items-start justify-between mb-3">
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Question {{ $index + 1 }}</span>
                                        <button type="button" wire:click="removeQuestion({{ $index }})" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                            Remove
                                        </button>
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Question Text *</label>
                                            <input wire:model="questions.{{ $index }}.question" type="text" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 text-sm" placeholder="e.g., Why do you want to work here?" required>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Question Type *</label>
                                                <select wire:model="questions.{{ $index }}.type" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 text-sm">
                                                    <option value="text">Text (Essay)</option>
                                                    <option value="yes_no">Yes/No</option>
                                                    <option value="multiple_choice">Multiple Choice</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Required?</label>
                                                <select wire:model="questions.{{ $index }}.is_required" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 text-sm">
                                                    <option value="1">Yes (Required)</option>
                                                    <option value="0">No (Optional)</option>
                                                </select>
                                            </div>
                                        </div>

                                        @if(isset($questions[$index]['type']) && $questions[$index]['type'] === 'multiple_choice')
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Options (one per line)</label>
                                            <textarea
                                                wire:model="questions.{{ $index }}.options"
                                                rows="3"
                                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 text-sm"
                                                placeholder="Option 1&#10;Option 2&#10;Option 3"
                                            ></textarea>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enter each option on a new line</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-6 bg-gray-50 dark:bg-gray-900 rounded-lg border border-dashed border-gray-300 dark:border-gray-600">
                                <p class="text-sm text-gray-500 dark:text-gray-400">No questions added yet. Click "Add Question" to create custom application questions.</p>
                            </div>
                            @endif
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                                Save Job
                            </button>
                            <button type="button" wire:click="closeJobForm" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg">
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
