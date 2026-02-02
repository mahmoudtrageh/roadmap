<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskExam;
use App\Models\ExamQuestion;
use Illuminate\Database\Seeder;

class FrontendBasicsExamsSeeder extends Seeder
{
    public function run(): void
    {
        $roadmapId = 3; // Frontend Basics

        $this->command->info("🎯 Creating exams for Frontend Basics Roadmap...");

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
        $this->command->info("✨ Created {$createdCount} exams for Frontend Basics!");
    }

    private function getExamsData(): array
    {
        return [
            'HTML Fundamentals' => [
                ['question' => 'What does HTML stand for?', 'options' => ['Hyper Text Markup Language', 'High Tech Modern Language', 'Home Tool Markup Language', 'Hyperlinks and Text Markup Language'], 'correct_answer' => 0],
                ['question' => 'Which HTML tag is used for the largest heading?', 'options' => ['<head>', '<h6>', '<h1>', '<heading>'], 'correct_answer' => 2],
                ['question' => 'Which HTML attribute specifies alternative text for an image?', 'options' => ['title', 'alt', 'src', 'href'], 'correct_answer' => 1],
                ['question' => 'What is the correct HTML for creating a hyperlink?', 'options' => ['<a url="http://example.com">', '<a href="http://example.com">', '<link>http://example.com</link>', '<hyperlink>http://example.com</hyperlink>'], 'correct_answer' => 1],
                ['question' => 'Which HTML tag is used to define an unordered list?', 'options' => ['<ol>', '<ul>', '<list>', '<li>'], 'correct_answer' => 1],
            ],

            'CSS Fundamentals' => [
                ['question' => 'What does CSS stand for?', 'options' => ['Computer Style Sheets', 'Cascading Style Sheets', 'Creative Style Sheets', 'Colorful Style Sheets'], 'correct_answer' => 1],
                ['question' => 'Which CSS property controls the text size?', 'options' => ['text-style', 'font-size', 'text-size', 'font-style'], 'correct_answer' => 1],
                ['question' => 'How do you add a background color in CSS?', 'options' => ['background-color:', 'bgcolor:', 'color:', 'bg-color:'], 'correct_answer' => 0],
                ['question' => 'Which CSS property is used to change the text color?', 'options' => ['text-color', 'font-color', 'color', 'text'], 'correct_answer' => 2],
                ['question' => 'How do you select an element with id="header" in CSS?', 'options' => ['.header', '#header', '*header', 'header'], 'correct_answer' => 1],
            ],

            'CSS Box Model' => [
                ['question' => 'What are the components of the CSS box model?', 'options' => ['Content, Border, Margin', 'Content, Padding, Border, Margin', 'Content, Padding, Margin', 'Border, Padding, Background'], 'correct_answer' => 1],
                ['question' => 'Which CSS property controls the space inside the border?', 'options' => ['margin', 'padding', 'spacing', 'border-spacing'], 'correct_answer' => 1],
                ['question' => 'Which CSS property controls the space outside the border?', 'options' => ['margin', 'padding', 'spacing', 'outside'], 'correct_answer' => 0],
                ['question' => 'What does "box-sizing: border-box" do?', 'options' => ['Removes border', 'Includes padding and border in element width', 'Adds extra border', 'Changes box color'], 'correct_answer' => 1],
                ['question' => 'Which CSS property is used to control layout flow?', 'options' => ['flow', 'display', 'layout', 'position'], 'correct_answer' => 1],
            ],

            'Flexbox' => [
                ['question' => 'What is Flexbox used for?', 'options' => ['Database layout', 'Flexible one-dimensional layout', 'Image editing', 'Text formatting'], 'correct_answer' => 1],
                ['question' => 'Which property makes an element a flex container?', 'options' => ['display: flex', 'flex: container', 'position: flex', 'layout: flex'], 'correct_answer' => 0],
                ['question' => 'Which property controls the direction of flex items?', 'options' => ['flex-direction', 'direction', 'flex-flow', 'orientation'], 'correct_answer' => 0],
                ['question' => 'What does "justify-content" control in flexbox?', 'options' => ['Vertical alignment', 'Horizontal alignment on main axis', 'Item order', 'Container size'], 'correct_answer' => 1],
                ['question' => 'What does "align-items" control in flexbox?', 'options' => ['Main axis alignment', 'Cross axis alignment', 'Item spacing', 'Container width'], 'correct_answer' => 1],
            ],

            'CSS Grid' => [
                ['question' => 'What is CSS Grid used for?', 'options' => ['One-dimensional layout', 'Two-dimensional grid-based layout', 'Image grids only', 'Table styling'], 'correct_answer' => 1],
                ['question' => 'How do you create a grid container?', 'options' => ['display: grid', 'grid: container', 'layout: grid', 'position: grid'], 'correct_answer' => 0],
                ['question' => 'Which property defines the number of columns in a grid?', 'options' => ['columns', 'grid-columns', 'grid-template-columns', 'column-count'], 'correct_answer' => 2],
                ['question' => 'What does "grid-gap" do?', 'options' => ['Creates grid', 'Sets spacing between grid items', 'Removes grid', 'Changes grid color'], 'correct_answer' => 1],
                ['question' => 'What does "fr" unit mean in CSS Grid?', 'options' => ['Frame', 'Fraction of available space', 'Fixed ratio', 'Full responsive'], 'correct_answer' => 1],
            ],

            'JavaScript Basics' => [
                ['question' => 'What is JavaScript primarily used for?', 'options' => ['Styling web pages', 'Adding interactivity to web pages', 'Database management', 'Server configuration'], 'correct_answer' => 1],
                ['question' => 'Which keyword is used to declare a block-scoped variable?', 'options' => ['var', 'int', 'let', 'define'], 'correct_answer' => 2],
                ['question' => 'What is the difference between "let" and "const"?', 'options' => ['No difference', 'const cannot be reassigned', 'let is faster', 'const is global'], 'correct_answer' => 1],
                ['question' => 'Which symbol is used for single-line comments in JavaScript?', 'options' => ['#', '//', '/*', '<!--'], 'correct_answer' => 1],
                ['question' => 'What does "console.log()" do?', 'options' => ['Creates console', 'Prints output to browser console', 'Logs in user', 'Saves log file'], 'correct_answer' => 1],
            ],

            'DOM Manipulation' => [
                ['question' => 'What does DOM stand for?', 'options' => ['Data Object Model', 'Document Object Model', 'Digital Output Mode', 'Document Ordering Method'], 'correct_answer' => 1],
                ['question' => 'Which method selects an element by its ID?', 'options' => ['getElementById()', 'querySelector()', 'getElement()', 'selectId()'], 'correct_answer' => 0],
                ['question' => 'Which method adds an event listener to an element?', 'options' => ['attachEvent()', 'addEventListener()', 'addListener()', 'onEvent()'], 'correct_answer' => 1],
                ['question' => 'How do you change the text content of an element?', 'options' => ['element.text', 'element.textContent', 'element.content', 'element.value'], 'correct_answer' => 1],
                ['question' => 'Which method creates a new HTML element?', 'options' => ['createElement()', 'newElement()', 'makeElement()', 'addElement()'], 'correct_answer' => 0],
            ],

            'JavaScript Events' => [
                ['question' => 'What is an event in JavaScript?', 'options' => ['Variable', 'Action that occurs in the browser', 'Function', 'Loop'], 'correct_answer' => 1],
                ['question' => 'Which event fires when a user clicks on an element?', 'options' => ['onpress', 'click', 'touch', 'select'], 'correct_answer' => 1],
                ['question' => 'What does "event.preventDefault()" do?', 'options' => ['Deletes event', 'Stops default browser behavior', 'Prevents errors', 'Speeds up event'], 'correct_answer' => 1],
                ['question' => 'What is event bubbling?', 'options' => ['Creating events', 'Event propagating from child to parent', 'Removing events', 'Event animation'], 'correct_answer' => 1],
                ['question' => 'Which event fires when a form is submitted?', 'options' => ['send', 'submit', 'post', 'form'], 'correct_answer' => 1],
            ],

            'Responsive Design' => [
                ['question' => 'What is responsive design?', 'options' => ['Fast website', 'Design that adapts to different screen sizes', 'Animated design', 'Backend design'], 'correct_answer' => 1],
                ['question' => 'Which CSS unit is relative to viewport width?', 'options' => ['px', 'vw', 'em', 'pt'], 'correct_answer' => 1],
                ['question' => 'What are media queries used for?', 'options' => ['Database queries', 'Applying styles based on device characteristics', 'Image queries', 'API queries'], 'correct_answer' => 1],
                ['question' => 'What does mobile-first approach mean?', 'options' => ['Desktop only', 'Designing for mobile devices first', 'Mobile app development', 'Tablet focus'], 'correct_answer' => 1],
                ['question' => 'Which meta tag is essential for responsive design?', 'options' => ['charset', 'viewport', 'description', 'keywords'], 'correct_answer' => 1],
            ],
        ];
    }
}
