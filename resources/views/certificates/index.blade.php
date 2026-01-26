<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">My Certificates</h2>

                    @if($certificates->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($certificates as $certificate)
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-6 border-2 border-blue-200 dark:border-blue-800">
                                    <div class="text-center mb-4">
                                        <div class="text-4xl mb-2">🎓</div>
                                        <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $certificate->roadmap->title }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Completed {{ $certificate->issued_at->format('M d, Y') }}</p>
                                    </div>

                                    <div class="bg-white dark:bg-gray-700 rounded p-3 mb-4">
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Verification Code</div>
                                        <div class="font-mono font-bold text-blue-600 dark:text-blue-400">{{ $certificate->verification_code }}</div>
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('certificate.download', $certificate) }}" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors text-center">
                                            Download PDF
                                        </a>
                                        <a href="{{ route('certificate.verify', $certificate->verification_code) }}" target="_blank" class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 text-sm font-medium rounded-lg transition-colors text-center">
                                            Verify Certificate
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">🎓</div>
                            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">No Certificates Yet</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Complete a roadmap to earn your first certificate!</p>
                            <a href="{{ route('student.roadmaps') }}" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                Browse Roadmaps
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
