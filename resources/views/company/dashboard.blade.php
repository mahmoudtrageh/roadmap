<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Company Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $company = auth()->user()->company;
                $totalJobs = $company ? $company->jobListings()->count() : 0;
                $openJobs = $company ? $company->jobListings()->where('status', 'open')->count() : 0;
                $totalApplications = $company ? \App\Models\JobApplication::whereIn('job_id', $company->jobListings()->pluck('id'))->count() : 0;
                $pendingApplications = $company ? \App\Models\JobApplication::whereIn('job_id', $company->jobListings()->pluck('id'))->where('status', 'pending')->count() : 0;
            @endphp

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Total Job Postings</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalJobs }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Open Positions</div>
                    <div class="text-3xl font-bold text-green-600">{{ $openJobs }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Total Applications</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalApplications }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Pending Review</div>
                    <div class="text-3xl font-bold text-orange-600">{{ $pendingApplications }}</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('company.jobs') }}" class="block px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                            Manage Job Postings
                        </a>
                        <a href="{{ route('company.applications') }}" class="block px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg transition">
                            Review Applications
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Company Profile</h3>
                    @if($company)
                    <div class="space-y-2 text-sm">
                        <p><strong>Company:</strong> {{ $company->name }}</p>
                        <p><strong>Industry:</strong> {{ $company->industry }}</p>
                        <p><strong>Location:</strong> {{ $company->location }}</p>
                        <p><strong>Size:</strong> {{ $company->size }}</p>
                        @if($company->is_verified)
                        <p class="text-green-600"><strong>✓ Verified Company</strong></p>
                        @endif
                    </div>
                    @else
                    <p class="text-gray-600">Please complete your company profile</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
