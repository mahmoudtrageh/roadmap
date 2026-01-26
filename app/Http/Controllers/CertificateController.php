<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function __construct(
        private CertificateService $certificateService
    ) {}

    /**
     * Verify a certificate by its code
     */
    public function verify(string $code)
    {
        $certificate = $this->certificateService->verifyCertificate($code);

        if (!$certificate) {
            abort(404, 'Certificate not found');
        }

        return view('certificates.verify', compact('certificate'));
    }

    /**
     * Download a certificate
     */
    public function download(Certificate $certificate)
    {
        // Check if user is authorized to download
        if (auth()->id() !== $certificate->student_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $filePath = storage_path('app/public/' . $certificate->certificate_url);

        if (!file_exists($filePath)) {
            abort(404, 'Certificate file not found');
        }

        return response()->download($filePath);
    }

    /**
     * Show student's certificates
     */
    public function index()
    {
        $certificates = Certificate::with('roadmap')
            ->where('student_id', auth()->id())
            ->orderBy('issued_at', 'desc')
            ->get();

        return view('certificates.index', compact('certificates'));
    }
}
