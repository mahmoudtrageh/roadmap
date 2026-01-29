<?php

namespace App\Livewire\Student;

use Livewire\Component;

class Books extends Component
{
    public $books = [];

    public function mount()
    {
        $this->books = [
            // Fundamentals & Best Practices
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'description' => 'A handbook of agile software craftsmanship. Learn to write code that is clean, readable, and maintainable. Essential reading for every software developer.',
                'topics' => ['Code Quality', 'Best Practices', 'Software Craftsmanship'],
                'level' => 'Intermediate',
                'pages' => 464,
                'year' => 2008,
                'isbn' => '978-0132350884',
                'icon' => '📘',
                'language' => 'en',
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'Andrew Hunt & David Thomas',
                'description' => 'From journeyman to master. A classic guide to becoming a better programmer with practical advice, timeless principles, and career development tips.',
                'topics' => ['Career Development', 'Best Practices', 'Software Engineering'],
                'level' => 'All Levels',
                'pages' => 352,
                'year' => 2019,
                'isbn' => '978-0135957059',
                'icon' => '🔧',
                'language' => 'en',
            ],
            [
                'title' => 'Code Complete',
                'author' => 'Steve McConnell',
                'description' => 'A practical handbook of software construction. Covers design, coding, debugging, and testing with proven techniques from real-world projects.',
                'topics' => ['Software Construction', 'Design', 'Best Practices'],
                'level' => 'Intermediate',
                'pages' => 960,
                'year' => 2004,
                'isbn' => '978-0735619678',
                'icon' => '📗',
                'language' => 'en',
            ],

            // JavaScript & Web Development
            [
                'title' => 'Eloquent JavaScript',
                'author' => 'Marijn Haverbeke',
                'description' => 'A modern introduction to programming with JavaScript. Covers fundamentals, browser programming, and Node.js. Available free online!',
                'topics' => ['JavaScript', 'Programming Fundamentals', 'Web Development'],
                'level' => 'Beginner',
                'pages' => 472,
                'year' => 2018,
                'isbn' => '978-1593279509',
                'icon' => '📙',
                'language' => 'en',
            ],
            [
                'title' => 'You Don\'t Know JS (Book Series)',
                'author' => 'Kyle Simpson',
                'description' => 'Deep dive into JavaScript mechanisms. Six-book series covering scope, closures, this, prototypes, async programming, and ES6+. Free on GitHub!',
                'topics' => ['JavaScript', 'Deep Learning', 'Language Internals'],
                'level' => 'Intermediate to Advanced',
                'pages' => '~200 per book',
                'year' => 2014-2020,
                'isbn' => 'Various',
                'icon' => '📚',
                'language' => 'en',
            ],
            [
                'title' => 'JavaScript: The Good Parts',
                'author' => 'Douglas Crockford',
                'description' => 'A concise guide to the best features of JavaScript. Learn which parts of the language to use and which to avoid.',
                'topics' => ['JavaScript', 'Best Practices', 'Language Features'],
                'level' => 'Intermediate',
                'pages' => 176,
                'year' => 2008,
                'isbn' => '978-0596517748',
                'icon' => '⭐',
                'language' => 'en',
            ],

            // Algorithms & Data Structures
            [
                'title' => 'Grokking Algorithms',
                'author' => 'Aditya Bhargava',
                'description' => 'An illustrated guide for programmers and curious readers. Learn algorithms through diagrams and friendly explanations. Perfect for beginners!',
                'topics' => ['Algorithms', 'Data Structures', 'Problem Solving'],
                'level' => 'Beginner',
                'pages' => 256,
                'year' => 2016,
                'isbn' => '978-1617292231',
                'icon' => '🎨',
                'language' => 'en',
            ],
            [
                'title' => 'Introduction to Algorithms (CLRS)',
                'author' => 'Cormen, Leiserson, Rivest & Stein',
                'description' => 'The comprehensive guide to algorithms. Used in computer science courses worldwide. Deep, rigorous treatment of algorithms.',
                'topics' => ['Algorithms', 'Data Structures', 'Theory'],
                'level' => 'Advanced',
                'pages' => 1312,
                'year' => 2009,
                'isbn' => '978-0262033844',
                'icon' => '🎓',
                'language' => 'en',
            ],
            [
                'title' => 'Cracking the Coding Interview',
                'author' => 'Gayle Laakmann McDowell',
                'description' => 'Master the coding interview with 189 programming questions and solutions. Includes strategies for technical and behavioral interviews.',
                'topics' => ['Interview Prep', 'Algorithms', 'Problem Solving'],
                'level' => 'Intermediate',
                'pages' => 708,
                'year' => 2015,
                'isbn' => '978-0984782857',
                'icon' => '💼',
                'language' => 'en',
            ],

            // Design Patterns & Architecture
            [
                'title' => 'Design Patterns: Elements of Reusable Object-Oriented Software',
                'author' => 'Gang of Four (Gamma, Helm, Johnson, Vlissides)',
                'description' => 'The classic book on design patterns. Learn 23 essential patterns for creating flexible, reusable software. A must-read for OOP developers.',
                'topics' => ['Design Patterns', 'OOP', 'Software Architecture'],
                'level' => 'Intermediate to Advanced',
                'pages' => 395,
                'year' => 1994,
                'isbn' => '978-0201633610',
                'icon' => '🏛️',
                'language' => 'en',
            ],
            [
                'title' => 'Head First Design Patterns',
                'author' => 'Eric Freeman & Elisabeth Robson',
                'description' => 'Learn design patterns in a visually rich, engaging format. Brain-friendly approach with stories, exercises, and real-world examples.',
                'topics' => ['Design Patterns', 'OOP', 'Software Design'],
                'level' => 'Beginner to Intermediate',
                'pages' => 694,
                'year' => 2004,
                'isbn' => '978-0596007126',
                'icon' => '🧠',
                'language' => 'en',
            ],
            [
                'title' => 'Clean Architecture',
                'author' => 'Robert C. Martin',
                'description' => 'A craftsman\'s guide to software structure and design. Learn how to build systems that are testable, maintainable, and flexible.',
                'topics' => ['Software Architecture', 'Design Principles', 'Clean Code'],
                'level' => 'Intermediate to Advanced',
                'pages' => 432,
                'year' => 2017,
                'isbn' => '978-0134494166',
                'icon' => '🏗️',
                'language' => 'en',
            ],

            // Web Development Specific
            [
                'title' => 'HTML and CSS: Design and Build Websites',
                'author' => 'Jon Duckett',
                'description' => 'A beautifully designed introduction to HTML and CSS. Visual approach with full-color illustrations makes learning web design accessible.',
                'topics' => ['HTML', 'CSS', 'Web Design'],
                'level' => 'Beginner',
                'pages' => 490,
                'year' => 2011,
                'isbn' => '978-1118008188',
                'icon' => '🎨',
                'language' => 'en',
            ],
            [
                'title' => 'JavaScript and JQuery: Interactive Front-End Development',
                'author' => 'Jon Duckett',
                'description' => 'Learn JavaScript and jQuery with clear explanations and full-color diagrams. Perfect companion to HTML & CSS book.',
                'topics' => ['JavaScript', 'jQuery', 'Front-End Development'],
                'level' => 'Beginner',
                'pages' => 640,
                'year' => 2014,
                'isbn' => '978-1118531648',
                'icon' => '💻',
                'language' => 'en',
            ],

            // Backend & Databases
            [
                'title' => 'Designing Data-Intensive Applications',
                'author' => 'Martin Kleppmann',
                'description' => 'The big ideas behind reliable, scalable, and maintainable systems. Deep dive into databases, distributed systems, and data processing.',
                'topics' => ['Databases', 'Distributed Systems', 'System Design'],
                'level' => 'Advanced',
                'pages' => 616,
                'year' => 2017,
                'isbn' => '978-1449373320',
                'icon' => '🗄️',
                'language' => 'en',
            ],
            [
                'title' => 'RESTful Web APIs',
                'author' => 'Leonard Richardson & Mike Amundsen',
                'description' => 'Comprehensive guide to designing and implementing RESTful web services. Learn API design principles and best practices.',
                'topics' => ['APIs', 'REST', 'Web Services'],
                'level' => 'Intermediate',
                'pages' => 406,
                'year' => 2013,
                'isbn' => '978-1449358068',
                'icon' => '🔌',
                'language' => 'en',
            ],

            // Career & Soft Skills
            [
                'title' => 'Soft Skills: The Software Developer\'s Life Manual',
                'author' => 'John Sonmez',
                'description' => 'A unique guide to the non-technical aspects of being a developer. Covers career, productivity, finance, and fitness.',
                'topics' => ['Career', 'Productivity', 'Life Skills'],
                'level' => 'All Levels',
                'pages' => 504,
                'year' => 2014,
                'isbn' => '978-1617292392',
                'icon' => '💪',
                'language' => 'en',
            ],
            [
                'title' => 'The Complete Software Developer\'s Career Guide',
                'author' => 'John Sonmez',
                'description' => 'How to learn and succeed as a professional software developer. Covers getting started, finding jobs, climbing the ladder, and more.',
                'topics' => ['Career', 'Learning', 'Professional Development'],
                'level' => 'All Levels',
                'pages' => 796,
                'year' => 2017,
                'isbn' => '978-0999081327',
                'icon' => '🚀',
                'language' => 'en',
            ],

            // Testing & DevOps
            [
                'title' => 'Test Driven Development: By Example',
                'author' => 'Kent Beck',
                'description' => 'Learn TDD from the creator of Extreme Programming. Practical examples show how to write tests first and drive development with tests.',
                'topics' => ['TDD', 'Testing', 'Agile'],
                'level' => 'Intermediate',
                'pages' => 240,
                'year' => 2002,
                'isbn' => '978-0321146533',
                'icon' => '✅',
                'language' => 'en',
            ],
            [
                'title' => 'The Phoenix Project',
                'author' => 'Gene Kim, Kevin Behr & George Spafford',
                'description' => 'A novel about IT, DevOps, and helping your business win. Learn DevOps principles through an engaging story.',
                'topics' => ['DevOps', 'IT Management', 'Agile'],
                'level' => 'All Levels',
                'pages' => 432,
                'year' => 2013,
                'isbn' => '978-0988262508',
                'icon' => '🔥',
                'language' => 'en',
            ],

            // Free/Open Source Books
            [
                'title' => 'Automate the Boring Stuff with Python',
                'author' => 'Al Sweigart',
                'description' => 'Practical programming for total beginners. Learn Python by automating everyday tasks. Available free online!',
                'topics' => ['Python', 'Automation', 'Beginner-Friendly'],
                'level' => 'Beginner',
                'pages' => 504,
                'year' => 2019,
                'isbn' => '978-1593279929',
                'icon' => '🐍',
                'language' => 'en',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.student.books');
    }
}
