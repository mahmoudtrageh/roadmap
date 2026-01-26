<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-2xl w-full">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-8 text-center">
                    <div class="text-6xl mb-4">✓</div>
                    <h1 class="text-3xl font-bold text-white">Certificate Verified</h1>
                    <p class="text-green-100 mt-2">This certificate is authentic and valid</p>
                </div>

                <div class="p-8">
                    <div class="space-y-6">
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Student Name</div>
                            <div class="text-xl font-bold text-gray-900">{{ $certificate->student->name }}</div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-500 mb-1">Roadmap Completed</div>
                            <div class="text-xl font-bold text-gray-900">{{ $certificate->roadmap->title }}</div>
                            <div class="text-sm text-gray-600 mt-1">{{ $certificate->roadmap->description }}</div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Completion Date</div>
                                <div class="font-semibold text-gray-900">{{ $certificate->issued_at->format('F d, Y') }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Verification Code</div>
                                <div class="font-mono font-bold text-blue-600">{{ $certificate->verification_code }}</div>
                            </div>
                        </div>

                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <div class="font-semibold text-green-900">Verified Certificate</div>
                                    <div class="text-sm text-green-700 mt-1">
                                        This certificate was issued on {{ $certificate->issued_at->format('F d, Y') }} and is valid.
                                        The student has successfully completed all required tasks and assessments.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <a href="{{ url('/') }}" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-6 text-gray-600 text-sm">
                <p>Certificate ID: {{ $certificate->id }} | Issued: {{ $certificate->issued_at->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    </div>
</body>
</html>
