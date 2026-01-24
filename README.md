# Roadmap Learning Platform - Complete Guide

A comprehensive learning management system for structured web development education from beginner to senior level.

---

## Table of Contents
1. [Quick Start](#quick-start)
2. [System Overview](#system-overview)
3. [Database Structure](#database-structure)
4. [User Roles & Workflows](#user-roles--workflows)
5. [Core Features](#core-features)
6. [Technology Stack](#technology-stack)
7. [Development Guide](#development-guide)
8. [Recommended Enhancements](#recommended-enhancements)

---

## Quick Start

### Installation

```bash
# Clone and navigate
cd roadmap

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_DATABASE=roadmap
DB_USERNAME=root
DB_PASSWORD=

# Run migrations and seed data
php artisan migrate
php artisan db:seed --class=FullStackRoadmapSeeder

# Build frontend assets
npm run build

# Start development server
php artisan serve
```

### Create Test Accounts

```bash
php artisan tinker
```

```php
// Admin account
User::create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin'
]);

// Instructor account
User::create([
    'name' => 'Instructor User',
    'email' => 'instructor@example.com',
    'password' => bcrypt('password'),
    'role' => 'instructor'
]);

// Student account
User::create([
    'name' => 'Student User',
    'email' => 'student@example.com',
    'password' => bcrypt('password'),
    'role' => 'student'
]);
```

### First Steps

1. Register at `/register` (default role: student)
2. Browse roadmaps at `/student/roadmaps`
3. Enroll in "Programming Fundamentals" (⭐ Start Here - for absolute beginners)
4. Begin learning at `/student/tasks`
5. Track progress at `/student/progress`

---

## System Overview

This platform provides a comprehensive 8-9 month learning journey through 8 progressive roadmaps, taking you from complete beginner (with no prior programming knowledge) to senior developer. The curriculum includes 251 real-world tasks with flexible daily time commitments that adapt to your schedule and the complexity of each topic.

### Key Features

- **8 Learning Roadmaps**: Programming Fundamentals → Web Foundations → Frontend → React → Laravel → Full Stack → Advanced → Senior Skills
- **251 Real-World Tasks**: Reading materials, video tutorials, coding exercises, and complete projects
- **Flexible Time Commitment**: Light days (1-2 hours), moderate days (2-3 hours), project days (3-4 hours)
- **Natural Learning Flow**: Tasks designed as cohesive units that mirror real development work
- **Curated Resources**: 3-4 focused learning resources per task from trusted sources
- **File Upload System**: Submit code files or ZIP projects for instructor review
- **Code Submission Enforcement**: Tasks requiring code cannot be completed until files are submitted
- **Progress Tracking**: Daily completion tracking with time metrics and streak system
- **Code Review System**: Upload files → Instructor downloads and reviews → Receive feedback
- **Reflection Tools**: Weekly and monthly review entries for self-assessment

### The 8 Roadmaps

0. **Programming Fundamentals** (85 tasks, Beginner) - Problem-solving, logic, data structures, OOP, debugging
1. **Web Development Foundations** (32 tasks, Beginner) - HTML, CSS, Git basics
2. **Frontend Fundamentals** (21 tasks, Beginner) - JavaScript, DOM manipulation, responsive design
3. **Frontend Framework - React** (23 tasks, Intermediate) - React ecosystem, hooks, state management
4. **Backend Development - Laravel** (25 tasks, Intermediate) - PHP, Laravel, databases, APIs
5. **Full Stack Integration** (20 tasks, Intermediate) - Connecting frontend and backend
6. **Advanced Topics & Best Practices** (21 tasks, Advanced) - Testing, security, performance, deployment
7. **Senior Level Skills** (24 tasks, Advanced) - Architecture, system design, leadership

**Total: 251 tasks across 8-9 months with flexible daily scheduling**

### How to Use Learning Resources

Each task includes 3-4 carefully curated resources to accommodate different learning styles:

**📚 Resource Types:**
- **Articles/Documentation**: For readers who prefer written explanations
- **Videos**: For visual learners (specific videos, not full playlists)
- **Interactive Tools**: Hands-on practice platforms (Exercism, Codewars, VisuAlgo)
- **Book Recommendations**: Specific chapters mentioned in task descriptions (💡 icon)

**✨ Learning Tips:**
- **You don't need to complete ALL resources** - Choose 1-2 that match your learning style
- **Prefer reading?** Start with the article or documentation link
- **Prefer watching?** Jump to the video resource
- **Want practice?** Focus on interactive platforms and exercises
- **Book chapters** are recommended for deeper understanding (most are free online)

**🌍 Multilingual Support:**
- English resources (primary)
- Arabic videos included where available
- Content from trusted sources: freeCodeCamp, MDN, CS50, roadmap.sh

**Example Task Resources:**
```
Task: "What is Programming?"
📖 Article: freeCodeCamp guide
📚 Book: Eloquent JavaScript Chapter 1 (free online)
🎥 Video: CS50 introduction
→ Pick the article OR video based on your preference
```

### Content Quality Assessment

**✅ Strong Real-World Resources:**
- All tasks include curated learning resources from trusted sources
- Primary sources: MDN Web Docs, official documentation, W3Schools
- Video tutorials from reputable channels
- Real APIs and tools for hands-on practice

**✅ Realistic Time Estimates:**
- **Light Tasks** (60-90 min): Reading, simple exercises, concept review
- **Moderate Tasks** (90-180 min): Hands-on practice, coding challenges
- **Project Tasks** (180-300 min): Building real applications, full-stack projects
- **Total learning hours**: ~890 hours across 251 tasks
- **Average**: 2-3 hours daily (flexible based on task complexity)

**✅ Comprehensive Coverage:**
- 251 carefully structured tasks across 8-9 months
- Mix of theory (reading/video) and practice (coding exercises)
- Progressive difficulty from beginner to senior level
- Real project builds at key milestones
- Tasks designed as cohesive units that mirror real development work
- Natural flow from concept introduction through hands-on implementation

**Sample Task Breakdown:**
```
🟢 Introduction to HTML (90 min - Light)
├─ Resources: MDN HTML Guide, W3Schools Tutorial
├─ Type: Reading
└─ Outcome: Understand HTML fundamentals

🟡 HTML Document Structure (120 min - Moderate)
├─ Resources: MDN Getting Started
├─ Type: Exercise + Code Submission
└─ Outcome: Build first HTML page with proper structure

🔴 Build a Personal Bio Page (240 min - Project)
├─ Resources: Project requirements
├─ Type: Project + Code Submission
└─ Outcome: Complete HTML project with all learned concepts
```

**Task Time Indicators:**
- 🟢 **Light** (60-90 min): Quick sessions for weekdays
- 🟡 **Moderate** (90-180 min): Standard practice tasks
- 🔴 **Project** (180-300 min): Deep work sessions, ideal for weekends

**Resource Quality Examples:**
- HTML/CSS: MDN Web Docs (industry standard)
- JavaScript: JavaScript.info, MDN JavaScript Guide
- React: Official React documentation, React.dev
- Laravel: Official Laravel documentation
- Git: Official Git documentation, GitHub guides
- APIs: JSONPlaceholder, Public APIs for practice

**Time Allocation Strategy:**
- **Flexible scheduling** - adapt to your life and energy levels
- **Light days**: 1-2 hours on weekdays (quick tasks, reading)
- **Standard days**: 2-3 hours (practice tasks, exercises)
- **Project days**: 3-4 hours on weekends (building real applications)
- **Total program**: 8-9 months with consistent progress
- **Total learning hours**: ~890 hours across 251 tasks
- **Weekly average**: 14-20 hours (adjust to your schedule)

**Flexible Study Schedules:**

**Option A - Working Professional (Evenings + Weekends)**
```
Monday-Friday:    1-2 hours each (light tasks)
Saturday-Sunday:  4-5 hours each (projects)
Weekly Total:     13-20 hours
Completion:       8-9 months
```

**Option B - Full-Time Student (Consistent Daily)**
```
Monday-Sunday:    3-4 hours daily
Weekly Total:     21-28 hours
Completion:       6-7 months (accelerated)
```

**Option C - Part-Time Learner (Flexible)**
```
Some days:        Skip or 1 hour (light tasks)
Other days:       3-5 hours (catch up + projects)
Weekly Total:     12-18 hours
Completion:       9-12 months
```

**Learning Progression:**
```
Months 1-3:     Programming Fundamentals (85 tasks)
Month 3-4:      Web Development Foundations (32 tasks)
Month 4-5:      Frontend Fundamentals (21 tasks)
Month 5-6:      Frontend Framework - React (23 tasks)
Month 6-7:      Backend Development - Laravel (25 tasks)
Month 7-8:      Full Stack Integration (20 tasks)
Month 8:        Advanced Topics & Best Practices (21 tasks)
Month 8-9:      Senior Level Skills (24 tasks)
```

**Note on Learning Philosophy (Updated 2026-01-20):**
- **Flexible time commitment** - Tasks vary from 1-4 hours based on complexity
- **Real-world preparation** - Projects designed as cohesive units like real development work
- **Natural learning flow** - No artificial splitting of well-designed tasks
- **Sustainable pace** - Adapt daily hours to your schedule and energy
- **Quality over quotas** - Focus on deep understanding, not rigid daily limits
- **Honest timeline** - 8-9 months with realistic time commitments (not artificial constraints)
- Tasks include: 🟢 Light (60-90min) | 🟡 Moderate (90-180min) | 🔴 Projects (180-300min)

---

## Programming Fundamentals Roadmap (Detailed Breakdown)

**Purpose**: This roadmap builds the foundation for thinking like a programmer. It covers core concepts that apply to all programming languages and technologies.

**Prerequisites**: None - designed for absolute beginners

**What You'll Learn**:
- How to break down problems logically
- Computational thinking fundamentals
- Working effectively with AI development tools
- Core programming concepts (variables, loops, functions)
- Essential data structures and algorithms
- Object-oriented programming principles
- Systematic debugging approaches
- Code quality and review practices
- Overview of systems, networks, and databases

**Roadmap Structure**:

### Part 1: Mindset & Problem Solving (Days 1-25)
**Focus**: Develop programming thinking before writing code

**Stages Covered**:
- Programming Mindset Basics (Days 1-15)
  - Problem decomposition and logical thinking
  - Computational thinking fundamentals
  - Algorithm design with pseudocode
  - Flowchart creation
  - Real-world problem solving exercises

- Working with AI Tools (Days 16-25)
  - AI-assisted development workflow
  - Prompt engineering basics
  - When to use (and not use) AI
  - Code review of AI-generated solutions
  - AI vs manual problem solving comparison

**Key Outcomes**:
- Think algorithmically
- Break complex problems into steps
- Use AI tools effectively
- Understand limitations of automation

---

### Part 2: Programming Foundations (Days 26-55)
**Focus**: Learn core programming concepts that work across all languages

**Stages Covered**:
- Languages as Tools (Days 26-40)
  - Programming language overview
  - Variables, data types, operators
  - Conditionals and loops
  - Functions and scope
  - Practical exercises and projects

- Data Structures (Days 41-55)
  - Arrays and lists
  - Strings and manipulation
  - Objects and key-value structures
  - Algorithm basics (searching, sorting)
  - Time/space complexity introduction
  - Data structure practice exercises

**Key Outcomes**:
- Understand language syntax patterns
- Work with fundamental data structures
- Choose appropriate data structures
- Implement basic algorithms

---

### Part 3: Advanced Concepts (Days 56-90)
**Focus**: Object-oriented design and professional practices

**Stages Covered**:
- Object-Oriented Programming (Days 56-70)
  - Classes and objects
  - Encapsulation principles
  - Inheritance and polymorphism
  - Designing class hierarchies
  - OOP design patterns
  - Practical OOP projects

- Debugging (Days 71-80)
  - Error types and messages
  - Systematic debugging strategies
  - Using debugging tools
  - Finding logic errors
  - Advanced debugging techniques

- Code Review & Tools (Days 81-90)
  - Code quality principles
  - Refactoring techniques
  - Peer review process
  - Development tools (IDEs, version control)
  - Best practices and standards

**Key Outcomes**:
- Design with objects and classes
- Debug systematically
- Write clean, reviewable code
- Use professional tools

---

### Part 4: Systems Overview (Days 91-115)
**Focus**: Understanding the broader software ecosystem

**Stages Covered**:
- Networks and Systems (Days 91-100)
  - How the internet works
  - Client-server architecture
  - APIs and HTTP
  - Network protocols and communication

- DevOps and Servers (Days 101-105)
  - Server basics
  - Deployment concepts
  - Cloud computing introduction

- Databases (Days 106-110)
  - Database fundamentals
  - SQL vs NoSQL overview
  - Database design basics

- Integration (Days 111-115)
  - System design thinking
  - Connecting all concepts
  - Final capstone project

**Key Outcomes**:
- Understand full-stack architecture
- Know how systems communicate
- Grasp deployment basics
- Think about system design

---

### Task Distribution
- **Total Tasks**: 115 tasks across 115 days
- **Reading Tasks**: Foundational theory
- **Exercise Tasks**: Hands-on practice
- **Project Tasks**: Integration projects
- **Code Submission**: Required for most practical tasks

### Estimated Time Investment
- **Daily**: 1.7-2 hours of focused learning (max 120 minutes)
- **Total**: ~185 hours across 115 days
- **Pace**: Consistent daily progress with manageable workload

### Recommended Resources
All tasks include curated resources from:
- CS50 (Harvard's Introduction to Computer Science)
- freeCodeCamp
- MDN Web Docs (for web concepts)
- Official language documentation
- Programming problem platforms (LeetCode easy, HackerRank)

### After This Roadmap
Upon completion, you'll be ready to:
1. Start "Web Development Foundations" with strong fundamentals
2. Learn any programming language more easily
3. Approach problems systematically
4. Write clean, debuggable code
5. Understand how software systems work

---

## Database Structure

### Core Models & Relationships

**User**
- Roles: `student`, `instructor`, `admin`
- Tracks: `current_streak`, `longest_streak`, `last_activity_date`
- Relations: `enrollments`, `taskCompletions`, `codeSubmissions`, `codeReviews`, `notes`

**Roadmap**
- Learning path templates created by admins
- Fields: `title`, `description`, `duration_days`, `difficulty_level`, `is_published`, `is_featured`, `order`
- Supports: `prerequisite_roadmap_id` for learning progression
- Relations: `creator` (User), `tasks`, `enrollments`, `notes`

**Task**
- Individual learning activities within a roadmap
- Fields: `day_number`, `order`, `estimated_time_minutes`, `task_type`, `category`
- Types: `reading`, `video`, `exercise`, `project`, `quiz`
- Configuration: `has_code_submission`, `has_quality_rating`, `resources_links` (JSON)
- Relations: `roadmap`, `taskCompletions`, `notes`
- **Important**: `day_number` is curriculum-specific per roadmap
  - Each roadmap has its own day numbering (1 to `duration_days`)
  - Different roadmaps show different day ranges based on their duration
  - Multiple tasks can be assigned to the same day number
  - Tasks are grouped and displayed by `day_number` in the roadmap view
  - Example: Roadmap with 30 days shows Days 1-30, while 60-day roadmap shows Days 1-60

**RoadmapEnrollment**
- Tracks student enrollment in a roadmap
- Fields: `started_at`, `completed_at`, `current_day`, `status`
- Status: `active`, `paused`, `completed`, `abandoned`
- Relations: `roadmap`, `student`, `taskCompletions`

**TaskCompletion**
- Individual task progress tracking
- Fields: `status`, `started_at`, `completed_at`, `time_spent_minutes`, `quality_rating` (1-10), `self_notes`
- Status: `pending`, `in_progress`, `completed`, `skipped`
- Unique constraint: `(task_id, student_id, enrollment_id)`
- Relations: `task`, `student`, `roadmapEnrollment`, `codeSubmissions`

**CodeSubmission**
- Code file/project submissions
- Fields: `file_path`, `original_filename`, `submission_notes`, `language`, `submission_status`
- Status flow: `submitted` → `approved` | `needs_revision`
- File storage: Local disk in `storage/app/code-submissions/{student_id}/`
- Relations: `taskCompletion`, `student`, `codeReviews`

**CodeReview**
- Instructor feedback on code
- Fields: `feedback`, `rating` (1-10), `status`, `reviewed_at`
- Status: `approved`, `needs_revision`
- Relations: `codeSubmission`, `reviewer` (instructor/admin)

**Note**
- Study notes created by students
- Fields: `title`, `content`, `tags` (JSON), `is_favorite`
- Can attach to: specific task, roadmap, or standalone
- Relations: `user`, `task`, `roadmap`

**WeeklyReview & MonthlyReview**
- Reflection entries for self-assessment
- Track: what learned, applied to code, areas for improvement, goals
- Relations: `student`, `roadmapEnrollment`

---

## User Roles & Workflows

### Student Workflow

**1. Registration & Discovery**
- Register with email (default role: student)
- Browse published roadmaps with search/filter
- View detailed curriculum before enrolling
- Enroll in chosen roadmap (creates `RoadmapEnrollment`)

**2. Daily Learning**
- View tasks for current day at `/student/tasks`
- Navigate between days (Day 1, Day 2, etc.)
- Task information: type, category, estimated time, resources, status
- Status colors: white (not started), blue (in progress), green (completed), gray (skipped)

**3. Task Actions**
- **Start/Continue**: Opens modal to log time and add notes
- **Complete**: Mark done, rate quality (1-10), log time spent
- **Skip**: Skip with optional notes
- **💻 Submit** (for coding tasks): Opens file upload interface for code submission

**4. Code Submission**
- Click "💻 Submit" on tasks with "Code Submission Required" badge
- Choose between single file upload or ZIP project upload
- Supported formats: HTML, CSS, JS, Python, Java, PHP, and more
- Add optional notes for instructor
- Click "Submit File" or "Submit ZIP" to upload and submit in one action
- Task automatically marked as completed upon submission
- Download your submission anytime
- View instructor feedback and ratings
- Delete and resubmit if revision needed

**Important**: Tasks requiring code submission show:
- Orange badge: "Code Submission Required - Use Submit Button"
- Disabled "Complete" button until code is submitted
- Green badge: "✓ Code Submitted" after successful upload
- Enabled "Complete" button after submission

**5. Progress Tracking**
- Dashboard: streak, tasks completed today, overall progress, time spent
- Progress page: completion percentage, category breakdown, day-wise progress
- System automatically advances to next day when day's tasks are completed

**6. Reflection**
- Add notes when completing tasks
- Fill weekly review forms (what learned, applied, focus areas)
- Fill monthly review forms (goals, progress comparison, readiness)

**Key Routes:**
- `/student/dashboard` - Overview and stats
- `/student/roadmaps` - Browse and enroll
- `/student/tasks` - Daily task interface
- `/student/code-editor/{taskId}` - File upload and code submission
- `/student/progress` - Visual progress tracking

---

### Instructor Workflow

**1. Code Review Queue** (`/instructor/code-review`)
- View all code submissions with filters:
  - By status: ⏳ Awaiting Review (default), ✅ Approved, 📝 Needs Revision, All Status
  - By language: JavaScript, Python, HTML, etc.
  - Search by student name
- Default view shows only "submitted" (new) submissions
- Click "Review" to open submission modal:
  - View submitted filename and submission date
  - Read student's optional notes
  - **Download File** button to review code locally
  - Provide detailed feedback (required)
  - Assign rating 1-10 (slider, required)
  - Make decision: ✅ Approve or 📝 Request Revision
- Submit review (updates submission status and removes from default queue)
- Reviewed submissions move to "Approved" or "Needs Revision" filters

**2. Student Progress Monitoring** (`/instructor/student-progress`)
- View all student enrollments
- Filter by roadmap, status, or search student
- Click "View Progress" for detailed modal:
  - Overall stats (tasks done, days completed, percentage)
  - Category breakdown (HTML: 12/15 tasks, etc.)
  - 30-day completion trend chart
  - Time spent by category chart
- Identify struggling students and reach out

**Best Practices:**
- Provide constructive, encouraging feedback
- Highlight what's done well AND suggest improvements
- Reference specific code lines in feedback
- Respond within 24-48 hours when possible

---

### Admin Workflow

**1. Roadmap Management** (`/admin/roadmaps`)

**Create New Roadmap:**
- Click "Create New Roadmap"
- Fill form: title, description, duration_days, difficulty_level
- Optional: featured flag, image upload, order number, prerequisite
- Save as unpublished draft
- Add tasks before publishing

**Manage Roadmaps:**
- Search by title/description
- Filter by published status, difficulty
- Actions:
  - Edit: modify any field
  - Toggle publish/unpublish (validates has tasks)
  - Duplicate: copy roadmap + all tasks
  - Delete: with confirmation

**2. Task Management** (`/admin/roadmaps/{id}/tasks`)

**Create Task:**
- Click "Create New Task"
- Fill form:
  - Title, description (required)
  - Day number (which day of roadmap)
  - Task type: reading, video, exercise, project, quiz
  - Category: HTML, CSS, JavaScript, etc.
  - Estimated time (minutes)
  - Order (auto-filled)
  - Checkboxes: has_code_submission, has_quality_rating
- Add resource links (URLs for external materials)
  - **Video Resource Guidelines**: Currently only 8 tasks (4.8%) have YouTube videos
  - Recommended: Add 1-2 quality videos for complex topics (React hooks, async/await, etc.)
  - Keep videos concise (10-20 min) to preserve timeline
  - Priority topics for videos: New concepts, visual topics (CSS, UI), complex patterns
  - Resources auto-sort: Videos appear first with 🎥 icon
- Save

**Manage Tasks:**
- Filter by day, type, or category
- Edit: modify any field
- Move Up/Down: reorder within day
- Duplicate: copy to same day
- Delete: with confirmation

**3. User Management** (`/admin/users`)

**Create User:**
- Form: name, email, password, role
- Roles: student, instructor, admin
- User can log in immediately

**Manage Users:**
- Search by name/email
- Filter by role
- View stats: enrollments, tasks completed, time spent, streaks
- Edit: change details or role (cannot change own role)
- Delete: with confirmation (cannot delete self)

---

## Core Features

### 1. Learning Path System

**Progressive Roadmaps:**
- 8 roadmaps ordered from beginner to advanced
- Total 251 real-world tasks with curated learning resources
- Each roadmap has prerequisite (except first)
- Featured roadmap marking (⭐ Start Here)
- Flexible time commitment per task (1-4 hours)
- Tasks designed as cohesive learning units
- Natural progression from concepts to projects

**Search & Browse:**
- Search by title or description
- Filter by difficulty level
- See enrollment status on cards
- View complete curriculum before enrolling

### 2. Task Management

**Task Types:**
- 📚 Reading - Articles, documentation
- 🎥 Video - Video tutorials
- 💻 Exercise - Code practice
- 🚀 Project - Build something
- 📝 Quiz - Knowledge check

**Task Properties:**
- Estimated time in minutes
- Category (HTML, CSS, JavaScript, etc.)
- Order within day
- Resource links (external materials with smart display)
- Code submission requirement flag
- Quality rating requirement flag

**Learning Resources (Enhanced 2026-01-19):**
- Resources are automatically categorized and displayed with icons:
  - 🎥 **Video** (YouTube) - Shown first in red
  - 🔧 **Demo/Tool** (CodePen, JSFiddle, CodeSandbox) - Shown second in green
  - 💻 **Code** (GitHub repositories) - Shown third in gray
  - 📖 **Article** (Documentation, tutorials) - Shown last in blue
- Resources are automatically sorted by priority (videos → demos → code → articles)
- Each resource link includes an external link icon
- Current stats: 137 tasks with resources (82%), 199 total resources, ~1.5 resources per task

### 3. Progress Tracking

**Student Dashboard:**
- Current streak (consecutive active days)
- Tasks completed today
- Overall progress percentage
- Active roadmap with quick links
- Total time spent learning
- Task statistics breakdown

**Enrollment Tracking:**
- Current day number (auto-advances)
- Days completed / total days
- Tasks completed / total tasks
- Completion percentage
- Status (active/paused/completed)
- Started and completed timestamps

**Task-Level Tracking:**
- Status: not_started → in_progress → completed/skipped
- Time tracking (estimated vs actual)
- Quality self-rating (1-10)
- Personal notes/reflections
- Started and completed timestamps

**Progress Visualization:**
- Overall completion percentage
- Category-wise progress (HTML: 80%, CSS: 60%)
- Day-wise completion status
- 30-day activity trends (for instructors)
- Time allocation by category

### 4. Code Submission System

**File Upload System:**
- Upload single files (HTML, CSS, JS, Python, Java, PHP, C++, C#, Ruby, Go, Rust, TypeScript, etc.)
- Upload ZIP files for multi-file projects (max 50MB)
- Add optional notes for instructor when submitting
- Download submitted files anytime
- Delete and resubmit if needed
- View submission status (submitted, approved, needs_revision)

**Supported File Types:**
- **Single Files**: .html, .css, .js, .py, .java, .php, .cpp, .cs, .rb, .go, .rs, .ts, .txt, .json, .xml, .md (max 10MB)
- **Projects**: .zip archives (max 50MB)

**Code Submission Requirements:**
- Tasks marked with "Code Submission Required" badge must have code submitted before completion
- Complete button is **disabled** until code is submitted
- Visual feedback: Orange badge (pending) → Green badge (submitted)
- Backend validation prevents completion without submission

**Code Review Workflow:**
1. Student writes code in VS Code locally and tests it
2. Click "💻 Submit" button on task requiring code
3. Upload file or ZIP project
4. Add optional notes for instructor
5. Click "Submit File" or "Submit ZIP" (uploads and marks as submitted in one step)
6. Task status automatically changes to "completed"
7. Instructor downloads and reviews the code
8. Instructor provides feedback and rating (1-10)
9. Status set: approved | needs_revision
10. Student sees feedback and can resubmit if needed

**Instructor Review Features:**
- Filter submissions by status: submitted (new), approved, needs_revision
- Filter by programming language
- Search by student name
- Download submitted files for local review
- Provide detailed feedback with ratings
- Two-decision system: Approve or Request Revision
- Reviewed submissions automatically removed from default queue

### 5. Reflection System

**Weekly Reviews:**
- What did you learn this week?
- What did you apply to your code?
- What will you focus on next week?
- Code quality self-rating
- Areas for improvement

**Monthly Reviews:**
- Goals completed this month
- Code quality comparison (start vs end)
- Topics needing more practice
- Readiness assessment for next level

**Study Notes:**
- Create notes while learning
- Attach to specific task or roadmap
- Tag system for organization
- Favorite important notes
- Full-text content storage

### 6. Streak System

**Tracking:**
- Current streak (consecutive active days)
- Longest streak (personal record)
- Last activity date (for calculation)
- Automatic update on task completion

**Visual Indicators:**
- 🔥 emoji for active streaks
- Dashboard prominence
- Motivation for daily engagement

---

## Technology Stack

### Backend
- **Framework**: Laravel 11
- **Database**: MySQL/PostgreSQL
- **ORM**: Eloquent with relationships
- **Authentication**: Laravel Breeze
- **Authorization**: Custom RoleMiddleware

### Frontend
- **UI Framework**: Livewire 3 (full-page components)
- **CSS**: Tailwind CSS 3
- **JavaScript**: Alpine.js 3 (included with Livewire)
- **Code Editor**: Monaco Editor (CDN)
- **Build Tool**: Vite

### Architecture
- **Pattern**: MVC with Service Layer
- **Services**: ProgressService, RoadmapService
- **Middleware**: Role-based access control
- **Storage**: Local disk for roadmap images
- **Sessions**: Database-backed sessions

### Key Dependencies
```json
{
  "php": "^8.2",
  "laravel/framework": "^11.0",
  "livewire/livewire": "^3.0",
  "tailwindcss": "^3.1",
  "alpinejs": "^3.4",
  "monaco-editor": "^0.45.0"
}
```

---

## Development Guide

### Project Structure

```
app/
├── Models/              # 9 Eloquent models
│   ├── User.php
│   ├── Roadmap.php
│   ├── Task.php
│   ├── RoadmapEnrollment.php
│   ├── TaskCompletion.php
│   ├── CodeSubmission.php
│   ├── CodeReview.php
│   ├── Note.php
│   ├── WeeklyReview.php
│   └── MonthlyReview.php
├── Livewire/
│   ├── Admin/           # 3 components
│   │   ├── RoadmapBuilder.php
│   │   ├── TaskBuilder.php
│   │   └── UserManagement.php
│   ├── Instructor/      # 2 components
│   │   ├── CodeReviewQueue.php
│   │   └── StudentProgress.php
│   └── Student/         # 5 components
│       ├── Dashboard.php
│       ├── RoadmapsList.php
│       ├── RoadmapView.php
│       ├── TaskList.php
│       ├── CodeEditor.php
│       └── ProgressTracker.php
├── Services/            # Business logic
│   ├── ProgressService.php
│   └── RoadmapService.php
└── Http/
    └── Middleware/
        └── RoleMiddleware.php

database/
├── migrations/          # 13 migration files
└── seeders/
    └── FullStackRoadmapSeeder.php  # 8 roadmaps, 251 tasks

resources/
├── views/
│   ├── livewire/       # Blade views for components
│   └── layouts/
│       ├── app.blade.php
│       └── navigation.blade.php
├── js/
│   ├── app.js          # Alpine removed (Livewire includes it)
│   └── bootstrap.js
└── css/
    └── app.css         # Tailwind CSS

routes/
└── web.php             # All route definitions
```

### Common Commands

```bash
# Development
npm run dev              # Watch and compile assets
php artisan serve        # Start development server

# Production
npm run build            # Build optimized assets

# Database
php artisan migrate              # Run migrations
php artisan migrate:fresh        # Reset database
php artisan db:seed              # Seed data
php artisan migrate:fresh --seed # Reset and seed

# Cache
php artisan cache:clear   # Clear application cache
php artisan view:clear    # Clear compiled views
php artisan config:clear  # Clear config cache
php artisan route:clear   # Clear route cache

# Tinker (Laravel REPL)
php artisan tinker        # Interactive shell

# Queue (if using)
php artisan queue:work    # Process queued jobs
```

### Adding a New Feature

**Example: Adding a "Favorites" System**

1. **Create Migration:**
```bash
php artisan make:migration create_favorites_table
```

2. **Create Model:**
```bash
php artisan make:model Favorite
```

3. **Create Livewire Component:**
```bash
php artisan make:livewire Student/Favorites
```

4. **Add Route:**
```php
// routes/web.php
Route::get('/favorites', App\Livewire\Student\Favorites::class)->name('favorites');
```

5. **Add Navigation Link:**
```php
// resources/views/layouts/navigation.blade.php
<x-nav-link :href="route('student.favorites')">
    Favorites
</x-nav-link>
```

### Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/RoadmapTest.php

# Run with coverage
php artisan test --coverage
```

### Deployment Checklist

- [ ] Set `APP_ENV=production` in .env
- [ ] Set `APP_DEBUG=false` in .env
- [ ] Generate new `APP_KEY`
- [ ] Configure production database
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `npm run build`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set up proper file permissions
- [ ] Configure queue worker (if using)
- [ ] Set up scheduled tasks (if needed)
- [ ] Configure SSL certificate
- [ ] Set up backups

---

## Recommended Enhancements

Below are 25 enhancements organized by priority to evolve this MVP into a comprehensive learning platform.

### High Priority (Core Learning Experience)

#### 1. Interactive Quizzes & Assessments
**What**: Built-in quiz system with various question types
- Multiple choice, true/false, coding challenges
- Immediate feedback on answers with explanations
- Score tracking and retake ability
- Certificate generation on roadmap completion
- Required minimum score to advance

**Why**: Validates learning, provides credential, increases completion rates
**Effort**: Medium | **Impact**: High

#### 2. Video Lessons Integration
**What**: Embedded video player with interactive features
- Watch videos directly in platform (no leaving site)
- Bookmarks at key moments
- Note-taking sidebar while watching
- Playback speed control
- Transcript with timestamps
- Track watch progress

**Why**: Unified experience, better engagement, reduced friction
**Effort**: Medium | **Impact**: High

#### 3. AI Code Assistant
**What**: Integrated AI help within code editor
- Code suggestions and auto-completion
- Error explanation and debugging help
- Best practice recommendations
- "Ask AI" button for questions about code
- Hint system without giving full answer

**Why**: Faster learning, immediate help, reduced frustration, 24/7 availability
**Effort**: Medium (API integration) | **Impact**: Very High
**Tech**: OpenAI API, Claude API, or GitHub Copilot

#### 4. Progress Analytics Dashboard
**What**: Advanced visualizations and insights
- Line charts: progress over time
- Heat maps: activity patterns (most productive days/times)
- Comparison: you vs cohort average
- Predictions: estimated completion date
- Weekly/monthly email reports
- Export progress as PDF

**Why**: Better self-awareness, goal setting, motivation through data
**Effort**: Medium | **Impact**: High
**Tech**: Chart.js or ApexCharts

#### 5. Code Playground with Execution
**What**: Run code directly in browser without setup
- Execute code for supported languages
- Console output display
- File system simulation
- API testing environment
- Share executable code snippets

**Why**: Instant feedback, zero setup friction, experimentation encouraged
**Effort**: High | **Impact**: Very High
**Tech**: Judge0 API, Repl.it API, or Docker containers

---

### Medium Priority (Engagement & Social)

#### 6. Discussion Forums
**What**: Community discussion per roadmap/task
- Q&A threads
- Code snippet sharing with formatting
- Upvote/downvote system
- Mark best answer
- Tag system (#html, #javascript)
- Notifications on replies
- Moderator tools

**Why**: Community building, peer support, reduced instructor load
**Effort**: High | **Impact**: High
**Tech**: Custom forum or integrate Discourse

#### 7. Study Groups
**What**: Form small learning cohorts
- Create or join study groups (max 5-10 students)
- Group chat
- Shared progress tracking
- Group challenges and competitions
- Scheduled study sessions with reminders

**Why**: Accountability, social learning, reduce isolation, higher completion
**Effort**: Medium | **Impact**: High

#### 8. Leaderboards & Competitions
**What**: Friendly competition elements
- Daily/weekly/monthly leaderboards
- Points for: tasks done, code quality, helping others
- Timed coding challenges
- Team competitions
- Seasonal events (Summer Challenge, 100 Days of Code)

**Why**: Gamification, engagement, fun factor
**Effort**: Medium | **Impact**: Medium
**Tech**: Redis for real-time rankings

#### 9. Mentor Matching System
**What**: Connect students with experienced mentors
- Profile matching based on: experience, goals, availability, interests
- Book 1-on-1 sessions
- Video call integration
- Session notes and action items
- Rating system for mentors

**Why**: Personalized guidance, career advice, networking
**Effort**: High | **Impact**: High
**Tech**: Scheduling system, Zoom/Google Meet API

#### 10. Resource Library
**What**: Centralized learning resource hub
- Curated articles, tools, cheat sheets
- Tagging and categorization
- Bookmark favorites
- User-submitted resources (admin-moderated)
- Search and advanced filters

**Why**: Easy reference, supplemental learning, time-saving
**Effort**: Low | **Impact**: Medium

---

### Advanced Features (Scale & Optimization)

#### 11. Mobile App
**What**: Native iOS/Android apps
- All core features accessible
- Offline mode for reading materials
- Push notifications for streaks, reviews, deadlines
- Mobile-optimized code editor
- Download lessons for offline study

**Why**: Learn anywhere, higher engagement, modern expectation
**Effort**: Very High | **Impact**: High
**Tech**: React Native or Flutter

#### 12. Custom Learning Paths
**What**: Students create their own roadmaps
- Mix and match tasks from different roadmaps
- Set personal pace and order
- Share custom paths with community
- Fork and modify existing paths
- Marketplace of user-created paths

**Why**: Personalization, autonomy, flexibility, unique needs
**Effort**: High | **Impact**: Medium

#### 13. Smart Recommendations
**What**: AI-powered personalized suggestions
- Suggest next roadmap based on progress and interests
- Recommend resources based on struggle areas
- Task difficulty adjustment (if student consistently fast/slow)
- Learning style detection (visual, hands-on, reading)
- Career path suggestions

**Why**: Personalization, better outcomes, reduced decision fatigue
**Effort**: Very High | **Impact**: High
**Tech**: Machine learning models, recommendation engine

#### 14. Certification System
**What**: Official certificates on completion
- Verifiable digital credentials with unique ID
- LinkedIn integration
- Portfolio showcase page
- Skill badges for specific topics
- Transcript export with all completed work

**Why**: Career value, motivation, credibility, portfolio building
**Effort**: Medium | **Impact**: High
**Tech**: PDF generation, blockchain verification (optional)

#### 15. White-Label Solution
**What**: Allow organizations to rebrand platform
- Custom branding (logo, colors, domain)
- SSO integration (SAML, OAuth)
- Team management dashboard
- Custom roadmaps for company needs
- Usage analytics for admins

**Why**: Enterprise sales opportunity, B2B revenue
**Effort**: Very High | **Impact**: High (if targeting B2B)

---

### Quality of Life Improvements

#### 16. Dark Mode (Full Site)
**Status**: Currently only in code editor
**Enhancement**: Site-wide dark mode
- User preference saved to database
- Smooth transition animation
- Accessible color contrast (WCAG compliant)
- Respects system preference by default

**Why**: Reduced eye strain, modern UX expectation
**Effort**: Low | **Impact**: Medium

#### 17. Keyboard Shortcuts
**What**: Power user keyboard navigation
- Global: quick search (Ctrl+K), dashboard (Ctrl+D)
- Task page: next task (n), previous (p), start (s), complete (c)
- Code editor: run code (Ctrl+Enter), format (Ctrl+Shift+F)
- Customizable shortcuts panel

**Why**: Efficiency for power users, professional feel
**Effort**: Low | **Impact**: Low

#### 18. Enhanced Notifications
**What**: Comprehensive notification system
- In-app notification center
- Email digests (daily/weekly, user choice)
- Browser push notifications
- Notification preferences panel
- Types: streak reminder, code reviewed, milestone reached

**Why**: Engagement, timely information, re-engagement
**Effort**: Medium | **Impact**: Medium

#### 19. Export & Backup
**What**: Data portability features
- Export all notes as markdown zip
- Export code submissions as zip
- Export progress report as PDF
- Backup entire learning history as JSON
- GDPR compliance (data download request)

**Why**: Data ownership, portfolio building, compliance
**Effort**: Low | **Impact**: Low

#### 20. Accessibility Features
**What**: WCAG 2.1 AA compliance
- Screen reader optimization
- Full keyboard navigation
- High contrast mode
- Adjustable font size across site
- Alt text for all images
- Focus indicators
- Skip navigation links

**Why**: Inclusive, legal compliance, broader audience
**Effort**: Medium | **Impact**: Medium

---

### Monetization & Business (If Commercial)

#### 21. Subscription Tiers
- **Free**: 1 roadmap, limited code review (2/month), no certificates
- **Pro** ($19/month): All roadmaps, unlimited reviews, certificates, priority support
- **Enterprise**: Teams, custom roadmaps, analytics, SSO, bulk pricing

**Effort**: Medium | **Impact**: High (revenue)
**Tech**: Laravel Cashier + Stripe

#### 22. Course Marketplace
- Allow verified instructors to create and sell custom courses
- Revenue sharing model (70/30 split)
- Rating and review system
- Preview lessons before purchase
- Admin approval process

**Effort**: Very High | **Impact**: High (revenue)

#### 23. Affiliate Program
- Students refer friends, earn credits or commission
- Instructors get recurring commission for students they bring
- Tracking dashboard
- Payout system

**Effort**: Medium | **Impact**: Medium

---

### Technical Improvements

#### 24. API Development
- RESTful API for mobile apps and integrations
- GraphQL endpoint for flexible queries
- API documentation (Swagger/OpenAPI)
- Rate limiting and API keys
- Webhooks for integrations

**Effort**: High | **Impact**: Medium (enables ecosystem)
**Tech**: Laravel API Resources, Laravel Sanctum

#### 25. Performance Optimization
- Redis caching for leaderboards and stats
- Database query optimization (eager loading)
- Image optimization (lazy loading, WebP)
- CDN for static assets
- Background job processing (Laravel Horizon)
- Database indexing review

**Effort**: Medium | **Impact**: Medium
**Tech**: Redis, Laravel Horizon, CloudFlare

---

## Development Roadmap Suggestion

If implementing enhancements, here's a recommended priority order:

### Phase 1: Core Learning (Weeks 1-4)
1. Interactive Quizzes
2. Progress Analytics Dashboard
3. Video Integration
**Goal**: Validate learning, improve engagement

### Phase 2: Community (Weeks 5-8)
4. Discussion Forums
5. Enhanced Notifications
6. Study Groups
**Goal**: Build community, reduce isolation

### Phase 3: Advanced Learning (Weeks 9-12)
7. AI Code Assistant
8. Code Playground
9. Smart Recommendations
**Goal**: Differentiate product, increase value

### Phase 4: Scale (Months 4-6)
10. Mobile App
11. API Development
12. Performance Optimization
13. Certification System
**Goal**: Prepare for growth, enable ecosystem

### Phase 5: Business (Months 6+)
14. Subscription Tiers
15. White-Label Solution
16. Course Marketplace
**Goal**: Monetization, sustainability

---

## Support & Troubleshooting

### Common Issues

**Livewire not responding:**
- Check browser console for errors
- Verify `@livewireScripts` is in `layouts/app.blade.php`
- Clear cache: `php artisan view:clear`

**Code editor not loading:**
- Monaco CDN must be accessible (check internet connection)
- Check browser console for 404 errors on Monaco files

**Session expired:**
- Increase session lifetime in `config/session.php`
- Check database sessions table exists

**Task buttons not working:**
- Ensure Livewire is loaded (no duplicate Alpine.js)
- Check browser console for JavaScript errors

**Different roadmaps showing different day numbers:**
- This is expected behavior, not a bug
- Each roadmap has its own task distribution across days based on its curriculum design
- Tasks are grouped by `day_number` field in the database
- Different roadmaps may:
  - Have multiple tasks on the same day (e.g., Day 1 might have 2-3 tasks)
  - Distribute tasks differently based on learning objectives and complexity
- Example: "Web Development Foundations" (30 days) will show Days 1-30 with varying tasks per day
- Example: "Frontend Framework - React" (30 days) will show Days 1-30 with its own distribution
- The day numbers are curriculum-specific and designed to match the roadmap's duration and pacing
- To verify task distribution: Check `database/seeders/FullStackRoadmapSeeder.php` for each roadmap's task assignments
- Location: `app/Livewire/Student/RoadmapView.php:68` - tasks are grouped using `groupBy('day_number')`

**Learning Philosophy Update (2026-01-20):**
- **Flexible Approach Adopted**: After analysis, chose realistic over artificial constraints
  - Maintained natural task flow (251 tasks as designed)
  - Honest timeline: 8-9 months with variable daily commitment
  - No artificial splitting of cohesive learning units

- **Current Structure**:
  - **Programming Fundamentals**: 85 tasks (varied complexity)
  - **Web Foundations**: 32 tasks (HTML, CSS, Git)
  - **Frontend Fundamentals**: 21 tasks (JavaScript, DOM)
  - **React**: 23 tasks (Hooks, state, projects)
  - **Laravel**: 25 tasks (PHP, backend, APIs)
  - **Full Stack**: 20 tasks (Integration projects)
  - **Advanced Topics**: 21 tasks (Testing, deployment)
  - **Senior Skills**: 24 tasks (Architecture, leadership)

- **Learning Benefits**:
  - **Real-world preparation**: Tasks mirror actual development work
  - **Deep work sessions**: Build stamina for professional projects
  - **Flexible scheduling**: Adapt to personal life and energy levels
  - **Faster completion**: 8-9 months vs forced longer timeline
  - **Natural flow**: No context switching between artificial parts

- **Time Commitment Reality**:
  - 🟢 Light tasks: 60-90 minutes (reading, simple exercises)
  - 🟡 Moderate tasks: 90-180 minutes (practice, coding)
  - 🔴 Project tasks: 180-300 minutes (building applications)
  - Average: 2-3 hours daily (flexible weekday/weekend split)

### Database Maintenance

```bash
# Backup database
mysqldump -u root -p roadmap > backup_$(date +%Y%m%d).sql

# Restore database
mysql -u root -p roadmap < backup_20260119.sql

# Optimize tables
php artisan db:optimize
```

### Performance Tips

- Enable query caching for frequently accessed data
- Compress uploaded images before storage
- Use eager loading to avoid N+1 queries
- Index foreign keys and frequently queried columns
- Clear old session data periodically

---

## License & Credits

**License**: Open-source (specify license as needed)

**Built With:**
- Laravel 11 - PHP framework
- Livewire 3 - Reactive UI components
- Tailwind CSS 3 - Utility-first CSS
- Monaco Editor - VS Code's editor
- Alpine.js 3 - Lightweight JavaScript

**Credits:**
- Learning resources from MDN, freeCodeCamp, Laravel docs, React docs
- Icons: Heroicons (via Tailwind)
- Fonts: Google Fonts

---

## Contact & Support

For questions, issues, or contributions, please contact the project maintainer.

**Current Version**: 2.0 (Flexible Learning Approach)
**Last Updated**: 2026-01-20
**Status**: Production Ready

---

**Note**: This is an MVP (Minimum Viable Product) focused on core learning functionality. Achievements/gamification have been removed for simplicity. Focus is on quality content, code practice, and progress tracking.


## 
                                                                                                                                                                                                    
3 - This video isn't available anymore (some urls)

4 - jobs board

5 - start timer when enroll to send email to student if he do not complete tasks of the day

6 - interviews and cvs journey

7 - reviewers (instructors)

8 - freelaning tasks & projects

9 - students page 

10 - most courses cover this topic free and paid

11 - (free and paid content) Hussein Nasser https://www.youtube.com/@hnasr, https://www.youtube.com/@ArabicCompetitiveProgramming, https://www.youtube.com/@GaryClarkeTech, https://www.youtube.com/@ahmadalfy, https://alfy.blog/, https://www.youtube.com/@CSDojo, https://www.youtube.com/@bigdata4756, https://www.youtube.com/@mahyoussef, https://www.youtube.com/@ahmdelemam, https://www.youtube.com/@alexhyettdev, https://www.youtube.com/@fknight, https://www.youtube.com/@nunomaduro, https://www.youtube.com/@codewithSJM, https://www.youtube.com/@tonyxhepaofficial, https://www.youtube.com/@phpannotated, https://www.youtube.com/@SecTheater, https://www.youtube.com/@firefoxegyweb, https://www.youtube.com/@dr.mohammedabdallayoussif8051, https://www.youtube.com/@LaravelPHP, https://www.youtube.com/@essamcafe, https://www.youtube.com/@ProgrammingAdvices, https://www.youtube.com/@Cloud-Kode, https://www.youtube.com/@LaravelDaily, https://www.youtube.com/@asoli_dev, https://www.youtube.com/@metwallysec, https://www.youtube.com/@janmarshalcoding, https://www.youtube.com/@SuperSimpleDev, https://www.youtube.com/@PassionateCoders, https://www.youtube.com/@codebreakthrough, https://www.youtube.com/@saleem-hadad, https://www.youtube.com/@BecodemyOfficial, https://www.youtube.com/@SimpleArabCode, https://www.youtube.com/@SamehDeabes, https://www.youtube.com/@AmeerGaafar/videos, https://www.youtube.com/@MetwallyLabs, https://www.youtube.com/@glennraya, https://www.youtube.com/@NeetCode, https://www.youtube.com/@ashishps_1, https://www.youtube.com/@ProgramWithGio, https://www.youtube.com/@a0xEid, https://www.youtube.com/@tariqelouzeh, https://www.youtube.com/@dr.ahmedhagag, https://www.youtube.com/@mrkindyCom, https://www.youtube.com/@saaslaravel, https://www.youtube.com/@DavidGrzyb, https://www.youtube.com/@DevoxxForever, https://www.youtube.com/@devgeeksacademy3340, https://www.youtube.com/@Zigoo0/videos, https://www.youtube.com/@tresmerge, https://www.youtube.com/@yallacode_, https://www.youtube.com/@ByteByteGo, https://www.youtube.com/@DrMohammedElSaid, https://www.youtube.com/@AdelNasim, https://www.youtube.com/@TechVault_, https://www.youtube.com/@glich.stream, https://www.youtube.com/@naderelagrody, https://www.youtube.com/@elithecomputerguy, https://www.youtube.com/@TechWorldwithNana, https://www.youtube.com/@SmoothBytes, https://www.youtube.com/@mutawwir, https://www.youtube.com/@TraversyMedia, https://www.youtube.com/@yehiatech, https://www.youtube.com/@DataWithBaraa, https://www.youtube.com/@freecodecamp, https://www.youtube.com/@ramyhakam, https://www.youtube.com/@Magicalbat, https://www.youtube.com/@MissingSemester, https://www.youtube.com/@hayk.simonyan, https://www.youtube.com/@andrewcodesmith, https://www.youtube.com/@GoogleDevelopers, https://www.youtube.com/@unitycoin_original, https://www.youtube.com/@PedroTechnologies, https://www.youtube.com/@OmarAhmedx14

13 - youtube channels (resources), people to follows 

14 - select content lang based on lang level of user

15 - page of comming features

16 - companies page

17 - discussions page


18 - session in week to understand questions 
