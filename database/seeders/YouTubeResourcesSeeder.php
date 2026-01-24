<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use Illuminate\Database\Seeder;

class YouTubeResourcesSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $this->command->info('Starting YouTube Resources Seeder with SPECIFIC VIDEOS...');

        // Get all roadmaps
        $roadmaps = [
            'Programming Basics' => $this->getProgrammingBasicsResources(),
            'Object-Oriented Programming' => $this->getOOPResources(),
            'Web Development Foundations' => $this->getWebFoundationsResources(),
            'Frontend Fundamentals' => $this->getFrontendResources(),
            'Frontend Framework - React' => $this->getReactResources(),
            'Backend Development - Laravel' => $this->getLaravelResources(),
            'Full Stack Integration' => $this->getFullStackResources(),
            'Advanced Topics & Best Practices' => $this->getAdvancedResources(),
            'Senior Level Skills' => $this->getSeniorResources(),
            'Debugging & Code Quality' => $this->getDebuggingResources(),
            'Software Development Essentials' => $this->getSoftwareDevResources(),
        ];

        foreach ($roadmaps as $roadmapTitle => $topicResources) {
            $roadmap = Roadmap::where('title', $roadmapTitle)->first();

            if (!$roadmap) {
                $this->command->warn("Roadmap not found: {$roadmapTitle}");
                continue;
            }

            $this->command->info("Processing roadmap: {$roadmapTitle}");

            foreach ($topicResources as $topicKeywords => $resources) {
                $this->addResourcesToTasks($roadmap, $topicKeywords, $resources);
            }
        }

        $this->command->info('YouTube Resources Seeder completed!');
    }

    /**
     * Add resources to tasks matching topic keywords
     */
    private function addResourcesToTasks(Roadmap $roadmap, string $topicKeywords, array $resources): void
    {
        $keywords = array_map('trim', explode(',', $topicKeywords));

        $tasks = Task::where('roadmap_id', $roadmap->id)
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('title', 'LIKE', "%{$keyword}%")
                          ->orWhere('description', 'LIKE', "%{$keyword}%")
                          ->orWhere('category', 'LIKE', "%{$keyword}%");
                }
            })
            ->get();

        foreach ($tasks as $task) {
            $existingResources = $task->resources ?? [];

            // Merge new resources with existing ones (avoid duplicates)
            $existingUrls = array_column($existingResources, 'url');

            foreach ($resources as $resource) {
                if (!in_array($resource['url'], $existingUrls)) {
                    $existingResources[] = $resource;
                }
            }

            $task->resources = $existingResources;
            $task->save();

            $this->command->info("  - Added " . count($resources) . " resources to: {$task->title}");
        }
    }

    /**
     * ============================================================
     * PHASE 1: PROGRAMMING BASICS & FOUNDATIONS
     * ============================================================
     */

    /**
     * Programming Basics Resources - UPDATED WITH SPECIFIC VIDEOS
     */
    private function getProgrammingBasicsResources(): array
    {
        return [
            'Programming, Fundamentals, Basics, Introduction, Computer Science' => [
                // English - Introduction to Programming
                ['url' => 'https://www.youtube.com/watch?v=zOjov-2OZ0E', 'title' => 'Programming for Beginners - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=KJgsSFOSQv0', 'title' => 'Programming vs Coding - CS Dojo', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=YQryHo0A0Fo', 'title' => 'How to Start Coding - Traversy Media', 'language' => 'en', 'type' => 'video'],

                // Arabic - مقدمة في البرمجة
                ['url' => 'https://www.youtube.com/watch?v=mvZHDpCHphk', 'title' => 'مقدمة في البرمجة - Programming Advices', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=GfQWq9_FnKk', 'title' => 'أساسيات البرمجة للمبتدئين', 'language' => 'ar', 'type' => 'video'],
            ],

            'Variables, Data Types, const, let, var, String, Number' => [
                // English - Variables & Data Types
                ['url' => 'https://www.youtube.com/watch?v=9WIJQDvt4Us', 'title' => 'JavaScript Variables in 12 Minutes - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=edlFjlzxkSI', 'title' => 'var vs let vs const in JavaScript - Programming with Mosh', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=Jvp8hdMF5ZU', 'title' => 'JavaScript Data Types - freeCodeCamp', 'language' => 'en', 'type' => 'video'],

                // Arabic - المتغيرات وأنواع البيانات
                ['url' => 'https://www.youtube.com/watch?v=Z7-Phgp6EoA', 'title' => 'JavaScript Variables | المتغيرات - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=3_GmxWc4G64', 'title' => 'أنواع البيانات في JavaScript', 'language' => 'ar', 'type' => 'video'],
            ],

            'Operators, Arithmetic, Comparison, Logical, Assignment' => [
                // English - Operators
                ['url' => 'https://www.youtube.com/watch?v=FZzyij43A54', 'title' => 'JavaScript Operators - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=OTCuYzAD5x4', 'title' => 'Logical Operators in JavaScript - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],

                // Arabic - العمليات الحسابية والمنطقية
                ['url' => 'https://www.youtube.com/watch?v=TuQf97MR-hE', 'title' => 'JavaScript Operators | العمليات - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=kBeCyiEj2i8', 'title' => 'العمليات المنطقية في JavaScript', 'language' => 'ar', 'type' => 'video'],
            ],

            'Conditionals, if, else, switch, Conditions' => [
                // English - Conditionals
                ['url' => 'https://www.youtube.com/watch?v=IsG4Xd6LlsM', 'title' => 'If Else Statements in JavaScript - Bro Code', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=JloLGV9DmtQ', 'title' => 'Switch Statements - Programming with Mosh', 'language' => 'en', 'type' => 'video'],

                // Arabic - الجمل الشرطية
                ['url' => 'https://www.youtube.com/watch?v=2Qb7v7Xe0ic', 'title' => 'JavaScript If Else | الجمل الشرطية - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=K5PXC5gYa6A', 'title' => 'Switch Case في JavaScript', 'language' => 'ar', 'type' => 'video'],
            ],

            'Loops, for, while, do-while, Iteration' => [
                // English - Loops
                ['url' => 'https://www.youtube.com/watch?v=s9wW2PpJsmQ', 'title' => 'JavaScript Loops Made Simple - Bro Code', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=Kn06785pkJg', 'title' => 'For Loops vs While Loops - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],

                // Arabic - الحلقات التكرارية
                ['url' => 'https://www.youtube.com/watch?v=_CzX1fT6oe0', 'title' => 'JavaScript Loops | الحلقات - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=GvdCdS7u7xc', 'title' => 'For و While في JavaScript', 'language' => 'ar', 'type' => 'video'],
            ],

            'Functions, Parameters, Arguments, Return' => [
                // English - Functions
                ['url' => 'https://www.youtube.com/watch?v=N8ap4k_1QEQ', 'title' => 'JavaScript Functions in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=FOD408a0EzU', 'title' => 'Functions in JavaScript - Programming with Mosh', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=gigtS_5KOqo', 'title' => 'Arrow Functions vs Regular Functions', 'language' => 'en', 'type' => 'video'],

                // Arabic - الدوال
                ['url' => 'https://www.youtube.com/watch?v=gQqvvihdQUA', 'title' => 'JavaScript Functions | الدوال - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=3PrJ9dj5WQo', 'title' => 'الدوال في JavaScript', 'language' => 'ar', 'type' => 'video'],
            ],

            'Arrays, Lists, Collections, Index' => [
                // English - Arrays
                ['url' => 'https://www.youtube.com/watch?v=oigfaZ5ApsM', 'title' => 'JavaScript Arrays Crash Course - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=R8rmfD9Y5-c', 'title' => 'JavaScript Array Methods - Programming with Mosh', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=7W4pQQ20nJg', 'title' => '10 JavaScript Array Methods - Florin Pop', 'language' => 'en', 'type' => 'video'],

                // Arabic - المصفوفات
                ['url' => 'https://www.youtube.com/watch?v=2l_iP94K_zQ', 'title' => 'JavaScript Arrays | المصفوفات - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=FN1xL9Q-SzU', 'title' => 'شرح المصفوفات في JavaScript', 'language' => 'ar', 'type' => 'video'],
            ],

            'Objects, Properties, Methods, JSON' => [
                // English - Objects
                ['url' => 'https://www.youtube.com/watch?v=PFmuCDHHpwk', 'title' => 'JavaScript Objects in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=-e5h4IGKZRY', 'title' => 'JavaScript Objects Explained - Programming with Mosh', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=napDjGFjHR0', 'title' => 'Object Methods in JavaScript - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],

                // Arabic - الكائنات
                ['url' => 'https://www.youtube.com/watch?v=X0ipw1k7ygU', 'title' => 'JavaScript Objects | الكائنات - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=M4lLViHyRVQ', 'title' => 'الكائنات في JavaScript', 'language' => 'ar', 'type' => 'video'],
            ],
        ];
    }

    /**
     * Object-Oriented Programming Resources - UPDATED WITH SPECIFIC VIDEOS
     */
    private function getOOPResources(): array
    {
        return [
            'Object-Oriented, OOP, Class, Object, Inheritance, Polymorphism' => [
                // English - OOP Concepts
                ['url' => 'https://www.youtube.com/watch?v=pTB0EiLXUC8', 'title' => 'Object Oriented Programming in 7 Minutes - Programming with Mosh', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=m_MQYyJpIjg', 'title' => 'OOP in JavaScript - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=PFmuCDHHpwk', 'title' => 'JavaScript Classes in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],

                // Arabic - البرمجة الكائنية
                ['url' => 'https://www.youtube.com/watch?v=mvZHDpCHphk', 'title' => 'Object Oriented Programming | البرمجة الكائنية', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=MqImTyW6jt8', 'title' => 'OOP في JavaScript', 'language' => 'ar', 'type' => 'video'],
            ],

            'Class, Constructor, this, Instance' => [
                // English - Classes
                ['url' => 'https://www.youtube.com/watch?v=2ZphE5HcQPQ', 'title' => 'JavaScript Classes Tutorial - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=5AWRivBk0Gw', 'title' => 'JavaScript Constructors - Programming with Mosh', 'language' => 'en', 'type' => 'video'],

                // Arabic - الفئات والبناء
                ['url' => 'https://www.youtube.com/watch?v=eFXhfhJGEYo', 'title' => 'JavaScript Classes | الفئات - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=YH99-qkhJVw', 'title' => 'Constructor في JavaScript', 'language' => 'ar', 'type' => 'video'],
            ],

            'Encapsulation, Private, Public, Protected' => [
                // English - Encapsulation
                ['url' => 'https://www.youtube.com/watch?v=rHiSsgFRgEY', 'title' => 'Encapsulation in JavaScript - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=ALdsIWYJKmg', 'title' => 'Private Fields in JavaScript Classes', 'language' => 'en', 'type' => 'video'],

                // Arabic - التغليف
                ['url' => 'https://www.youtube.com/watch?v=7YMaHw7rJYQ', 'title' => 'Encapsulation | التغليف في البرمجة', 'language' => 'ar', 'type' => 'video'],
            ],

            'Inheritance, extends, super, Parent, Child' => [
                // English - Inheritance
                ['url' => 'https://www.youtube.com/watch?v=MfxBfRD0FVU', 'title' => 'JavaScript Inheritance - Programming with Mosh', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=jnME98ckDbQ', 'title' => 'Class Inheritance in JavaScript - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],

                // Arabic - الوراثة
                ['url' => 'https://www.youtube.com/watch?v=uVB-ygKgqmU', 'title' => 'JavaScript Inheritance | الوراثة - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=_MqIxdQq1Kg', 'title' => 'الوراثة في البرمجة الكائنية', 'language' => 'ar', 'type' => 'video'],
            ],

            'Polymorphism, Method Overriding, Abstract' => [
                // English - Polymorphism
                ['url' => 'https://www.youtube.com/watch?v=YkhLw5tYR6c', 'title' => 'Polymorphism in JavaScript - Programming with Mosh', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=zS0HyfN7Pm4', 'title' => 'Method Overriding in JavaScript', 'language' => 'en', 'type' => 'video'],

                // Arabic - تعدد الأشكال
                ['url' => 'https://www.youtube.com/watch?v=mDiIKKvvv7o', 'title' => 'Polymorphism | تعدد الأشكال', 'language' => 'ar', 'type' => 'video'],
            ],
        ];
    }

    /**
     * Web Development Foundations Resources - UPDATED WITH SPECIFIC VIDEOS
     */
    private function getWebFoundationsResources(): array
    {
        return [
            'HTML, Markup, Structure, Elements, Tags, Semantic' => [
                // English - HTML Fundamentals
                ['url' => 'https://www.youtube.com/watch?v=pQN-pnXPaVg', 'title' => 'HTML Full Course - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=UB1O30fR-EE', 'title' => 'HTML Crash Course 2024 - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=qz0aGYrrlhU', 'title' => 'HTML Tutorial for Beginners - Programming with Mosh', 'language' => 'en', 'type' => 'video'],

                // Arabic - أساسيات HTML
                ['url' => 'https://www.youtube.com/watch?v=q3yFo-t1ykw', 'title' => 'HTML Tutorial | تعلم HTML - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAw_t_XWUFbBX-c9MafPk9ji', 'title' => 'دورة HTML كاملة - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
            ],

            'Forms, Input, Button, Validation' => [
                // English - HTML Forms
                ['url' => 'https://www.youtube.com/watch?v=fNcJuPIZ2WE', 'title' => 'HTML Forms Tutorial - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=2O8pkybH6po', 'title' => 'HTML Form Validation - Traversy Media', 'language' => 'en', 'type' => 'video'],

                // Arabic - النماذج
                ['url' => 'https://www.youtube.com/watch?v=HiHHvTcHiEk', 'title' => 'HTML Forms | النماذج - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
            ],

            'CSS, Styling, Design, Layout, Selectors, Box Model' => [
                // English - CSS Fundamentals
                ['url' => 'https://www.youtube.com/watch?v=OXGznpKZ_sA', 'title' => 'CSS Full Course - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=1Rs2ND1ryYc', 'title' => 'CSS Crash Course 2024 - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=yfoY53QXEnI', 'title' => 'CSS Tutorial for Beginners - Programming with Mosh', 'language' => 'en', 'type' => 'video'],

                // Arabic - أساسيات CSS
                ['url' => 'https://www.youtube.com/watch?v=Z-5QVutAEW4', 'title' => 'CSS Tutorial | تعلم CSS - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAzjsz06gkzlSrlev53MGIKe', 'title' => 'دورة CSS كاملة - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
            ],

            'Flexbox, Grid, Layout, Responsive' => [
                // English - CSS Flexbox & Grid
                ['url' => 'https://www.youtube.com/watch?v=K74l26pE4YA', 'title' => 'Flexbox in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=3YW65K6LcIA', 'title' => 'Flexbox Tutorial - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=rg7Fvvl3taU', 'title' => 'CSS Grid in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=9zBsdzdE4sM', 'title' => 'CSS Grid Tutorial - Traversy Media', 'language' => 'en', 'type' => 'video'],

                // Arabic - Flexbox و Grid
                ['url' => 'https://www.youtube.com/watch?v=G7EIAgfkhmg', 'title' => 'CSS Flexbox | فليكس بوكس - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=X1u-jjhu-4E', 'title' => 'CSS Grid | جريد - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
            ],

            'JavaScript, JS, Programming, Interactive, DOM' => [
                // English - JavaScript Fundamentals
                ['url' => 'https://www.youtube.com/watch?v=jS4aFq5-91M', 'title' => 'JavaScript Full Course - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=hdI2bqOjy3c', 'title' => 'JavaScript Crash Course 2024 - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=W6NZfCO5SIk', 'title' => 'JavaScript Tutorial for Beginners - Programming with Mosh', 'language' => 'en', 'type' => 'video'],

                // Arabic - جافاسكريبت
                ['url' => 'https://www.youtube.com/watch?v=GM6dQBmc-Xg', 'title' => 'JavaScript Tutorial | تعلم جافاسكريبت - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAx3kiplQR_oeDqLDBUDYwVv', 'title' => 'دورة JavaScript كاملة - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
            ],

            'ES6, Modern JavaScript, Arrow Functions, Destructuring, Spread' => [
                // English - Modern JavaScript
                ['url' => 'https://www.youtube.com/watch?v=NCwa_xi0Uuc', 'title' => 'Modern JavaScript ES6+ - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=nZ1DMMsyVyI', 'title' => 'ES6 Arrow Functions - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=NIq3qLaHCIs', 'title' => 'JavaScript Destructuring - Fireship', 'language' => 'en', 'type' => 'video'],

                // Arabic - جافاسكريبت الحديثة
                ['url' => 'https://www.youtube.com/watch?v=rRryGSJeyME', 'title' => 'ES6 Features | ميزات ES6 - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
            ],

            'Async, Promises, async/await, Fetch, API' => [
                // English - Async JavaScript
                ['url' => 'https://www.youtube.com/watch?v=_8gHHBlbziw', 'title' => 'Async JavaScript in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=PoRJizFvM7s', 'title' => 'JavaScript Promises - Programming with Mosh', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=V_Kr9OSfDeU', 'title' => 'Async Await Tutorial - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=cuEtnrL9-H0', 'title' => 'JavaScript Fetch API - Traversy Media', 'language' => 'en', 'type' => 'video'],

                // Arabic - البرمجة غير المتزامنة
                ['url' => 'https://www.youtube.com/watch?v=6WB16wZS61c', 'title' => 'JavaScript Promises | الوعود - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=ZaI-KWSjn0g', 'title' => 'Async Await في JavaScript', 'language' => 'ar', 'type' => 'video'],
            ],
        ];
    }

    /**
     * ============================================================
     * PHASE 2: FRAMEWORKS & TOOLS
     * ============================================================
     */

    /**
     * Frontend Fundamentals Resources - UPDATED WITH SPECIFIC VIDEOS
     */
    private function getFrontendResources(): array
    {
        return [
            'Responsive, Mobile, Design, Media Queries, Viewport' => [
                // English - Responsive Design
                ['url' => 'https://www.youtube.com/watch?v=srvUrASNj0s', 'title' => 'Responsive Web Design in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=ZYV6dYtz4HA', 'title' => 'Responsive Design Tutorial - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=bn-DQCifeQQ', 'title' => 'Build a Responsive Website - freeCodeCamp', 'language' => 'en', 'type' => 'video'],

                // Arabic - التصميم المتجاوب
                ['url' => 'https://www.youtube.com/watch?v=FazgJVnrVuI', 'title' => 'Responsive Design | التصميم المتجاوب - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=qWRl2ay7jAM', 'title' => 'Media Queries شرح', 'language' => 'ar', 'type' => 'video'],
            ],

            'Tailwind, CSS Framework, Utility Classes' => [
                // English - Tailwind CSS
                ['url' => 'https://www.youtube.com/watch?v=mr15Xzb1Ook', 'title' => 'Tailwind CSS Crash Course - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=pfaSUYaSgRo', 'title' => 'Tailwind CSS Full Course - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=UBOj6rqRUME', 'title' => 'Tailwind in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],

                // Arabic - Tailwind CSS
                ['url' => 'https://www.youtube.com/watch?v=_9mTJ84uL1Q', 'title' => 'Tailwind CSS Tutorial | تعلم Tailwind - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAzxkL3A6ryPhzWk8f7RvLKG', 'title' => 'دورة Tailwind CSS كاملة', 'language' => 'ar', 'type' => 'video'],
            ],

            'DOM, Manipulation, Events, querySelector, addEventListener' => [
                // English - DOM Manipulation
                ['url' => 'https://www.youtube.com/watch?v=y17RuWkWdn8', 'title' => 'JavaScript DOM Tutorial - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=0ik6X4DJKCc', 'title' => 'JavaScript DOM Crash Course - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=5fb2aPlgoys', 'title' => 'DOM Manipulation - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],

                // Arabic - التعامل مع DOM
                ['url' => 'https://www.youtube.com/watch?v=qpNj-UhNHu4', 'title' => 'JavaScript DOM | التعامل مع DOM - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAxx97QDMOCpzxbu1ZHJ4i7i', 'title' => 'سلسلة DOM في JavaScript', 'language' => 'ar', 'type' => 'video'],
            ],

            'Event Handling, Click, Submit, Keyboard, Mouse' => [
                // English - Events
                ['url' => 'https://www.youtube.com/watch?v=XF1_MlZ5l6M', 'title' => 'JavaScript Event Listeners - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=F1anRyL37lE', 'title' => 'Event Bubbling and Delegation - Traversy Media', 'language' => 'en', 'type' => 'video'],

                // Arabic - معالجة الأحداث
                ['url' => 'https://www.youtube.com/watch?v=ty99Qq4fCy0', 'title' => 'JavaScript Events | الأحداث - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
            ],

            'Local Storage, Session Storage, Cookies, Storage API' => [
                // English - Web Storage
                ['url' => 'https://www.youtube.com/watch?v=GihQAC1I39Q', 'title' => 'LocalStorage Crash Course - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=k8yJCeuP6I8', 'title' => 'JavaScript Cookies vs LocalStorage - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],

                // Arabic - التخزين المحلي
                ['url' => 'https://www.youtube.com/watch?v=AUOzvFzdIk4', 'title' => 'LocalStorage & SessionStorage - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
            ],
        ];
    }

    /**
     * React Framework Resources - UPDATED WITH SPECIFIC VIDEOS
     */
    private function getReactResources(): array
    {
        return [
            'React, Component, JSX, Frontend Framework, Virtual DOM' => [
                // English - React Fundamentals
                ['url' => 'https://www.youtube.com/watch?v=Tn6-PIqc4UM', 'title' => 'React in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=w7ejDZ8SWv8', 'title' => 'React JS Crash Course 2024 - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=bMknfKXIFA8', 'title' => 'React Course - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=SqcY0GlETPk', 'title' => 'React Tutorial for Beginners - Programming with Mosh', 'language' => 'en', 'type' => 'video'],

                // Arabic - أساسيات React
                ['url' => 'https://www.youtube.com/watch?v=EkxOCxZYGMA', 'title' => 'React Tutorial | تعلم React - Unique Code Academy', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/playlist?list=PLtFbQRDJ11kEjXWZmwkOV-vfXmrEEsuEW', 'title' => 'دورة React JS كاملة', 'language' => 'ar', 'type' => 'video'],
            ],

            'Hooks, useState, useEffect, useContext, Custom Hooks' => [
                // English - React Hooks
                ['url' => 'https://www.youtube.com/watch?v=TNhaISOUy6Q', 'title' => 'React Hooks Explained - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=O6P86uwfdR0', 'title' => 'useState Hook Tutorial - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=0ZJgIjIuY7U', 'title' => 'useEffect Hook Explained - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=5LrDIWkK_Bc', 'title' => 'useContext Hook - Programming with Mosh', 'language' => 'en', 'type' => 'video'],

                // Arabic - React Hooks
                ['url' => 'https://www.youtube.com/watch?v=cjIz7wIv9Xs', 'title' => 'React Hooks شرح - Unique Code Academy', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=dpw9EHDh2bM', 'title' => 'useState و useEffect في React', 'language' => 'ar', 'type' => 'video'],
            ],

            'Router, React Router, Navigation, Routes' => [
                // English - React Router
                ['url' => 'https://www.youtube.com/watch?v=Ul3y1LXxzdU', 'title' => 'React Router Tutorial - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=Law7wfdg_ls', 'title' => 'React Router v6 Tutorial - freeCodeCamp', 'language' => 'en', 'type' => 'video'],

                // Arabic - React Router
                ['url' => 'https://www.youtube.com/watch?v=0cSVuySEB0A', 'title' => 'React Router شرح', 'language' => 'ar', 'type' => 'video'],
            ],

            'State Management, Redux, Context API, Zustand' => [
                // English - State Management
                ['url' => 'https://www.youtube.com/watch?v=CVpUuw9XSjY', 'title' => 'Redux in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=poQXNp9ItL4', 'title' => 'Redux Toolkit Tutorial - Programming with Mosh', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=_ngCLZ5Iz-0', 'title' => 'Zustand Tutorial - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],

                // Arabic - إدارة الحالة
                ['url' => 'https://www.youtube.com/watch?v=kVOmc7NK1M0', 'title' => 'Redux شرح', 'language' => 'ar', 'type' => 'video'],
            ],
        ];
    }

    /**
     * Laravel Backend Development Resources - UPDATED WITH SPECIFIC VIDEOS
     */
    private function getLaravelResources(): array
    {
        return [
            'Laravel, PHP, Framework, Backend, MVC' => [
                // English - Laravel Fundamentals
                ['url' => 'https://www.youtube.com/watch?v=MYyJ4PuL4pY', 'title' => 'Laravel PHP Framework Tutorial - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=MFh0Fd7BsjE', 'title' => 'Laravel Crash Course 2024 - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=376vZ1wNYPA', 'title' => 'Laravel for Beginners - Program with Gio', 'language' => 'en', 'type' => 'video'],

                // Arabic - أساسيات Laravel
                ['url' => 'https://www.youtube.com/watch?v=zckH4xalOns', 'title' => 'Laravel Tutorial | تعلم Laravel', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/playlist?list=PLCm7ZeRfGSP6ViEP7_H_MHVy6DBpBNxZA', 'title' => 'دورة Laravel كاملة بالعربي', 'language' => 'ar', 'type' => 'video'],
            ],

            'Routing, Controllers, Middleware, Views' => [
                // English - Laravel Routing
                ['url' => 'https://www.youtube.com/watch?v=GcfwzFhBZrA', 'title' => 'Laravel Routing Tutorial - Laravel Daily', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=lJhF8a97xL0', 'title' => 'Laravel Controllers & Middleware', 'language' => 'en', 'type' => 'video'],

                // Arabic - التوجيه والمتحكمات
                ['url' => 'https://www.youtube.com/watch?v=WJKdZWK8xYs', 'title' => 'Laravel Routing شرح', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=RZQGVbhjGu4', 'title' => 'Controllers في Laravel', 'language' => 'ar', 'type' => 'video'],
            ],

            'Eloquent, ORM, Database, Model, Relationships' => [
                // English - Eloquent ORM
                ['url' => 'https://www.youtube.com/watch?v=tEPr8WNUVXs', 'title' => 'Laravel Eloquent Tutorial - Laravel Daily', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=S8ie0KLu99w', 'title' => 'Eloquent Relationships Explained - Program with Gio', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=WXsD0ZgxjRw', 'title' => 'Eloquent ORM Crash Course', 'language' => 'en', 'type' => 'video'],

                // Arabic - Eloquent ORM
                ['url' => 'https://www.youtube.com/watch?v=I7pPxH5KUF4', 'title' => 'Eloquent ORM شرح', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=gXTwHPtJSiQ', 'title' => 'العلاقات في Eloquent', 'language' => 'ar', 'type' => 'video'],
            ],

            'Migrations, Schema, Database, SQL' => [
                // English - Laravel Migrations
                ['url' => 'https://www.youtube.com/watch?v=EcVYfKRUz8o', 'title' => 'Laravel Migrations Tutorial - Laravel Daily', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=r-tnzkLgWjs', 'title' => 'Database Migrations Explained', 'language' => 'en', 'type' => 'video'],

                // Arabic - الترحيلات
                ['url' => 'https://www.youtube.com/watch?v=Jz8QYTF9HM4', 'title' => 'Laravel Migrations شرح', 'language' => 'ar', 'type' => 'video'],
            ],

            'Authentication, Authorization, Gates, Policies' => [
                // English - Laravel Auth
                ['url' => 'https://www.youtube.com/watch?v=gTZP-EFXg0k', 'title' => 'Laravel Authentication Tutorial - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=AGE_wRtJdO4', 'title' => 'Laravel Breeze Authentication', 'language' => 'en', 'type' => 'video'],

                // Arabic - المصادقة والتفويض
                ['url' => 'https://www.youtube.com/watch?v=d8YgQKqJN2k', 'title' => 'Laravel Authentication شرح', 'language' => 'ar', 'type' => 'video'],
            ],

            'API, RESTful, JSON, Resource, Sanctum' => [
                // English - Laravel API
                ['url' => 'https://www.youtube.com/watch?v=xvqPEEpRBJ4', 'title' => 'Laravel API Development - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=MT-GJQIY3EU', 'title' => 'Laravel Sanctum API Authentication', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=TzAJfjCn7Ks', 'title' => 'RESTful API with Laravel - freeCodeCamp', 'language' => 'en', 'type' => 'video'],

                // Arabic - واجهات API
                ['url' => 'https://www.youtube.com/watch?v=YGqCZjdgJJg', 'title' => 'Laravel API شرح', 'language' => 'ar', 'type' => 'video'],
            ],
        ];
    }

    /**
     * ============================================================
     * PHASE 3: ADVANCED TOPICS
     * ============================================================
     */

    /**
     * Full Stack Integration Resources - UPDATED WITH SPECIFIC VIDEOS
     */
    private function getFullStackResources(): array
    {
        return [
            'Full Stack, Integration, MERN, LAMP, REST API' => [
                // English - Full Stack Development
                ['url' => 'https://www.youtube.com/watch?v=98BzS5Oz5E4', 'title' => 'MERN Stack Tutorial - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=7CqJlxBYj-M', 'title' => 'Full Stack App Tutorial - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=Oe421EPjeBE', 'title' => 'Full Stack JavaScript Project - Fireship', 'language' => 'en', 'type' => 'video'],

                // Arabic - التطوير الشامل
                ['url' => 'https://www.youtube.com/watch?v=UwBqL2Z5S6c', 'title' => 'Full Stack Development شرح', 'language' => 'ar', 'type' => 'video'],
            ],

            'Deployment, Hosting, Production, Server' => [
                // English - Deployment
                ['url' => 'https://www.youtube.com/watch?v=_EN7zcCMNhk', 'title' => 'Deploy Full Stack App - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=oykl1Ih9pMg', 'title' => 'Production Deployment Guide - freeCodeCamp', 'language' => 'en', 'type' => 'video'],

                // Arabic - النشر والاستضافة
                ['url' => 'https://www.youtube.com/watch?v=KFttV2cjQdI', 'title' => 'Deployment شرح', 'language' => 'ar', 'type' => 'video'],
            ],
        ];
    }

    /**
     * Advanced Topics & Best Practices Resources - UPDATED WITH SPECIFIC VIDEOS
     */
    private function getAdvancedResources(): array
    {
        return [
            'Testing, TDD, PHPUnit, Unit Test, Integration Test' => [
                // English - Testing
                ['url' => 'https://www.youtube.com/watch?v=ajiAl5UNzaU', 'title' => 'Laravel Testing Tutorial - Laravel Daily', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=I84hpL0oEJk', 'title' => 'PHPUnit Testing Tutorial - Program with Gio', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=r-lC7aQEX-g', 'title' => 'Test Driven Development - freeCodeCamp', 'language' => 'en', 'type' => 'video'],

                // Arabic - الاختبارات
                ['url' => 'https://www.youtube.com/watch?v=zVfJUqP4vEg', 'title' => 'Laravel Testing شرح', 'language' => 'ar', 'type' => 'video'],
            ],

            'Docker, Container, Deployment, DevOps' => [
                // English - Docker
                ['url' => 'https://www.youtube.com/watch?v=fqMOX6JJhGo', 'title' => 'Docker Tutorial for Beginners - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=3c-iBn73dDE', 'title' => 'Docker Crash Course - TechWorld with Nana', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=gAkwW2tuIqE', 'title' => 'Docker in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],

                // Arabic - Docker
                ['url' => 'https://www.youtube.com/watch?v=PrusdhS2lmo', 'title' => 'Docker Tutorial | تعلم Docker', 'language' => 'ar', 'type' => 'video'],
            ],

            'CI/CD, DevOps, Automation, GitHub Actions, Jenkins' => [
                // English - CI/CD
                ['url' => 'https://www.youtube.com/watch?v=scEDHsr3APg', 'title' => 'CI/CD Explained - TechWorld with Nana', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=R8_veQiYBjI', 'title' => 'GitHub Actions Tutorial - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=mBU3AJ3j1rg', 'title' => 'DevOps CI/CD Pipeline - TechWorld with Nana', 'language' => 'en', 'type' => 'video'],

                // Arabic - CI/CD
                ['url' => 'https://www.youtube.com/watch?v=Lb4vGRYQaYM', 'title' => 'CI/CD شرح', 'language' => 'ar', 'type' => 'video'],
            ],

            'Security, Cybersecurity, Penetration, OWASP' => [
                // English - Web Security
                ['url' => 'https://www.youtube.com/watch?v=WlmKwIe9z1Q', 'title' => 'Web Security Explained - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=4Jlf1SqNaRk', 'title' => 'OWASP Top 10 Explained - freeCodeCamp', 'language' => 'en', 'type' => 'video'],

                // Arabic - أمن المعلومات
                ['url' => 'https://www.youtube.com/watch?v=CivEAs1zRUU', 'title' => 'Web Security | أمن تطبيقات الويب - Metwally Labs', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=MvZfsbz0uc8', 'title' => 'OWASP Top 10 بالعربي', 'language' => 'ar', 'type' => 'video'],
            ],

            'Performance, Optimization, Caching, CDN' => [
                // English - Performance
                ['url' => 'https://www.youtube.com/watch?v=0fONene3OIA', 'title' => 'Web Performance Optimization - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=AQqFZ5t8uNc', 'title' => 'Laravel Performance Tips - Laravel Daily', 'language' => 'en', 'type' => 'video'],

                // Arabic - تحسين الأداء
                ['url' => 'https://www.youtube.com/watch?v=eJJEGJKvdqA', 'title' => 'Website Performance شرح', 'language' => 'ar', 'type' => 'video'],
            ],
        ];
    }

    /**
     * Senior Level Skills Resources - UPDATED WITH SPECIFIC VIDEOS
     */
    private function getSeniorResources(): array
    {
        return [
            'System Design, Architecture, Scalability, Microservices' => [
                // English - System Design
                ['url' => 'https://www.youtube.com/watch?v=i53Gi_K3o7I', 'title' => 'System Design Interview - ByteByteGo', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=lX4CrbXMsNQ', 'title' => 'System Design Fundamentals - ByteByteGo', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=UzLMhqg3_Wc', 'title' => 'Scaling Applications - Hussein Nasser', 'language' => 'en', 'type' => 'video'],

                // Arabic - تصميم الأنظمة
                ['url' => 'https://www.youtube.com/watch?v=DSGsa0pu8-k', 'title' => 'System Design بالعربي', 'language' => 'ar', 'type' => 'video'],
            ],

            'Microservices, Distributed Systems, Message Queue' => [
                // English - Microservices
                ['url' => 'https://www.youtube.com/watch?v=CdBtNQZH8a4', 'title' => 'Microservices Explained - TechWorld with Nana', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=rv4LlmLmVWk', 'title' => 'Microservices Architecture - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=5OjqD-ow8GE', 'title' => 'Distributed Systems Explained - Hussein Nasser', 'language' => 'en', 'type' => 'video'],

                // Arabic - البنية الموزعة
                ['url' => 'https://www.youtube.com/watch?v=K0Ta65OqQkY', 'title' => 'Microservices شرح', 'language' => 'ar', 'type' => 'video'],
            ],

            'Database, Performance, Optimization, Indexing, Query' => [
                // English - Database Engineering
                ['url' => 'https://www.youtube.com/watch?v=HubezKbFL7E', 'title' => 'Database Engineering - Hussein Nasser', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=-qNSXK7s7_w', 'title' => 'Database Performance Tips - Hussein Nasser', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=W2Z7fbCLSTw', 'title' => 'SQL Optimization - freeCodeCamp', 'language' => 'en', 'type' => 'video'],

                // Arabic - قواعد البيانات المتقدمة
                ['url' => 'https://www.youtube.com/watch?v=fykdxyBxKxo', 'title' => 'Database Optimization شرح', 'language' => 'ar', 'type' => 'video'],
            ],

            'Algorithms, Data Structures, Interview, LeetCode' => [
                // English - Algorithms
                ['url' => 'https://www.youtube.com/watch?v=8hly31xKli0', 'title' => 'Algorithms Course - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=xbgzl2maQUU', 'title' => 'Data Structures Easy to Advanced - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=tWVWeAqZ0WU', 'title' => 'Dynamic Programming - freeCodeCamp', 'language' => 'en', 'type' => 'video'],

                // Arabic - الخوارزميات
                ['url' => 'https://www.youtube.com/watch?v=kKXJDShO8MY', 'title' => 'Data Structures بالعربي', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/playlist?list=PLwCMLs3sjOY4UQq4vXgGPwGdbqwz-4dGu', 'title' => 'سلسلة الخوارزميات - Arabic Competitive Programming', 'language' => 'ar', 'type' => 'video'],
            ],

            'Design Patterns, SOLID, Clean Architecture' => [
                // English - Design Patterns
                ['url' => 'https://www.youtube.com/watch?v=tv-_1er1mWI', 'title' => 'Design Patterns in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=BWprw8UHIzA', 'title' => 'SOLID Principles - Programming with Mosh', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=8lGpZkjnkt4', 'title' => 'Design Patterns in PHP - Program with Gio', 'language' => 'en', 'type' => 'video'],

                // Arabic - أنماط التصميم
                ['url' => 'https://www.youtube.com/watch?v=P4D6LXrgZh0', 'title' => 'Design Patterns شرح', 'language' => 'ar', 'type' => 'video'],
            ],
        ];
    }

    /**
     * Debugging & Code Quality Resources - UPDATED WITH SPECIFIC VIDEOS
     */
    private function getDebuggingResources(): array
    {
        return [
            'Debugging, Error, Bug, Troubleshoot, Debug Tools' => [
                // English - Debugging Techniques
                ['url' => 'https://www.youtube.com/watch?v=H0XScE08hy8', 'title' => 'Debugging Tips and Tricks - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=P6-tKASvYFk', 'title' => 'How to Debug Code - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=tjWI8DG_6dM', 'title' => 'Chrome DevTools Tutorial - Traversy Media', 'language' => 'en', 'type' => 'video'],

                // Arabic - تصحيح الأخطاء
                ['url' => 'https://www.youtube.com/watch?v=NWfbvSuoQ-Q', 'title' => 'Debugging Techniques شرح', 'language' => 'ar', 'type' => 'video'],
            ],

            'Code Quality, Clean Code, Best Practices, Refactoring' => [
                // English - Clean Code
                ['url' => 'https://www.youtube.com/watch?v=qj5wUmRkKdI', 'title' => 'Clean Code Principles - Programming with Mosh', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=fJbxxQwPPso', 'title' => 'Code Refactoring Tips - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=dc-pSrSoCaM', 'title' => 'Writing Better Code - Web Dev Simplified', 'language' => 'en', 'type' => 'video'],

                // Arabic - جودة الكود
                ['url' => 'https://www.youtube.com/watch?v=2xaIw_sLDMo', 'title' => 'Clean Code بالعربي', 'language' => 'ar', 'type' => 'video'],
            ],

            'Code Review, Pull Request, Collaboration' => [
                // English - Code Review
                ['url' => 'https://www.youtube.com/watch?v=TlB_eWDSMt4', 'title' => 'Code Review Best Practices', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=0yiNNPMwD0g', 'title' => 'Pull Request Tutorial - Traversy Media', 'language' => 'en', 'type' => 'video'],

                // Arabic - مراجعة الكود
                ['url' => 'https://www.youtube.com/watch?v=HW0RPaJqm4g', 'title' => 'Code Review شرح', 'language' => 'ar', 'type' => 'video'],
            ],
        ];
    }

    /**
     * Software Development Essentials Resources - UPDATED WITH SPECIFIC VIDEOS
     */
    private function getSoftwareDevResources(): array
    {
        return [
            'Git, Version Control, GitHub, Branch, Merge, Commit' => [
                // English - Git & GitHub
                ['url' => 'https://www.youtube.com/watch?v=RGOj5yH7evk', 'title' => 'Git and GitHub for Beginners - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=8JJ101D3knE', 'title' => 'Git Tutorial for Beginners - Programming with Mosh', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=apGV9Kg7ics', 'title' => 'Git Explained in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],

                // Arabic - Git و GitHub
                ['url' => 'https://www.youtube.com/watch?v=ACOiGZoqC8w', 'title' => 'Git & GitHub Tutorial | تعلم Git - Elzero Web School', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/playlist?list=PLDoPjvoNmBAw4eOj58MZPakHjaO3frVMF', 'title' => 'دورة Git & GitHub كاملة', 'language' => 'ar', 'type' => 'video'],
            ],

            'Command Line, Terminal, Shell, Bash, CLI' => [
                // English - Command Line
                ['url' => 'https://www.youtube.com/watch?v=Z56Jmr9Z34Q', 'title' => 'Command Line Crash Course - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=oxuRxtrO2Ag', 'title' => 'Bash Scripting Tutorial - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=I4EWvMFj37g', 'title' => 'Terminal Tips and Tricks - Fireship', 'language' => 'en', 'type' => 'video'],

                // Arabic - سطر الأوامر
                ['url' => 'https://www.youtube.com/watch?v=JRzJbJqYxLE', 'title' => 'Command Line Tutorial | سطر الأوامر', 'language' => 'ar', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=BFMyUgF6I8Y', 'title' => 'Bash Scripting بالعربي', 'language' => 'ar', 'type' => 'video'],
            ],

            'Agile, Scrum, Project Management, Sprint, Kanban' => [
                // English - Agile & Scrum
                ['url' => 'https://www.youtube.com/watch?v=502ILHjX9EE', 'title' => 'Agile Explained in 100 Seconds - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=9TycLR0TqFA', 'title' => 'Scrum in 20 Minutes - Simplilearn', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=jOEmZb-77YY', 'title' => 'Agile Project Management - freeCodeCamp', 'language' => 'en', 'type' => 'video'],

                // Arabic - Agile و Scrum
                ['url' => 'https://www.youtube.com/watch?v=Z-1BCblUCH0', 'title' => 'Agile & Scrum شرح بالعربي', 'language' => 'ar', 'type' => 'video'],
            ],

            'Technical Writing, Documentation, README' => [
                // English - Documentation
                ['url' => 'https://www.youtube.com/watch?v=kzRlAKwhc-I', 'title' => 'How to Write Good Documentation - Traversy Media', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=t5xCMfqBg9c', 'title' => 'Writing Great README Files', 'language' => 'en', 'type' => 'video'],

                // Arabic - كتابة التوثيق
                ['url' => 'https://www.youtube.com/watch?v=RZ5vduluea4', 'title' => 'Technical Writing شرح', 'language' => 'ar', 'type' => 'video'],
            ],

            'Career, Interview, Resume, Portfolio, Job Search' => [
                // English - Career Development
                ['url' => 'https://www.youtube.com/watch?v=AAFJXxq_lhI', 'title' => 'Software Engineering Career Advice - Fireship', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=DlaN45dR3WM', 'title' => 'Technical Interview Preparation - freeCodeCamp', 'language' => 'en', 'type' => 'video'],
                ['url' => 'https://www.youtube.com/watch?v=sLBPDSFzQlI', 'title' => 'How to Get a Programming Job - Traversy Media', 'language' => 'en', 'type' => 'video'],

                // Arabic - المسار الوظيفي
                ['url' => 'https://www.youtube.com/watch?v=YGHnD0Lp3yA', 'title' => 'كيف تصبح مبرمج محترف', 'language' => 'ar', 'type' => 'video'],
            ],
        ];
    }
}
