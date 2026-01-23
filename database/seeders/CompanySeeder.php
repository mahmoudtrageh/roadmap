<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if company user already exists
        $companyUser = \App\Models\User::where('email', 'company@roadmap.camp')->first();

        if (!$companyUser) {
            $companyUser = \App\Models\User::create([
                'name' => 'Tech Corp Recruiter',
                'email' => 'company@roadmap.camp',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'company',
                'email_verified_at' => now(),
            ]);
        }

        // Check if company already exists
        $company = \App\Models\Company::where('user_id', $companyUser->id)->first();

        if (!$company) {
            $company = \App\Models\Company::create([
                'user_id' => $companyUser->id,
                'name' => 'Tech Corp',
                'description' => 'Leading technology company specializing in software development and innovation.',
                'website' => 'https://techcorp.example.com',
                'industry' => 'Technology',
                'size' => '100-500 employees',
                'location' => 'San Francisco, CA',
                'email' => 'hr@techcorp.example.com',
                'phone' => '+1 (555) 123-4567',
                'is_verified' => true,
            ]);
        }

        // Create sample job listings if they don't exist
        if (\App\Models\JobListing::where('company_id', $company->id)->count() === 0) {
            $job1 = \App\Models\JobListing::create([
                'company_id' => $company->id,
                'title' => 'Junior Full Stack Developer',
                'description' => 'We are looking for a passionate Junior Full Stack Developer to join our growing team. You will work on exciting projects using modern technologies and frameworks.',
                'location' => 'San Francisco, CA (Hybrid)',
                'job_type' => 'full_time',
                'experience_level' => 'entry',
                'salary_min' => 70000,
                'salary_max' => 90000,
                'requirements' => "- Bachelor's degree in Computer Science or related field\n- Knowledge of HTML, CSS, JavaScript\n- Familiarity with React or Vue.js\n- Understanding of backend technologies (Node.js, Python, or PHP)\n- Good problem-solving skills",
                'responsibilities' => "- Develop and maintain web applications\n- Collaborate with cross-functional teams\n- Write clean, maintainable code\n- Participate in code reviews\n- Learn and adapt to new technologies",
                'benefits' => "- Competitive salary\n- Health insurance\n- 401(k) matching\n- Flexible work hours\n- Professional development opportunities",
                'status' => 'open',
                'deadline' => now()->addDays(30),
                'positions_available' => 2,
            ]);

            \App\Models\JobQuestion::create([
                'job_id' => $job1->id,
                'question' => 'Tell us about a project you\'re most proud of and the technologies you used.',
                'type' => 'text',
                'is_required' => true,
                'order' => 1,
            ]);

            \App\Models\JobQuestion::create([
                'job_id' => $job1->id,
                'question' => 'Are you authorized to work in the United States?',
                'type' => 'yes_no',
                'is_required' => true,
                'order' => 2,
            ]);

            $job2 = \App\Models\JobListing::create([
                'company_id' => $company->id,
                'title' => 'Software Engineering Intern',
                'description' => 'Join our team as a Software Engineering Intern and gain hands-on experience with real-world projects.',
                'location' => 'Remote',
                'job_type' => 'internship',
                'experience_level' => 'entry',
                'salary_min' => 25,
                'salary_max' => 35,
                'requirements' => "- Currently pursuing a degree in Computer Science or related field\n- Basic programming knowledge\n- Eagerness to learn",
                'responsibilities' => "- Assist in software development tasks\n- Write and test code\n- Participate in team meetings",
                'benefits' => "- Hourly compensation\n- Remote work flexibility\n- Mentorship program",
                'status' => 'open',
                'deadline' => now()->addDays(45),
                'positions_available' => 3,
            ]);
        }

        echo "Company seeder completed successfully!\n";
    }
}
