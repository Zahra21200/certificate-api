<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificateRequest;
use App\Http\Resources\CertificateResource;
use App\Repositories\CertificateRepositoryInterface;

class CertificateController extends Controller
{
    protected $certificateRepository;

    public function __construct(CertificateRepositoryInterface $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
    }

    public function store(CertificateRequest $request)
    {
        $certificate = $this->certificateRepository->create($request->validated());
        return new CertificateResource($certificate);
    }

    public function show($national_id)
    {
        $certificate = $this->certificateRepository->getByNationalId($national_id);
        if (!$certificate) {
            return response()->json(['error' => 'Certificate not found'], 404);
        }
        return new CertificateResource($certificate);
    }
}
