<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface CertificateRepositoryInterface
{
    public function create(array $data);
    public function getByNationalId(string $nationalId);
    public function all(): Collection;

}
