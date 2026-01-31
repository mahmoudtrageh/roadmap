<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Roadmap Camp - Master Programming with Structured Learning Paths</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased dark:bg-gray-900 dark:text-white">
        <div class="bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-white">

            <!-- Header -->
            <header class="relative overflow-hidden">
                <nav class="container mx-auto px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-3xl">🗺️</span>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Roadmap Camp
                            </h1>
                        </div>
                        @if (Route::has('login'))
                            <div class="flex gap-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-6 py-2 text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-semibold transition-colors">
                                        Log in
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                                            Get Started
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </nav>

                <!-- Hero Section -->
                <div class="container mx-auto px-6 py-20">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <h2 class="text-5xl font-bold mb-6 leading-tight">
                                Master Programming with
                                <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    Structured Roadmaps
                                </span>
                            </h2>
                            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                                From complete beginner to professional developer. Follow our comprehensive, step-by-step learning paths designed by industry experts.
                            </p>

                            <!-- Weekly Sessions Notice -->
                            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg p-6 mb-8 text-white shadow-xl">
                                <div class="flex items-start gap-4">
                                    <div class="text-4xl">📅</div>
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold mb-2">Live Weekly Sessions</h3>
                                        <p class="text-green-100 mb-2">
                                            Join our instructor-led sessions every Saturday
                                        </p>
                                        <div class="flex items-center gap-2 text-sm">
                                            <span class="font-semibold">⏰ 10:00 AM - 12:00 PM</span>
                                            <span class="opacity-75">|</span>
                                            <span>Cairo Time (GMT+2)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-center shadow-lg transition-colors">
                                    Start Learning Free →
                                </a>
                                <a href="#features" class="inline-block px-8 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white rounded-lg font-semibold text-center shadow-lg transition-colors">
                                    Explore Features
                                </a>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="aspect-square bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl transform rotate-3 absolute inset-0 opacity-10"></div>
                            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8">
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                        <span class="text-2xl">✅</span>
                                        <span class="font-semibold">16 Structured Roadmaps</span>
                                    </div>
                                    <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                        <span class="text-2xl">📚</span>
                                        <span class="font-semibold">200+ Learning Tasks</span>
                                    </div>
                                    <div class="flex items-center gap-3 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                        <span class="text-2xl">🎯</span>
                                        <span class="font-semibold">Track Your Progress</span>
                                    </div>
                                    <div class="flex items-center gap-3 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                        <span class="text-2xl">💼</span>
                                        <span class="font-semibold">Job Opportunities</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Features Section -->
            <section id="features" class="py-20 bg-white dark:bg-gray-900">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4">Why Choose Roadmap Camp?</h2>
                        <p class="text-xl text-gray-600 dark:text-gray-300">Everything you need to become a professional developer</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                            <div class="text-5xl mb-4">🗺️</div>
                            <h3 class="text-2xl font-bold mb-3">Structured Learning Paths</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Follow comprehensive roadmaps from Foundation to Professional level. Each path is carefully designed with clear progression.
                            </p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                            <div class="text-5xl mb-4">📅</div>
                            <h3 class="text-2xl font-bold mb-3">Weekly Live Sessions</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Join instructor-led sessions every Saturday (10 AM - 12 PM Cairo Time) for guidance, Q&A, and collaborative learning.
                            </p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                            <div class="text-5xl mb-4">💻</div>
                            <h3 class="text-2xl font-bold mb-3">Hands-On Practice</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Learn by doing with practical tasks, coding challenges, and real-world projects. Submit code for review and feedback.
                            </p>
                        </div>

                        <!-- Feature 4 -->
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                            <div class="text-5xl mb-4">📊</div>
                            <h3 class="text-2xl font-bold mb-3">Progress Tracking</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Monitor your learning journey with detailed analytics and completion rates to stay on track.
                            </p>
                        </div>

                        <!-- Feature 5 -->
                        <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                            <div class="text-5xl mb-4">📚</div>
                            <h3 class="text-2xl font-bold mb-3">Rich Resources</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Access curated YouTube channels, programming blogs, podcasts, and newsletters to supplement your learning.
                            </p>
                        </div>

                        <!-- Feature 6 -->
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                            <div class="text-5xl mb-4">💼</div>
                            <h3 class="text-2xl font-bold mb-3">Job Board Access</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Connect with companies hiring developers and apply for real job opportunities as you progress through your learning journey.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Roadmaps Overview -->
            <section class="py-20 bg-gray-50 dark:bg-gray-800">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4">Available Learning Paths</h2>
                        <p class="text-xl text-gray-600 dark:text-gray-300">Choose your path and start your journey today</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <div class="text-4xl mb-3">📖</div>
                            <h3 class="text-xl font-bold mb-2">Foundation</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Master computer fundamentals, programming basics, and internet concepts</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">17 days</span>
                                <span class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full text-xs font-semibold">Beginner</span>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <div class="text-4xl mb-3">🎨</div>
                            <h3 class="text-xl font-bold mb-2">Frontend Development</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">HTML, CSS, JavaScript, React and modern frontend frameworks</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Multiple phases</span>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full text-xs font-semibold">Progressive</span>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <div class="text-4xl mb-3">⚙️</div>
                            <h3 class="text-xl font-bold mb-2">Backend Development</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">PHP, Laravel, databases, APIs and server-side development</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Multiple phases</span>
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 rounded-full text-xs font-semibold">Intermediate</span>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <div class="text-4xl mb-3">🧩</div>
                            <h3 class="text-xl font-bold mb-2">Algorithms & Data Structures</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Master DSA, problem-solving, and interview preparation</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">30 days</span>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded-full text-xs font-semibold">Intermediate</span>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <div class="text-4xl mb-3">🚀</div>
                            <h3 class="text-xl font-bold mb-2">DevOps & Deployment</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Git, Docker, CI/CD, cloud deployment and automation</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">6 days</span>
                                <span class="px-3 py-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-full text-xs font-semibold">Advanced</span>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <div class="text-4xl mb-3">💼</div>
                            <h3 class="text-xl font-bold mb-2">Professional Skills</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Communication, project management, and career development</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">2 days</span>
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 rounded-full text-xs font-semibold">Essential</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-12">
                        <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow-lg transition-colors">
                            View All Roadmaps →
                        </a>
                    </div>
                </div>
            </section>

            {{-- Pricing Section --}}
            {{-- <section class="py-20 bg-white dark:bg-gray-900">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4">Simple, Transparent Pricing</h2>
                        <p class="text-xl text-gray-600 dark:text-gray-300">Start free, upgrade when you're ready</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                        <!-- Free Plan -->
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-8 shadow-lg">
                            <h3 class="text-2xl font-bold mb-4">Free Start</h3>
                            <div class="mb-6">
                                <span class="text-4xl font-bold">0 EGP</span>
                            </div>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>First roadmap free</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Access to resources</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Progress tracking</span>
                                </li>
                            </ul>
                            <a href="{{ route('register') }}" class="block text-center px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold transition-colors">
                                Get Started
                            </a>
                        </div>

                        <!-- Monthly Plan -->
                        <div class="bg-blue-600 rounded-xl p-8 shadow-lg text-white transform scale-105">
                            <div class="text-center mb-2">
                                <span class="px-3 py-1 bg-yellow-400 text-yellow-900 rounded-full text-xs font-semibold">POPULAR</span>
                            </div>
                            <h3 class="text-2xl font-bold mb-4">Monthly</h3>
                            <div class="mb-6">
                                <span class="text-4xl font-bold">100 EGP</span>
                                <span class="text-blue-200">/month</span>
                            </div>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start gap-2">
                                    <span>✓</span>
                                    <span>Unlimited roadmaps</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span>✓</span>
                                    <span>Weekly live sessions</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span>✓</span>
                                    <span>Code review</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span>✓</span>
                                    <span>Job board access</span>
                                </li>
                            </ul>
                            <a href="{{ route('register') }}" class="block text-center px-6 py-3 bg-white text-blue-600 hover:bg-blue-50 rounded-lg font-semibold transition-colors">
                                Start Learning
                            </a>
                        </div>

                        <!-- Yearly Plan -->
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-8 shadow-lg">
                            <div class="text-center mb-2">
                                <span class="px-3 py-1 bg-green-400 text-green-900 rounded-full text-xs font-semibold">SAVE 17%</span>
                            </div>
                            <h3 class="text-2xl font-bold mb-4">Yearly</h3>
                            <div class="mb-6">
                                <span class="text-4xl font-bold">1000 EGP</span>
                                <span class="text-gray-500 dark:text-gray-400">/year</span>
                            </div>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Everything in Monthly</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Priority support</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>Exclusive content</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span>2 months free</span>
                                </li>
                            </ul>
                            <a href="{{ route('register') }}" class="block text-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                                Save Now
                            </a>
                        </div>
                    </div>
                </div>
            </section> --}}

            <!-- CTA Section -->
            <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
                <div class="container mx-auto px-6 text-center text-white">
                    <h2 class="text-4xl font-bold mb-6">Ready to Start Your Journey?</h2>
                    <p class="text-xl mb-8 text-blue-100">Join thousands of students learning to code the right way</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-blue-600 hover:bg-blue-50 rounded-lg font-semibold shadow-lg transition-colors">
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}" class="inline-block px-8 py-4 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-semibold shadow-lg transition-colors">
                            Sign In
                        </a>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="py-12 bg-gray-900 text-gray-400">
                <div class="container mx-auto px-6">
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-2 mb-4">
                            <span class="text-3xl">🗺️</span>
                            <span class="text-2xl font-bold text-white">Roadmap Camp</span>
                        </div>
                        <p class="mb-4">Your structured path to programming mastery</p>
                        <p class="text-sm">© 2026 Roadmap Camp. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
