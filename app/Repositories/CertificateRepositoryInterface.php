<?php
namespace App\Repositories;

interface CertificateRepositoryInterface
{
    public function create(array $data);
    public function getByNationalId(string $nationalId);
}
