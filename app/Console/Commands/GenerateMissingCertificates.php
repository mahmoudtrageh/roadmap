<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateMissingCertificates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'certificates:generate-missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate missing certificates for completed roadmap enrollments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Searching for completed enrollments without certificates...');

        $completedEnrollments = \App\Models\RoadmapEnrollment::with(['student', 'roadmap'])
            ->where('status', 'completed')
            ->get();

        $missing = 0;
        $generated = 0;
        $errors = 0;

        foreach ($completedEnrollments as $enrollment) {
            // Check if certificate exists
            $certificateExists = \App\Models\Certificate::where('student_id', $enrollment->student_id)
                ->where('roadmap_id', $enrollment->roadmap_id)
                ->exists();

            if (!$certificateExists) {
                $missing++;
                $this->warn("Missing certificate: {$enrollment->student->name} - {$enrollment->roadmap->title}");

                try {
                    $certificateService = app(\App\Services\CertificateService::class);
                    $certificate = $certificateService->generateCertificate($enrollment->student, $enrollment->roadmap);
                    $this->info("  ✓ Generated certificate: {$certificate->verification_code}");
                    $generated++;
                } catch (\Exception $e) {
                    $this->error("  ✗ Failed: {$e->getMessage()}");
                    $errors++;
                }
            }
        }

        $this->newLine();
        $this->info("Summary:");
        $this->info("  Total completed enrollments: {$completedEnrollments->count()}");
        $this->info("  Missing certificates: {$missing}");
        $this->info("  Successfully generated: {$generated}");
        if ($errors > 0) {
            $this->error("  Errors: {$errors}");
        }

        return 0;
    }
}
