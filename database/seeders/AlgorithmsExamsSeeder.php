<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskExam;
use App\Models\ExamQuestion;
use Illuminate\Database\Seeder;

class AlgorithmsExamsSeeder extends Seeder
{
    public function run(): void
    {
        $roadmapId = 7; // Algorithms & Data Structures

        $this->command->info("🎯 Creating exams for Algorithms & Data Structures Roadmap...");

        $examsData = $this->getExamsData();

        $createdCount = 0;
        foreach ($examsData as $taskTitle => $questions) {
            $task = Task::where('roadmap_id', $roadmapId)
                ->where('title', 'like', '%' . $taskTitle . '%')
                ->first();

            if (!$task) {
                $this->command->warn("⚠️  Task not found: {$taskTitle}");
                continue;
            }

            if ($task->exam) {
                $task->exam->questions()->delete();
                $task->exam->delete();
            }

            $exam = TaskExam::create([
                'task_id' => $task->id,
                'questions_count' => 5,
                'passing_score' => 60,
            ]);

            foreach ($questions as $q) {
                ExamQuestion::create([
                    'task_exam_id' => $exam->id,
                    'question' => $q['question'],
                    'options' => $q['options'],
                    'correct_answer' => $q['correct_answer'],
                ]);
            }

            $this->command->info("✅ {$task->title}");
            $createdCount++;
        }

        $this->command->newLine();
        $this->command->info("✨ Created {$createdCount} exams for Algorithms!");
    }

