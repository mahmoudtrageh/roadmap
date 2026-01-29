<?php

namespace App\Livewire\Student;

use Livewire\Component;

class ProgrammingBlogs extends Component
{
    public $blogs = [];

    public function mount()
    {
        $this->blogs = [
            // English Blogs
            [
                'name' => 'Martin Fowler\'s Blog',
                'url' => 'https://martinfowler.com',
                'description' => 'Excellent for architecture, refactoring, and design patterns',
                'topics' => ['Architecture', 'Refactoring', 'Design Patterns'],
                'icon' => '🏛️',
                'language' => 'en',
            ],
            [
                'name' => 'The Pragmatic Engineer',
                'url' => 'https://blog.pragmaticengineer.com',
                'description' => 'Insights on engineering culture, career growth, and industry trends',
                'topics' => ['Engineering Culture', 'Career Growth', 'Industry Trends'],
                'icon' => '💼',
                'language' => 'en',
            ],
            [
                'name' => 'Joel on Software',
                'url' => 'https://joelonsoftware.com',
                'description' => 'Classic essays on software development and management',
                'topics' => ['Software Development', 'Management', 'Essays'],
                'icon' => '📝',
                'language' => 'en',
            ],
            [
                'name' => 'Coding Horror',
                'url' => 'https://blog.codinghorror.com',
                'description' => 'Jeff Atwood\'s blog covering practical programming wisdom',
                'topics' => ['Programming', 'Best Practices', 'Wisdom'],
                'icon' => '💡',
                'language' => 'en',
            ],
            [
                'name' => 'High Scalability',
                'url' => 'https://highscalability.com',
                'description' => 'Real-world architecture case studies from major companies',
                'topics' => ['System Design', 'Architecture', 'Case Studies'],
                'icon' => '🚀',
                'language' => 'en',
            ],
            [
                'name' => 'ByteByteGo',
                'url' => 'https://blog.bytebytego.com',
                'description' => 'System design concepts explained visually',
                'topics' => ['System Design', 'Backend', 'Visual Learning'],
                'icon' => '📊',
                'language' => 'en',
            ],
            [
                'name' => 'Laravel News',
                'url' => 'https://laravel-news.com',
                'description' => 'Essential for staying current with Laravel development',
                'topics' => ['Laravel', 'PHP', 'News'],
                'icon' => '🔴',
                'language' => 'en',
            ],
            [
                'name' => 'CSS-Tricks',
                'url' => 'https://css-tricks.com',
                'description' => 'Frontend techniques and modern CSS',
                'topics' => ['CSS', 'Frontend', 'Web Design'],
                'icon' => '🎨',
                'language' => 'en',
            ],
            [
                'name' => 'Smashing Magazine',
                'url' => 'https://smashingmagazine.com',
                'description' => 'Comprehensive web development and design articles',
                'topics' => ['Web Development', 'Design', 'UX'],
                'icon' => '📱',
                'language' => 'en',
            ],
            [
                'name' => 'Dev.to',
                'url' => 'https://dev.to',
                'description' => 'Community-driven with diverse topics and practical tutorials',
                'topics' => ['Community', 'Tutorials', 'Various Topics'],
                'icon' => '👥',
                'language' => 'en',
            ],
            [
                'name' => 'FreeCodeCamp Blog',
                'url' => 'https://freecodecamp.org/news',
                'description' => 'Beginner-friendly to advanced tutorials',
                'topics' => ['Tutorials', 'Learning', 'Web Development'],
                'icon' => '🎓',
                'language' => 'en',
            ],
            [
                'name' => 'Refactoring Guru',
                'url' => 'https://refactoring.guru',
                'description' => 'Design patterns and refactoring techniques with clear examples',
                'topics' => ['Design Patterns', 'Refactoring', 'Clean Code'],
                'icon' => '🔧',
                'language' => 'en',
            ],
            [
                'name' => 'Clean Coder Blog',
                'url' => 'https://blog.cleancoder.com',
                'description' => 'Robert Martin\'s writings on clean code principles',
                'topics' => ['Clean Code', 'SOLID', 'Best Practices'],
                'icon' => '✨',
                'language' => 'en',
            ],
            [
                'name' => 'Stitcher.io',
                'url' => 'https://stitcher.io',
                'description' => 'Modern PHP practices and Laravel insights',
                'topics' => ['PHP', 'Laravel', 'Modern Practices'],
                'icon' => '🐘',
                'language' => 'en',
            ],
            [
                'name' => 'PHP Weekly',
                'url' => 'https://phpweekly.com',
                'description' => 'Curated newsletter with latest PHP news and articles',
                'topics' => ['PHP', 'Newsletter', 'News'],
                'icon' => '📰',
                'language' => 'en',
            ],
            [
                'name' => 'A List Apart',
                'url' => 'https://alistapart.com',
                'description' => 'Web standards, design, and development for people who make websites',
                'topics' => ['Web Standards', 'Design', 'Development'],
                'icon' => '📐',
                'language' => 'en',
            ],
            [
                'name' => 'SitePoint',
                'url' => 'https://www.sitepoint.com',
                'description' => 'Web development tutorials, tips, and techniques',
                'topics' => ['Web Development', 'JavaScript', 'PHP', 'CSS'],
                'icon' => '🌐',
                'language' => 'en',
            ],
            [
                'name' => 'Scotch.io',
                'url' => 'https://scotch.io',
                'description' => 'Fun and practical web development tutorials',
                'topics' => ['Web Development', 'JavaScript', 'Node.js'],
                'icon' => '🥃',
                'language' => 'en',
            ],
            [
                'name' => 'Daily.dev',
                'url' => 'https://daily.dev',
                'description' => 'All developer news in one place, curated from 400+ sources',
                'topics' => ['News', 'Developer Tools', 'Community'],
                'icon' => '📱',
                'language' => 'en',
            ],
            [
                'name' => 'Hashnode',
                'url' => 'https://hashnode.com',
                'description' => 'Everything you need to start blogging as a developer',
                'topics' => ['Community', 'Blogging', 'Programming'],
                'icon' => '✍️',
                'language' => 'en',
            ],
            [
                'name' => 'CodeProject',
                'url' => 'https://www.codeproject.com',
                'description' => 'Free source code and tutorials for developers',
                'topics' => ['Programming', 'Source Code', 'Tutorials'],
                'icon' => '💾',
                'language' => 'en',
            ],
            [
                'name' => 'Medium - Programming',
                'url' => 'https://medium.com/tag/programming',
                'description' => 'Programming stories, tutorials, and opinions from various authors',
                'topics' => ['Programming', 'Tutorials', 'Stories'],
                'icon' => '📝',
                'language' => 'en',
            ],
            [
                'name' => 'Hackernoon',
                'url' => 'https://hackernoon.com',
                'description' => 'How hackers start their afternoons - tech stories and more',
                'topics' => ['Technology', 'Startups', 'Programming'],
                'icon' => '🎩',
                'language' => 'en',
            ],
            [
                'name' => 'Better Programming',
                'url' => 'https://betterprogramming.pub',
                'description' => 'Advice for programmers on Medium',
                'topics' => ['Programming', 'Best Practices', 'Tips'],
                'icon' => '⬆️',
                'language' => 'en',
            ],
            [
                'name' => 'LogRocket Blog',
                'url' => 'https://blog.logrocket.com',
                'description' => 'Frontend development and product management insights',
                'topics' => ['Frontend', 'JavaScript', 'React', 'Product'],
                'icon' => '🚀',
                'language' => 'en',
            ],
            [
                'name' => 'Netlify Blog',
                'url' => 'https://www.netlify.com/blog',
                'description' => 'Web development, JAMstack, and modern web practices',
                'topics' => ['JAMstack', 'Web Development', 'Serverless'],
                'icon' => '⚡',
                'language' => 'en',
            ],
            [
                'name' => 'DigitalOcean Community',
                'url' => 'https://www.digitalocean.com/community/tutorials',
                'description' => 'High-quality tutorials on cloud infrastructure and development',
                'topics' => ['DevOps', 'Cloud', 'Linux', 'Tutorials'],
                'icon' => '🌊',
                'language' => 'en',
            ],
            [
                'name' => 'Auth0 Blog',
                'url' => 'https://auth0.com/blog',
                'description' => 'Identity, security, and development best practices',
                'topics' => ['Security', 'Authentication', 'Web Development'],
                'icon' => '🔐',
                'language' => 'en',
            ],
            [
                'name' => 'Overreacted',
                'url' => 'https://overreacted.io',
                'description' => 'Dan Abramov\'s blog on React and JavaScript',
                'topics' => ['React', 'JavaScript', 'Frontend'],
                'icon' => '⚛️',
                'language' => 'en',
            ],
            [
                'name' => 'Kent C. Dodds',
                'url' => 'https://kentcdodds.com/blog',
                'description' => 'Testing, React, and JavaScript best practices',
                'topics' => ['React', 'Testing', 'JavaScript'],
                'icon' => '🧪',
                'language' => 'en',
            ],
            [
                'name' => 'Josh W. Comeau',
                'url' => 'https://www.joshwcomeau.com',
                'description' => 'Interactive tutorials on web development and CSS',
                'topics' => ['CSS', 'Frontend', 'Interactive Learning'],
                'icon' => '🎨',
                'language' => 'en',
            ],
            [
                'name' => 'CSS Wizardry',
                'url' => 'https://csswizardry.com',
                'description' => 'Harry Roberts on web performance and CSS architecture',
                'topics' => ['CSS', 'Performance', 'Architecture'],
                'icon' => '🧙',
                'language' => 'en',
            ],

        ];
    }

    public function render()
    {
        return view('livewire.student.programming-blogs');
    }
}
