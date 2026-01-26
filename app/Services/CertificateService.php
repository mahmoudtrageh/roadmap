<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Roadmap;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class CertificateService
{
    /**
     * Generate a certificate for a completed roadmap
     */
    public function generateCertificate(User $student, Roadmap $roadmap): Certificate
    {
        // Check if certificate already exists
        $existingCertificate = Certificate::where('student_id', $student->id)
            ->where('roadmap_id', $roadmap->id)
            ->first();

        if ($existingCertificate) {
            return $existingCertificate;
        }

        // Generate unique verification code
        $verificationCode = $this->generateVerificationCode();

        // Generate PDF
        $pdfPath = $this->createPDF($student, $roadmap, $verificationCode);

        // Create certificate record
        $certificate = Certificate::create([
            'student_id' => $student->id,
            'roadmap_id' => $roadmap->id,
            'certificate_url' => $pdfPath,
            'verification_code' => $verificationCode,
            'issued_at' => now(),
        ]);

        return $certificate;
    }

    /**
     * Create PDF certificate
     */
    private function createPDF(User $student, Roadmap $roadmap, string $verificationCode): string
    {
        $data = [
            'student_name' => $student->name,
            'roadmap_title' => $roadmap->title,
            'roadmap_description' => $roadmap->description,
            'completion_date' => now()->format('F d, Y'),
            'verification_code' => $verificationCode,
            'certificate_url' => route('certificate.verify', $verificationCode),
        ];

        $pdf = Pdf::loadView('certificates.template', $data)
            ->setPaper('a4', 'landscape');

        // Create certificates directory if it doesn't exist
        $certificatesPath = storage_path('app/public/certificates');
        if (!file_exists($certificatesPath)) {
            mkdir($certificatesPath, 0755, true);
        }

        // Save PDF
        $filename = 'certificate_' . $student->id . '_' . $roadmap->id . '_' . time() . '.pdf';
        $fullPath = $certificatesPath . '/' . $filename;
        $pdf->save($fullPath);

        return 'certificates/' . $filename;
    }

    /**
     * Generate unique verification code
     */
    private function generateVerificationCode(): string
    {
        do {
            $code = strtoupper(Str::random(3) . '-' . Str::random(3) . '-' . Str::random(3));
        } while (Certificate::where('verification_code', $code)->exists());

        return $code;
    }

    /**
     * Verify a certificate by code
     */
    public function verifyCertificate(string $code): ?Certificate
    {
        return Certificate::with(['student', 'roadmap'])
            ->where('verification_code', $code)
            ->first();
    }
}
