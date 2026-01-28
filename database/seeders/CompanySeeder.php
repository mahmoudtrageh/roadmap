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

        echo "Company seeder completed successfully!\n";
    }
}
