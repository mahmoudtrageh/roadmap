<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:setup {--fresh : Run fresh migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup database with all necessary data processing steps';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Starting database setup...');
        $this->newLine();

        // Step 1: Reset database if --fresh flag is provided
        if ($this->option('fresh')) {
            $this->info('📦 Step 1/5: Resetting database with fresh migration and seeding...');
            Artisan::call('migrate:fresh --seed');
            $this->line(Artisan::output());
            $this->info('✅ Database reset complete');
            $this->newLine();
        } else {
            $this->info('⏭️  Skipping database reset (use --fresh flag to reset)');
            $this->newLine();
        }

        // Step 2: Fetch YouTube durations
        $this->info('🎬 Step 2/5: Fetching YouTube video durations...');
        Artisan::call('youtube:fetch-durations');
        $this->line(Artisan::output());
        $this->info('✅ YouTube durations fetched');
        $this->newLine();

        // Step 3: Cap video durations at 120 minutes
        $this->info('⏱️  Step 3/5: Capping video durations at 120 minutes...');
        Artisan::call('tasks:cap-durations');
        $this->line(Artisan::output());
        $this->info('✅ Video durations capped');
        $this->newLine();

        // Step 4: Ensure only 1 video per task
        $this->info('🎯 Step 4/5: Ensuring only 1 video resource per task...');
        Artisan::call('tasks:force-one-video');
        $this->line(Artisan::output());
        $this->info('✅ One video per task enforced');
        $this->newLine();

        // Step 5: Remove conflicting duration field
        $this->info('🧹 Step 5/5: Removing conflicting duration field from resources...');
        Artisan::call('tasks:remove-duration-field');
        $this->line(Artisan::output());
        $this->info('✅ Duration field cleaned up');
        $this->newLine();

        $this->info('🎉 Database setup completed successfully!');
        $this->newLine();

        return Command::SUCCESS;
    }
}
