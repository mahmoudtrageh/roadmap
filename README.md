php artisan db:seed --class=TechnicalTermsTranslationSeeder

## 🔄 Refresh Roadmaps Command

To update roadmaps content while preserving all student progress:

```bash
php artisan roadmaps:refresh
```

### What it does:
- ✅ Runs any pending migrations
- ✅ Refreshes all roadmaps and tasks with latest content
- ✅ **Preserves ALL student data:**
  - Student enrollments
  - Task completions
  - Code submissions
  - Student-contributed resources
  - Quiz attempts
  - Notes & questions
  - All progress tracking

### What it DOESN'T delete:
- Student enrollments stay intact
- Task completion history preserved
- Code submissions maintained
- Student resources kept
- Quiz attempts saved
- Notes and questions preserved

Students can continue learning from exactly where they left off!

### Options:
```bash
# Run without confirmation prompt
php artisan roadmaps:refresh --no-interaction
```

## 🏆 Achievement System

Students earn achievements automatically as they progress:
- **Milestones**: Complete 1, 10, 25, 50, 100, 250, 500 tasks
- **Roadmaps**: Complete 1, 3, 5, 10 roadmaps
- **Streaks**: Maintain 3, 7, 14, 30, 60, 100 day learning streaks
- **Time-based**: Spend 10, 50, 100, 500 hours learning
- **Quality**: High-quality work, code contributions, fast learning

View achievements at: `/student/achievements`

## 📚 Student-Contributed Resources

Students can share helpful resources they find:
- Add resources to any task
- Vote on helpful resources
- See resources sorted by helpfulness
- Builds a community knowledge base

