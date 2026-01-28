<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Roadmap;
use Illuminate\Support\Facades\Storage;
use ArPHP\I18N\Arabic;

class GenerateTranslationPDFs extends Command
{
    protected $signature = 'translation:generate-pdfs';
    protected $description = 'Generate PDF files for translation roadmap tasks';

    public function handle()
    {
        $this->info('Generating translation PDF files...');

        // Get translation roadmap
        $roadmap = Roadmap::where('slug', 'technical-terms-translation')->first();

        if (!$roadmap) {
            $this->error('Translation roadmap not found!');
            return 1;
        }

        // Ensure public/pdfs/translations directory exists
        $pdfDir = public_path('pdfs/translations');
        if (!file_exists($pdfDir)) {
            mkdir($pdfDir, 0755, true);
        }

        $translationData = $this->getTranslationData();

        foreach ($translationData as $dayNumber => $data) {
            $this->info("Generating Day {$dayNumber}: {$data['title']}");

            // Reverse Arabic text for proper RTL display in DomPDF
            $titleAr = $this->reverseArabic($data['titleAr']);
            $terms = array_map(function($term) {
                return [
                    'english' => $term['english'],
                    'arabic' => $this->reverseArabic($term['arabic']),
                    'example' => $term['example']
                ];
            }, $data['terms']);

            $html = view('pdfs.translation-template', [
                'day' => $dayNumber,
                'title' => $data['title'],
                'titleAr' => $titleAr,
                'terms' => $terms
            ])->render();

            $pdf = Pdf::loadHTML($html)
                ->setPaper('a4', 'portrait')
                ->setOption('isRemoteEnabled', true)
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isFontSubsettingEnabled', true)
                ->setOption('defaultFont', 'DejaVu Sans');

            $filename = "translation-day-" . str_pad($dayNumber, 2, '0', STR_PAD_LEFT) . "-" . $data['slug'] . ".pdf";
            $pdf->save($pdfDir . '/' . $filename);

            $this->info("✓ Created: {$filename}");
        }

        $this->info("\n✅ All translation PDFs generated successfully!");
        $this->info("Location: public/pdfs/translations/");

        return 0;
    }

    /**
     * Reverse Arabic text for proper RTL display in DomPDF
     */
    protected function reverseArabic($text)
    {
        // Use ArPHP library to properly glyph Arabic text for PDF display
        $arabic = new Arabic();

        // Convert Arabic text to glyph form (properly joins characters)
        $glyphed = $arabic->utf8Glyphs($text);

        // Reverse the text for RTL display in DomPDF
        $parts = preg_split('/(\s+|\/)/u', $glyphed, -1, PREG_SPLIT_DELIM_CAPTURE);

        $reversed = [];
        foreach ($parts as $part) {
            if (preg_match('/[\x{0600}-\x{06FF}]/u', $part)) {
                // Reverse Arabic glyphs
                $chars = mb_str_split($part, 1, 'UTF-8');
                $reversed[] = implode('', array_reverse($chars));
            } else {
                // Keep non-Arabic parts as is
                $reversed[] = $part;
            }
        }

        return implode('', array_reverse($reversed));
    }