    private function getExamsData(): array
    {
        return [
            'Arrays & Two Pointers' => [
                ['question' => 'What is the time complexity of accessing an element in an array by index?', 'options' => ['O(n)', 'O(1)', 'O(log n)', 'O(n²)'], 'correct_answer' => 1],
                ['question' => 'What is the two-pointer technique?', 'options' => ['Using two arrays', 'Using two pointers to traverse array from different positions', 'Using two loops', 'Using two variables'], 'correct_answer' => 1],
                ['question' => 'What is the space complexity of the two-pointer technique?', 'options' => ['O(n)', 'O(1)', 'O(log n)', 'O(n²)'], 'correct_answer' => 1],
                ['question' => 'When is two-pointer technique most useful?', 'options' => ['Unsorted arrays only', 'Finding pairs or subsequences in sorted arrays', 'Matrix operations', 'Tree traversal'], 'correct_answer' => 1],
                ['question' => 'What is a sliding window?', 'options' => ['UI component', 'Technique to process subarrays of fixed or variable size', 'Sorting algorithm', 'Search algorithm'], 'correct_answer' => 1],
            ],

            'String Algorithms' => [
                ['question' => 'What is the time complexity of string concatenation?', 'options' => ['O(1)', 'O(n)', 'O(log n)', 'O(n²)'], 'correct_answer' => 1],
                ['question' => 'What is a palindrome?', 'options' => ['Reversed string', 'String that reads same forwards and backwards', 'Empty string', 'Long string'], 'correct_answer' => 1],
                ['question' => 'What is string pattern matching?', 'options' => ['Sorting strings', 'Finding occurrences of pattern in text', 'Reversing strings', 'Capitalizing strings'], 'correct_answer' => 1],
                ['question' => 'What is the KMP algorithm used for?', 'options' => ['Sorting', 'Efficient string pattern matching', 'Tree traversal', 'Graph search'], 'correct_answer' => 1],
                ['question' => 'What is a substring?', 'options' => ['Same as string', 'Contiguous sequence of characters within string', 'Reversed string', 'Empty string'], 'correct_answer' => 1],
            ],

            'Linked Lists' => [
                ['question' => 'What is a linked list?', 'options' => ['Array', 'Linear data structure with nodes containing data and pointer', 'Tree', 'Graph'], 'correct_answer' => 1],
                ['question' => 'What is the time complexity of inserting at head of linked list?', 'options' => ['O(n)', 'O(1)', 'O(log n)', 'O(n²)'], 'correct_answer' => 1],
                ['question' => 'What is the main advantage of linked list over array?', 'options' => ['Faster access', 'Dynamic size and efficient insertion/deletion', 'Less memory', 'Simpler'], 'correct_answer' => 1],
                ['question' => 'What is a doubly linked list?', 'options' => ['Two linked lists', 'Linked list with pointers to next and previous nodes', 'Circular list', 'Array'], 'correct_answer' => 1],
                ['question' => 'How do you detect a cycle in a linked list?', 'options' => ['Linear search', 'Floyd\'s cycle detection (slow and fast pointers)', 'Binary search', 'Sorting'], 'correct_answer' => 1],
            ],

            'Stacks & Queues' => [
                ['question' => 'What principle does a stack follow?', 'options' => ['FIFO', 'LIFO', 'Random', 'Sorted'], 'correct_answer' => 1],
                ['question' => 'What principle does a queue follow?', 'options' => ['LIFO', 'FIFO', 'Random', 'Sorted'], 'correct_answer' => 1],
                ['question' => 'What are the main operations of a stack?', 'options' => ['add, remove', 'push, pop', 'enqueue, dequeue', 'insert, delete'], 'correct_answer' => 1],
                ['question' => 'What is a use case for stacks?', 'options' => ['Sorting', 'Function call management and undo/redo', 'Database queries', 'File reading'], 'correct_answer' => 1],
                ['question' => 'What is a deque?', 'options' => ['Double stack', 'Double-ended queue allowing insertion/deletion at both ends', 'Priority queue', 'Circular queue'], 'correct_answer' => 1],
            ],

            'Hash Tables' => [
                ['question' => 'What is a hash table?', 'options' => ['Sorted array', 'Data structure mapping keys to values using hash function', 'Tree', 'Linked list'], 'correct_answer' => 1],
                ['question' => 'What is the average time complexity of hash table lookup?', 'options' => ['O(n)', 'O(1)', 'O(log n)', 'O(n²)'], 'correct_answer' => 1],
                ['question' => 'What is a hash collision?', 'options' => ['No collision', 'Two keys hash to same index', 'Empty hash table', 'Hash function error'], 'correct_answer' => 1],
                ['question' => 'What is chaining in hash tables?', 'options' => ['Deleting entries', 'Handling collisions using linked lists', 'Sorting entries', 'Encrypting data'], 'correct_answer' => 1],
                ['question' => 'What is open addressing?', 'options' => ['Public access', 'Collision resolution by finding another slot', 'No collision handling', 'Using multiple tables'], 'correct_answer' => 1],
            ],

            'Binary Trees' => [
                ['question' => 'What is a binary tree?', 'options' => ['Tree with 2 nodes', 'Tree where each node has at most 2 children', 'Sorted tree', 'Balanced tree'], 'correct_answer' => 1],
                ['question' => 'What is tree height?', 'options' => ['Number of nodes', 'Longest path from root to leaf', 'Number of leaves', 'Tree width'], 'correct_answer' => 1],
                ['question' => 'What is inorder traversal?', 'options' => ['Root, Left, Right', 'Left, Root, Right', 'Left, Right, Root', 'Random order'], 'correct_answer' => 1],
                ['question' => 'What is preorder traversal?', 'options' => ['Left, Root, Right', 'Root, Left, Right', 'Left, Right, Root', 'Root only'], 'correct_answer' => 1],
                ['question' => 'What is postorder traversal?', 'options' => ['Root, Left, Right', 'Left, Root, Right', 'Left, Right, Root', 'Right, Left, Root'], 'correct_answer' => 2],
            ],

            'Binary Search Trees' => [
                ['question' => 'What is a Binary Search Tree (BST)?', 'options' => ['Any binary tree', 'Binary tree where left < root < right', 'Balanced tree', 'Full tree'], 'correct_answer' => 1],
                ['question' => 'What is the average time complexity of BST search?', 'options' => ['O(n)', 'O(log n)', 'O(1)', 'O(n²)'], 'correct_answer' => 1],
                ['question' => 'What happens in worst case for unbalanced BST?', 'options' => ['O(1)', 'O(n) - degenerates to linked list', 'O(log n)', 'Tree breaks'], 'correct_answer' => 1],
                ['question' => 'What is the inorder traversal of BST?', 'options' => ['Random order', 'Sorted ascending order', 'Sorted descending', 'No specific order'], 'correct_answer' => 1],
                ['question' => 'What is a balanced BST?', 'options' => ['All leaves at same level', 'Height difference between subtrees is minimal', 'Equal nodes', 'No difference'], 'correct_answer' => 1],
            ],

            'Tree DFS & BFS' => [
                ['question' => 'What does DFS stand for?', 'options' => ['Data First Search', 'Depth First Search', 'Direct File System', 'Deep Find Search'], 'correct_answer' => 1],
                ['question' => 'What does BFS stand for?', 'options' => ['Binary First Search', 'Breadth First Search', 'Best Find Search', 'Backward File Search'], 'correct_answer' => 1],
                ['question' => 'Which data structure is used for DFS?', 'options' => ['Queue', 'Stack (or recursion)', 'Array', 'Hash table'], 'correct_answer' => 1],
                ['question' => 'Which data structure is used for BFS?', 'options' => ['Stack', 'Queue', 'Array', 'Tree'], 'correct_answer' => 1],
                ['question' => 'When is BFS preferred over DFS?', 'options' => ['Never', 'Finding shortest path in unweighted graph', 'Memory is limited', 'Always'], 'correct_answer' => 1],
            ],
        ];
    }
}
