# Roadmap Platform - Commands Reference

Quick reference for all custom Artisan commands created for the platform.

---

## Content Enhancement Commands

### 1. Enhance Task Metadata
```bash
php artisan tasks:enhance-metadata
```

**What it does:**
- Adds learning objectives to all tasks
- Adds skills gained information
- Generates success criteria
- Creates common mistakes warnings
- Adds quick tips
- Sets up prerequisite relationships

**When to use:**
- After creating new tasks in seeders
- When you want to refresh all task metadata
- After major content updates

**Output:** Enhanced 251 tasks with intelligent metadata

---

### 2. Extract Book Recommendations
```bash
php artisan tasks:extract-books
```

**What it does:**
- Scans task descriptions for book recommendations (💡 patterns)
- Extracts book titles, authors, and chapters
- Adds books to resources_links with proper URLs
- Removes book recommendations from descriptions

**When to use:**
- After updating task descriptions with book recommendations
- When cleaning up legacy content

**Example patterns detected:**
- `💡 Book: "Title" - Chapter X`
- `💡 Book recommendation: "Title" by Author`
- `💡 Read "Title"`

**Output:** Books extracted and added to resources

---

### 3. Audit Task Resources
```bash
# Basic audit (fast)
php artisan tasks:audit-resources

# Auto-fix issues
php artisan tasks:audit-resources --fix

# Check link accessibility (slow)
php artisan tasks:audit-resources --check-links

# Combine both
php artisan tasks:audit-resources --fix --check-links
```

**What it does:**
- Analyzes all task resources
- Identifies missing titles
- Flags tasks with insufficient resources
- Generates titles from URLs
- Adds metadata (type, difficulty, time, free/paid)
- Optionally checks if URLs are accessible
- Exports detailed report to JSON

**When to use:**
- Before launch (quality check)
- After bulk content updates
- When adding new resources
- Monthly content health checks

**Report location:** `/storage/app/resource-audit-report.json`

**Metrics provided:**
- Tasks with/without resources
- Resources with/without titles
- Resources with metadata
- Broken links (if --check-links used)

---

## Database Migrations

### Run All Migrations
```bash
php artisan migrate
```

### Rollback Last Migration
```bash
php artisan migrate:rollback
```

### Fresh Database with Seeds
```bash
php artisan migrate:fresh --seed
```

---

## Seeding Data

### Run All Seeders
```bash
php artisan db:seed
```

### Run Specific Seeder
```bash
php artisan db:seed --class=ProgrammingFundamentalsSeeder
php artisan db:seed --class=FullStackRoadmapSeeder
```

---

## Complete Setup Workflow

When setting up from scratch or resetting:

```bash
# 1. Fresh database
php artisan migrate:fresh

# 2. Seed base data
php artisan db:seed --class=UserSeeder

# 3. Seed roadmaps
php artisan db:seed --class=ProgrammingFundamentalsSeeder
php artisan db:seed --class=FullStackRoadmapSeeder

# 4. Enhance tasks (already done in seeders, but can re-run)
php artisan tasks:enhance-metadata

# 5. Extract books (if needed)
php artisan tasks:extract-books

# 6. Audit resources
php artisan tasks:audit-resources --fix

# 7. Start server
php artisan serve
```

---

## Development Commands

### Clear Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Generate Keys
```bash
php artisan key:generate
```

### Create Components
```bash
# Livewire component
php artisan make:livewire Student/ComponentName

# Model
php artisan make:model ModelName -m

# Migration
php artisan make:migration create_table_name

# Command
php artisan make:command CommandName
```

---

## Inspection Commands

### List All Routes
```bash
php artisan route:list
```

### Tinker (Laravel REPL)
```bash
php artisan tinker

# Examples in tinker:
App\Models\Task::count()
App\Models\Task::first()
App\Models\User::where('role', 'student')->get()
```

---

## Custom Commands Created (So Far)

| Command | File | Purpose |
|---------|------|---------|
| `tasks:enhance-metadata` | `app/Console/Commands/EnhanceTaskMetadata.php` | Add learning objectives, tips, criteria to tasks |
| `tasks:extract-books` | `app/Console/Commands/ExtractBookRecommendations.php` | Extract book recommendations from descriptions |
| `tasks:audit-resources` | `app/Console/Commands/AuditTaskResources.php` | Audit and enhance resource quality |

---

## Upcoming Commands (Not Yet Created)

These are planned for Phase 1:

```bash
# Week 1, Day 5
tasks:validate-dependencies  # Check for circular dependencies

# Week 2, Day 1-2
tasks:generate-checklists    # Create step-by-step checklists

# Week 2, Day 3
tasks:generate-quizzes       # Create self-assessment quizzes

# Week 2, Day 4-5
tasks:add-examples           # Add code examples to tasks

# Week 3, Day 1-2
tasks:generate-hints         # Create progressive hints

# Week 4, Day 1
tasks:final-audit            # Complete pre-launch audit
```

---

## Common Workflows

### Adding New Tasks
```bash
# 1. Update seeder file
# 2. Run fresh migration
php artisan migrate:fresh --seed

# 3. Enhance metadata
php artisan tasks:enhance-metadata

# 4. Audit resources
php artisan tasks:audit-resources --fix
```

### Content Quality Check
```bash
# Full audit
php artisan tasks:audit-resources

# Review report
cat storage/app/resource-audit-report.json | jq

# Fix issues
php artisan tasks:audit-resources --fix
```

### Monthly Maintenance
```bash
# Check for broken links
php artisan tasks:audit-resources --check-links

# Refresh metadata
php artisan tasks:enhance-metadata

# Extract any new books
php artisan tasks:extract-books
```

---

## Troubleshooting

### Command Not Found
```bash
# Clear cached commands
php artisan clear-compiled
composer dump-autoload
```

### Migration Errors
```bash
# Check migration status
php artisan migrate:status

# Rollback and retry
php artisan migrate:rollback
php artisan migrate
```

### Slow Performance
```bash
# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Tips & Best Practices

1. **Always backup database** before running commands with `--fix` flag
2. **Run audits without --fix first** to see what will change
3. **Use --check-links sparingly** (it's slow, ~2-5 sec per resource)
4. **Check audit reports** in JSON format for detailed analysis
5. **Run enhance-metadata after seeding** to ensure consistency

---

**Last Updated:** January 21, 2026
**Next Review:** When Phase 1 is complete
