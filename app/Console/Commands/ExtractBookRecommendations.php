<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;

class ExtractBookRecommendations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:extract-books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract book recommendations from task descriptions and add them as resources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Extracting book recommendations from task descriptions...');

        $tasks = Task::all();
        $updated = 0;

        foreach ($tasks as $task) {
            if (!$task->description) {
                continue;
            }

            // Extract book recommendations from description
            $books = $this->extractBookRecommendations($task->description);

            if (empty($books)) {
                continue;
            }

            // Get existing resources or initialize
            $resources = $task->resources_links ?? [];

            // Add books to resources if not already present
            foreach ($books as $book) {
                // Check if this book URL is already in resources
                $exists = false;
                foreach ($resources as $resource) {
                    $url = is_array($resource) ? ($resource['url'] ?? '') : $resource;
                    if ($url === $book['url']) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    $resources[] = $book;
                }
            }

            // Remove book recommendations from description
            $cleanDescription = $this->removeBookRecommendations($task->description);

            // Update task
            $task->resources_links = $resources;
            $task->description = $cleanDescription;
            $task->save();

            $updated++;
            $this->info("Updated task: {$task->title} - Added " . count($books) . " book(s)");
        }

        $this->info("✓ Completed! Updated {$updated} tasks.");
    }

    /**
     * Extract book recommendations from description text
     */
    private function extractBookRecommendations($description)
    {
        $books = [];

        // Pattern 1: 💡 Book recommendation: Read Chapter X of "Title" by Author (note)
        if (preg_match('/💡\s*Book recommendation:\s*(?:Read\s+)?(Chapter\s+\d+\s+of\s+)?"([^"]+)"\s*by\s+([^(]+)(?:\(([^)]+)\))?/i', $description, $matches)) {
            $chapter = isset($matches[1]) ? trim($matches[1]) : '';
            $bookTitle = trim($matches[2]);
            $author = trim($matches[3]);
            $note = isset($matches[4]) ? trim($matches[4]) : '';

            $url = $this->findBookUrl($bookTitle, $author);

            $displayTitle = $bookTitle . ' by ' . $author;
            if ($chapter) {
                $displayTitle .= ' - ' . $chapter;
            }
            if ($note) {
                $displayTitle .= ' (' . $note . ')';
            }

            $books[] = [
                'title' => $displayTitle,
                'url' => $url
            ];
        }
        // Pattern 2: 💡 Book: "Title" - Chapter/Section OR "Title" Chapter X
        elseif (preg_match('/💡\s*Book:\s*"([^"]+)"\s*(?:-\s*)?(.+?)(?:\.|$)/i', $description, $matches)) {
            $bookTitle = trim($matches[1]);
            $section = trim($matches[2]);

            $url = $this->findBookUrl($bookTitle, '');

            $books[] = [
                'title' => $bookTitle . ' - ' . $section,
                'url' => $url
            ];
        }
        // Pattern 3: 💡 Book: "Title" by Author - description
        elseif (preg_match('/💡\s*Book:\s*"([^"]+)"\s*by\s+([^-]+)\s*-\s*(.+?)(?:\.|$)/i', $description, $matches)) {
            $bookTitle = trim($matches[1]);
            $author = trim($matches[2]);
            $desc = trim($matches[3]);

            $url = $this->findBookUrl($bookTitle, $author);

            $books[] = [
                'title' => $bookTitle . ' by ' . $author . ' - ' . $desc,
                'url' => $url
            ];
        }
        // Pattern 4: 💡 Read/Check "Title" - description or 💡 Reference: ...
        elseif (preg_match('/💡\s*(?:Read|Check out|Reference:)\s*(?:"([^"]+)"|([^-]+))\s*(?:-\s*(.+?))?(?:\.|$)/i', $description, $matches)) {
            $bookTitle = !empty($matches[1]) ? trim($matches[1]) : trim($matches[2]);
            $desc = isset($matches[3]) ? trim($matches[3]) : '';

            $url = $this->findBookUrl($bookTitle, '');

            $displayTitle = $bookTitle;
            if ($desc) {
                $displayTitle .= ' - ' . $desc;
            }

            $books[] = [
                'title' => $displayTitle,
                'url' => $url
            ];
        }

        return $books;
    }

    /**
     * Find or generate URL for a book
     */
    private function findBookUrl($title, $author)
    {
        // Known book URLs (free online books prioritized)
        $knownBooks = [
            'Eloquent JavaScript' => 'https://eloquentjavascript.net/',
            'Think Like a Programmer' => 'https://www.amazon.com/Think-Like-Programmer-Introduction-Creative/dp/1593274246',
            'How to Think Like a Computer Scientist' => 'https://runestone.academy/runestone/books/published/thinkcspy/index.html',
            'Introduction to Algorithms' => 'https://mitpress.mit.edu/books/introduction-algorithms-third-edition',
            'Grokking Algorithms' => 'https://www.manning.com/books/grokking-algorithms',
            'Code: The Hidden Language' => 'https://www.amazon.com/Code-Language-Computer-Hardware-Software/dp/0735611319',
            'Head First Object-Oriented Analysis' => 'https://www.oreilly.com/library/view/head-first-object-oriented/0596008678/',
            'Clean Code' => 'https://www.amazon.com/Clean-Code-Handbook-Software-Craftsmanship/dp/0132350882',
            'Refactoring' => 'https://www.amazon.com/Refactoring-Improving-Design-Existing-Code/dp/0201485672',
            'Pro Git' => 'https://git-scm.com/book/en/v2',
            'Database Design for Mere Mortals' => 'https://www.amazon.com/Database-Design-Mere-Mortals-Hands/dp/0321884493',
            'Missing Semester' => 'https://missing.csail.mit.edu/',
            'Julia Evans' => 'https://jvns.ca/',
            'refactoring.guru' => 'https://refactoring.guru/design-patterns',
        ];

        foreach ($knownBooks as $bookName => $url) {
            if (stripos($title, $bookName) !== false) {
                return $url;
            }
        }

        // Fallback: Generate Google Books search URL
        $searchQuery = urlencode($title . ' ' . $author);
        return "https://www.google.com/search?q={$searchQuery}+book";
    }

    /**
     * Remove book recommendation patterns from description
     */
    private function removeBookRecommendations($description)
    {
        // Remove all patterns with 💡 (book recommendations and other references)
        $description = preg_replace('/\s*💡\s*[^.]*\./i', '', $description);

        // Clean up extra spaces and periods
        $description = preg_replace('/\s+/', ' ', $description);
        $description = preg_replace('/\s*\.\s*\./', '.', $description);
        $description = trim($description);

        return $description;
    }
}
