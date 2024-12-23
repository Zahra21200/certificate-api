<?php

namespace App\Repositories;

use App\Models\Certificate;

class CertificateRepository implements CertificateRepositoryInterface
{
    public function create(array $data)
    {
        return Certificate::create($data);
    }

    public function getByNationalId(string $nationalId)
    {
        return Certificate::where('national_id', $nationalId)->first();
    }
}