    protected function getTranslationData()
    {
        return [
            1 => [
                'title' => 'Programming Basics',
                'titleAr' => 'المفاهيم البرمجية الأساسية',
                'slug' => 'programming-basics',
                'terms' => [
                    ['english' => 'Variable', 'arabic' => 'متغير', 'example' => 'let name = "Ahmed"'],
                    ['english' => 'Function', 'arabic' => 'دالة / وظيفة', 'example' => 'function calculate() {}'],
                    ['english' => 'Loop', 'arabic' => 'حلقة تكرارية', 'example' => 'for (let i = 0; i < 10; i++)'],
                    ['english' => 'Condition', 'arabic' => 'شرط', 'example' => 'if (x > 5) {}'],
                    ['english' => 'Array', 'arabic' => 'مصفوفة', 'example' => 'let numbers = [1, 2, 3]'],
                    ['english' => 'Object', 'arabic' => 'كائن', 'example' => 'let user = {name: "Ali"}'],
                    ['english' => 'String', 'arabic' => 'نص / سلسلة نصية', 'example' => '"Hello World"'],
                    ['english' => 'Number', 'arabic' => 'رقم', 'example' => '42'],
                    ['english' => 'Boolean', 'arabic' => 'منطقي', 'example' => 'true / false'],
                    ['english' => 'Operator', 'arabic' => 'معامل', 'example' => '+, -, *, /'],
                    ['english' => 'Parameter', 'arabic' => 'معامل / وسيط', 'example' => 'function add(a, b)'],
                    ['english' => 'Return', 'arabic' => 'إرجاع', 'example' => 'return result'],
                    ['english' => 'Declare', 'arabic' => 'تصريح', 'example' => 'let x = 10'],
                    ['english' => 'Initialize', 'arabic' => 'تهيئة', 'example' => 'x = 0'],
                    ['english' => 'Constant', 'arabic' => 'ثابت', 'example' => 'const PI = 3.14'],
                ]
            ],
            2 => [
                'title' => 'Data Types & Structures',
                'titleAr' => 'أنواع البيانات والهياكل',
                'slug' => 'data-types',
                'terms' => [
                    ['english' => 'Data Type', 'arabic' => 'نوع البيانات', 'example' => 'string, number, boolean'],
                    ['english' => 'Integer', 'arabic' => 'عدد صحيح', 'example' => '42'],
                    ['english' => 'Float', 'arabic' => 'عدد عشري', 'example' => '3.14'],
                    ['english' => 'Character', 'arabic' => 'حرف', 'example' => '"A"'],
                    ['english' => 'List', 'arabic' => 'قائمة', 'example' => '[1, 2, 3, 4, 5]'],
                    ['english' => 'Dictionary', 'arabic' => 'قاموس', 'example' => '{key: value}'],
                    ['english' => 'Set', 'arabic' => 'مجموعة', 'example' => 'new Set([1, 2, 3])'],
                    ['english' => 'Tuple', 'arabic' => 'صف', 'example' => '(1, "hello", true)'],
                    ['english' => 'Stack', 'arabic' => 'كومة', 'example' => 'Push/Pop operations'],
                    ['english' => 'Queue', 'arabic' => 'طابور', 'example' => 'FIFO - First In First Out'],
                    ['english' => 'Null', 'arabic' => 'قيمة فارغة', 'example' => 'null'],
                    ['english' => 'Undefined', 'arabic' => 'غير معرف', 'example' => 'undefined'],
                    ['english' => 'Type Casting', 'arabic' => 'تحويل النوع', 'example' => 'parseInt("42")'],
                    ['english' => 'Immutable', 'arabic' => 'غير قابل للتغيير', 'example' => 'const values'],
                    ['english' => 'Mutable', 'arabic' => 'قابل للتغيير', 'example' => 'let values'],
                ]
            ],
            3 => [
                'title' => 'Control Flow',
                'titleAr' => 'تحكم في التدفق',
                'slug' => 'control-flow',
                'terms' => [
                    ['english' => 'If Statement', 'arabic' => 'جملة شرطية', 'example' => 'if (condition) {}'],
                    ['english' => 'Else', 'arabic' => 'وإلا', 'example' => 'else {}'],
                    ['english' => 'Else If', 'arabic' => 'أو إذا', 'example' => 'else if (condition) {}'],
                    ['english' => 'Switch', 'arabic' => 'تبديل / اختيار', 'example' => 'switch (value) {}'],
                    ['english' => 'Case', 'arabic' => 'حالة', 'example' => 'case "value":'],
                    ['english' => 'Default', 'arabic' => 'افتراضي', 'example' => 'default:'],
                    ['english' => 'For Loop', 'arabic' => 'حلقة for', 'example' => 'for (i=0; i<10; i++)'],
                    ['english' => 'While Loop', 'arabic' => 'حلقة while', 'example' => 'while (condition) {}'],
                    ['english' => 'Do While', 'arabic' => 'افعل بينما', 'example' => 'do {} while (condition)'],
                    ['english' => 'Break', 'arabic' => 'توقف / اخرج', 'example' => 'break;'],
                    ['english' => 'Continue', 'arabic' => 'تابع / استمر', 'example' => 'continue;'],
                    ['english' => 'Iteration', 'arabic' => 'تكرار', 'example' => 'for...of, forEach'],
                    ['english' => 'Nested Loop', 'arabic' => 'حلقة متداخلة', 'example' => 'for () { for () {} }'],
                    ['english' => 'Ternary Operator', 'arabic' => 'عامل ثلاثي', 'example' => 'condition ? true : false'],
                    ['english' => 'Short Circuit', 'arabic' => 'دائرة قصيرة', 'example' => 'a && b || c'],
                ]
            ],
            4 => [
                'title' => 'Functions & Methods',
                'titleAr' => 'الدوال والأساليب',
                'slug' => 'functions',
                'terms' => [
                    ['english' => 'Function', 'arabic' => 'دالة', 'example' => 'function name() {}'],
                    ['english' => 'Method', 'arabic' => 'أسلوب / طريقة', 'example' => 'object.method()'],
                    ['english' => 'Parameter', 'arabic' => 'معامل', 'example' => 'function add(a, b)'],
                    ['english' => 'Argument', 'arabic' => 'وسيط', 'example' => 'add(5, 3)'],
                    ['english' => 'Return Value', 'arabic' => 'قيمة مرجعة', 'example' => 'return result;'],
                    ['english' => 'Arrow Function', 'arabic' => 'دالة سهمية', 'example' => '(x) => x * 2'],
                    ['english' => 'Callback', 'arabic' => 'دالة رد النداء', 'example' => 'setTimeout(callback, 1000)'],
                    ['english' => 'Anonymous Function', 'arabic' => 'دالة مجهولة', 'example' => 'function() {}'],
                    ['english' => 'Scope', 'arabic' => 'نطاق', 'example' => 'global/local scope'],
                    ['english' => 'Closure', 'arabic' => 'إغلاق', 'example' => 'function outer() { return inner }'],
                    ['english' => 'Recursion', 'arabic' => 'استدعاء ذاتي', 'example' => 'function factorial(n)'],
                    ['english' => 'Higher Order Function', 'arabic' => 'دالة عالية الرتبة', 'example' => 'map, filter, reduce'],
                    ['english' => 'Pure Function', 'arabic' => 'دالة نقية', 'example' => 'no side effects'],
                    ['english' => 'Side Effect', 'arabic' => 'تأثير جانبي', 'example' => 'modifying global state'],
                    ['english' => 'IIFE', 'arabic' => 'دالة فورية التنفيذ', 'example' => '(function() {})()'],
                ]
            ],
            5 => [
                'title' => 'OOP Concepts',
                'titleAr' => 'البرمجة الكائنية',
                'slug' => 'oop',
                'terms' => [
                    ['english' => 'Class', 'arabic' => 'صنف / فئة', 'example' => 'class User {}'],
                    ['english' => 'Object', 'arabic' => 'كائن', 'example' => 'new User()'],
                    ['english' => 'Instance', 'arabic' => 'نسخة / مثيل', 'example' => 'const user = new User()'],
                    ['english' => 'Constructor', 'arabic' => 'بناء', 'example' => 'constructor() {}'],
                    ['english' => 'Property', 'arabic' => 'خاصية', 'example' => 'this.name = name'],
                    ['english' => 'Method', 'arabic' => 'أسلوب', 'example' => 'this.getName() {}'],
                    ['english' => 'Inheritance', 'arabic' => 'وراثة', 'example' => 'extends ParentClass'],
                    ['english' => 'Polymorphism', 'arabic' => 'تعدد الأشكال', 'example' => 'method overriding'],
                    ['english' => 'Encapsulation', 'arabic' => 'تغليف', 'example' => 'private properties'],
                    ['english' => 'Abstraction', 'arabic' => 'تجريد', 'example' => 'abstract class'],
                    ['english' => 'Interface', 'arabic' => 'واجهة', 'example' => 'interface IUser {}'],
                    ['english' => 'Public', 'arabic' => 'عام', 'example' => 'public method()'],
                    ['english' => 'Private', 'arabic' => 'خاص', 'example' => 'private #field'],
                    ['english' => 'Protected', 'arabic' => 'محمي', 'example' => 'protected field'],
                    ['english' => 'Static', 'arabic' => 'ثابت', 'example' => 'static method()'],
                ]
            ],
            6 => [
                'title' => 'Web Development',
                'titleAr' => 'تطوير الويب',
                'slug' => 'web-dev',
                'terms' => [
                    ['english' => 'HTML', 'arabic' => 'لغة ترميز النص الفائق', 'example' => '<div>content</div>'],
                    ['english' => 'CSS', 'arabic' => 'أوراق الأنماط المتتالية', 'example' => 'color: blue;'],
                    ['english' => 'JavaScript', 'arabic' => 'جافا سكريبت', 'example' => 'console.log("Hi")'],
                    ['english' => 'DOM', 'arabic' => 'نموذج كائن المستند', 'example' => 'document.getElementById()'],
                    ['english' => 'Element', 'arabic' => 'عنصر', 'example' => '<button>Click</button>'],
                    ['english' => 'Attribute', 'arabic' => 'سمة', 'example' => 'class="btn"'],
                    ['english' => 'Selector', 'arabic' => 'محدد', 'example' => '.class, #id, tag'],
                    ['english' => 'Event', 'arabic' => 'حدث', 'example' => 'click, submit, load'],
                    ['english' => 'Event Listener', 'arabic' => 'مستمع الحدث', 'example' => 'addEventListener("click")'],
                    ['english' => 'Async', 'arabic' => 'غير متزامن', 'example' => 'async function()'],
                    ['english' => 'Await', 'arabic' => 'انتظار', 'example' => 'await fetch()'],
                    ['english' => 'Promise', 'arabic' => 'وعد', 'example' => 'new Promise()'],
                    ['english' => 'Component', 'arabic' => 'مكون', 'example' => '<MyComponent />'],
                    ['english' => 'Responsive', 'arabic' => 'متجاوب', 'example' => '@media screen'],
                    ['english' => 'Framework', 'arabic' => 'إطار عمل', 'example' => 'React, Vue, Angular'],
                ]
            ],
            7 => [
                'title' => 'Database & SQL',
                'titleAr' => 'قواعد البيانات',
                'slug' => 'database',
                'terms' => [
                    ['english' => 'Database', 'arabic' => 'قاعدة بيانات', 'example' => 'MySQL, PostgreSQL'],
                    ['english' => 'Table', 'arabic' => 'جدول', 'example' => 'users, posts'],
                    ['english' => 'Row', 'arabic' => 'صف / سجل', 'example' => 'a single record'],
                    ['english' => 'Column', 'arabic' => 'عمود / حقل', 'example' => 'id, name, email'],
                    ['english' => 'Primary Key', 'arabic' => 'مفتاح أساسي', 'example' => 'id INT PRIMARY KEY'],
                    ['english' => 'Foreign Key', 'arabic' => 'مفتاح خارجي', 'example' => 'user_id REFERENCES users'],
                    ['english' => 'Query', 'arabic' => 'استعلام', 'example' => 'SELECT * FROM users'],
                    ['english' => 'Join', 'arabic' => 'ربط / دمج', 'example' => 'INNER JOIN, LEFT JOIN'],
                    ['english' => 'Index', 'arabic' => 'فهرس', 'example' => 'CREATE INDEX idx_name'],
                    ['english' => 'Transaction', 'arabic' => 'معاملة', 'example' => 'BEGIN, COMMIT, ROLLBACK'],
                    ['english' => 'Constraint', 'arabic' => 'قيد', 'example' => 'UNIQUE, NOT NULL'],
                    ['english' => 'Normalization', 'arabic' => 'تطبيع', 'example' => '1NF, 2NF, 3NF'],
                    ['english' => 'Migration', 'arabic' => 'هجرة', 'example' => 'schema changes'],
                    ['english' => 'Seeder', 'arabic' => 'بذار / ملء', 'example' => 'populate test data'],
                    ['english' => 'ORM', 'arabic' => 'تعيين كائني علائقي', 'example' => 'Eloquent, Prisma'],
                ]
            ],
            8 => [
                'title' => 'Git & Version Control',
                'titleAr' => 'إدارة النسخ',
                'slug' => 'git',
                'terms' => [
                    ['english' => 'Git', 'arabic' => 'جِت', 'example' => 'version control system'],
                    ['english' => 'Repository', 'arabic' => 'مستودع', 'example' => 'git init, git clone'],
                    ['english' => 'Commit', 'arabic' => 'إيداع / تثبيت', 'example' => 'git commit -m "message"'],
                    ['english' => 'Branch', 'arabic' => 'فرع', 'example' => 'git branch feature'],
                    ['english' => 'Merge', 'arabic' => 'دمج', 'example' => 'git merge branch'],
                    ['english' => 'Pull', 'arabic' => 'سحب', 'example' => 'git pull origin main'],
                    ['english' => 'Push', 'arabic' => 'دفع', 'example' => 'git push origin main'],
                    ['english' => 'Clone', 'arabic' => 'استنساخ', 'example' => 'git clone url'],
                    ['english' => 'Fork', 'arabic' => 'نسخ احتياطي', 'example' => 'fork on GitHub'],
                    ['english' => 'Pull Request', 'arabic' => 'طلب سحب', 'example' => 'PR for code review'],
                    ['english' => 'Conflict', 'arabic' => 'تعارض', 'example' => 'merge conflict'],
                    ['english' => 'Staging Area', 'arabic' => 'منطقة التجهيز', 'example' => 'git add file'],
                    ['english' => 'Remote', 'arabic' => 'بعيد', 'example' => 'git remote add origin'],
                    ['english' => 'Checkout', 'arabic' => 'تبديل / سحب', 'example' => 'git checkout branch'],
                    ['english' => 'Stash', 'arabic' => 'تخزين مؤقت', 'example' => 'git stash'],
                ]
            ],
            9 => [
                'title' => 'Testing & Debugging',
                'titleAr' => 'الاختبار وإصلاح الأخطاء',
                'slug' => 'testing',
                'terms' => [
                    ['english' => 'Test', 'arabic' => 'اختبار', 'example' => 'test("should work")'],
                    ['english' => 'Unit Test', 'arabic' => 'اختبار وحدة', 'example' => 'test single function'],
                    ['english' => 'Integration Test', 'arabic' => 'اختبار تكامل', 'example' => 'test multiple units'],
                    ['english' => 'E2E Test', 'arabic' => 'اختبار شامل', 'example' => 'end-to-end testing'],
                    ['english' => 'Mock', 'arabic' => 'محاكاة', 'example' => 'jest.mock()'],
                    ['english' => 'Stub', 'arabic' => 'بديل مؤقت', 'example' => 'replace function'],
                    ['english' => 'Assertion', 'arabic' => 'تأكيد', 'example' => 'expect(x).toBe(5)'],
                    ['english' => 'Test Suite', 'arabic' => 'مجموعة اختبارات', 'example' => 'describe("User")'],
                    ['english' => 'Coverage', 'arabic' => 'تغطية', 'example' => '80% code coverage'],
                    ['english' => 'Debug', 'arabic' => 'إصلاح أخطاء', 'example' => 'debugger;'],
                    ['english' => 'Breakpoint', 'arabic' => 'نقطة توقف', 'example' => 'pause execution'],
                    ['english' => 'Console', 'arabic' => 'وحدة التحكم', 'example' => 'console.log()'],
                    ['english' => 'Error', 'arabic' => 'خطأ', 'example' => 'throw new Error()'],
                    ['english' => 'Bug', 'arabic' => 'علة / خطأ برمجي', 'example' => 'unexpected behavior'],
                    ['english' => 'TDD', 'arabic' => 'تطوير مدفوع بالاختبار', 'example' => 'Test Driven Development'],
                ]
            ],
            10 => [
                'title' => 'Algorithms & Data Structures',
                'titleAr' => 'الخوارزميات وهياكل البيانات',
                'slug' => 'algorithms',
                'terms' => [
                    ['english' => 'Algorithm', 'arabic' => 'خوارزمية', 'example' => 'step-by-step procedure'],
                    ['english' => 'Complexity', 'arabic' => 'تعقيد', 'example' => 'O(n), O(log n)'],
                    ['english' => 'Big O', 'arabic' => 'الأوه الكبيرة', 'example' => 'time complexity'],
                    ['english' => 'Sorting', 'arabic' => 'فرز / ترتيب', 'example' => 'bubble, merge, quick sort'],
                    ['english' => 'Searching', 'arabic' => 'بحث', 'example' => 'binary search, linear search'],
                    ['english' => 'Recursion', 'arabic' => 'استدعاء ذاتي', 'example' => 'function calls itself'],
                    ['english' => 'Binary Tree', 'arabic' => 'شجرة ثنائية', 'example' => 'tree with 2 children'],
                    ['english' => 'Graph', 'arabic' => 'رسم بياني', 'example' => 'nodes and edges'],
                    ['english' => 'Linked List', 'arabic' => 'قائمة مرتبطة', 'example' => 'node.next'],
                    ['english' => 'Hash Table', 'arabic' => 'جدول تجزئة', 'example' => 'key-value pairs'],
                    ['english' => 'DFS', 'arabic' => 'بحث عمق أولاً', 'example' => 'Depth First Search'],
                    ['english' => 'BFS', 'arabic' => 'بحث عرض أولاً', 'example' => 'Breadth First Search'],
                    ['english' => 'Dynamic Programming', 'arabic' => 'برمجة ديناميكية', 'example' => 'memoization'],
                    ['english' => 'Greedy', 'arabic' => 'جشع', 'example' => 'optimal local choice'],
                    ['english' => 'Divide & Conquer', 'arabic' => 'فرق تسد', 'example' => 'merge sort'],
                ]
            ],
            11 => [
                'title' => 'Software Engineering',
                'titleAr' => 'هندسة البرمجيات',
                'slug' => 'software-engineering',
                'terms' => [
                    ['english' => 'Architecture', 'arabic' => 'معمارية', 'example' => 'MVC, Microservices'],
                    ['english' => 'Design Pattern', 'arabic' => 'نمط تصميم', 'example' => 'Singleton, Factory'],
                    ['english' => 'SOLID', 'arabic' => 'مبادئ سوليد', 'example' => 'OOP principles'],
                    ['english' => 'DRY', 'arabic' => 'لا تكرر نفسك', 'example' => "Don't Repeat Yourself"],
                    ['english' => 'KISS', 'arabic' => 'أبقِها بسيطة', 'example' => 'Keep It Simple Stupid'],
                    ['english' => 'Refactoring', 'arabic' => 'إعادة هيكلة', 'example' => 'improve code structure'],
                    ['english' => 'Code Review', 'arabic' => 'مراجعة الكود', 'example' => 'peer review process'],
                    ['english' => 'Technical Debt', 'arabic' => 'دين تقني', 'example' => 'shortcuts taken'],
                    ['english' => 'Clean Code', 'arabic' => 'كود نظيف', 'example' => 'readable, maintainable'],
                    ['english' => 'Best Practice', 'arabic' => 'أفضل ممارسة', 'example' => 'industry standards'],
                    ['english' => 'Convention', 'arabic' => 'اصطلاح', 'example' => 'naming conventions'],
                    ['english' => 'Documentation', 'arabic' => 'توثيق', 'example' => 'comments, README'],
                    ['english' => 'Maintainability', 'arabic' => 'قابلية الصيانة', 'example' => 'easy to modify'],
                    ['english' => 'Scalability', 'arabic' => 'قابلية التوسع', 'example' => 'handle growth'],
                    ['english' => 'Deployment', 'arabic' => 'نشر', 'example' => 'push to production'],
                ]
            ],
            12 => [
                'title' => 'DevOps & Deployment',
                'titleAr' => 'عمليات التطوير والنشر',
                'slug' => 'devops',
                'terms' => [
                    ['english' => 'CI/CD', 'arabic' => 'تكامل ونشر مستمر', 'example' => 'automated pipeline'],
                    ['english' => 'Container', 'arabic' => 'حاوية', 'example' => 'Docker container'],
                    ['english' => 'Docker', 'arabic' => 'دوكر', 'example' => 'containerization platform'],
                    ['english' => 'Image', 'arabic' => 'صورة', 'example' => 'docker image'],
                    ['english' => 'Cloud', 'arabic' => 'سحابة', 'example' => 'AWS, Azure, GCP'],
                    ['english' => 'Server', 'arabic' => 'خادم', 'example' => 'web server, database server'],
                    ['english' => 'Hosting', 'arabic' => 'استضافة', 'example' => 'host application online'],
                    ['english' => 'Environment', 'arabic' => 'بيئة', 'example' => 'dev, staging, production'],
                    ['english' => 'Build', 'arabic' => 'بناء', 'example' => 'compile and package'],
                    ['english' => 'Pipeline', 'arabic' => 'خط أنابيب', 'example' => 'automated workflow'],
                    ['english' => 'Artifact', 'arabic' => 'مُنتج', 'example' => 'build output'],
                    ['english' => 'Load Balancer', 'arabic' => 'موازن حمل', 'example' => 'distribute traffic'],
                    ['english' => 'Monitoring', 'arabic' => 'مراقبة', 'example' => 'track performance'],
                    ['english' => 'Logging', 'arabic' => 'تسجيل', 'example' => 'record events'],
                    ['english' => 'Infrastructure', 'arabic' => 'بنية تحتية', 'example' => 'servers, networks'],
                ]
            ],
            13 => [
                'title' => 'Security',
                'titleAr' => 'الأمن السيبراني',
                'slug' => 'security',
                'terms' => [
                    ['english' => 'Authentication', 'arabic' => 'مصادقة', 'example' => 'verify identity'],
                    ['english' => 'Authorization', 'arabic' => 'تفويض', 'example' => 'check permissions'],
                    ['english' => 'Encryption', 'arabic' => 'تشفير', 'example' => 'encode data'],
                    ['english' => 'Hashing', 'arabic' => 'تجزئة', 'example' => 'bcrypt, SHA-256'],
                    ['english' => 'Token', 'arabic' => 'رمز', 'example' => 'JWT, OAuth token'],
                    ['english' => 'HTTPS', 'arabic' => 'بروتوكول آمن', 'example' => 'HTTP + SSL/TLS'],
                    ['english' => 'SSL/TLS', 'arabic' => 'طبقة مآخذ آمنة', 'example' => 'secure connection'],
                    ['english' => 'XSS', 'arabic' => 'هجوم برمجي عابر', 'example' => 'Cross-Site Scripting'],
                    ['english' => 'SQL Injection', 'arabic' => 'حقن SQL', 'example' => 'malicious SQL query'],
                    ['english' => 'CSRF', 'arabic' => 'تزوير طلب عبر المواقع', 'example' => 'Cross-Site Request Forgery'],
                    ['english' => 'Vulnerability', 'arabic' => 'ثغرة أمنية', 'example' => 'security weakness'],
                    ['english' => 'Firewall', 'arabic' => 'جدار ناري', 'example' => 'network security'],
                    ['english' => 'Sanitization', 'arabic' => 'تعقيم', 'example' => 'clean user input'],
                    ['english' => 'CORS', 'arabic' => 'مشاركة الموارد عبر الأصول', 'example' => 'Cross-Origin Resource Sharing'],
                    ['english' => 'Rate Limiting', 'arabic' => 'تحديد المعدل', 'example' => 'prevent abuse'],
                ]
            ],
            14 => [
                'title' => 'Professional Communication',
                'titleAr' => 'التواصل المهني',
                'slug' => 'professional',
                'terms' => [
                    ['english' => 'Code Review', 'arabic' => 'مراجعة الكود', 'example' => 'peer code review'],
                    ['english' => 'Documentation', 'arabic' => 'توثيق', 'example' => 'README, comments'],
                    ['english' => 'Comment', 'arabic' => 'تعليق', 'example' => '// explanation'],
                    ['english' => 'Agile', 'arabic' => 'رشيق', 'example' => 'agile methodology'],
                    ['english' => 'Scrum', 'arabic' => 'سكرَم', 'example' => 'agile framework'],
                    ['english' => 'Sprint', 'arabic' => 'سباق / فترة', 'example' => '2-week iteration'],
                    ['english' => 'Standup', 'arabic' => 'اجتماع وقوف', 'example' => 'daily standup meeting'],
                    ['english' => 'Retrospective', 'arabic' => 'استعراض ماضي', 'example' => 'sprint retrospective'],
                    ['english' => 'User Story', 'arabic' => 'قصة مستخدم', 'example' => 'As a user, I want...'],
                    ['english' => 'Epic', 'arabic' => 'ملحمة', 'example' => 'large user story'],
                    ['english' => 'Backlog', 'arabic' => 'قائمة متراكمة', 'example' => 'product backlog'],
                    ['english' => 'Ticket', 'arabic' => 'تذكرة / مهمة', 'example' => 'Jira ticket'],
                    ['english' => 'Issue', 'arabic' => 'مشكلة', 'example' => 'GitHub issue'],
                    ['english' => 'Milestone', 'arabic' => 'معلم / إنجاز', 'example' => 'project milestone'],
                    ['english' => 'Stakeholder', 'arabic' => 'صاحب مصلحة', 'example' => 'project stakeholder'],
                ]
            ],
        ];
    }
}
