<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificateRequest;
use App\Http\Resources\CertificateResource;
use App\Models\Certificate;
use App\Repositories\CertificateRepositoryInterface;
use Illuminate\Http\Request;

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
    public function getbyid($id)
    {
        $certificate = $this->certificateRepository->getById($id);
        if (!$certificate) {
            return response()->json(['error' => 'Certificate not found'], 404);
        }
        return new CertificateResource($certificate);
    }


    public function destroy($id)
    {
        $certificate = Certificate::find($id);

        if (!$certificate) {
            return response()->json(['message' => 'Certificate not found'], 404);
        }

        $certificate->delete();

        return response()->json(['message' => 'Certificate deleted successfully']);
    }

    // Delete multiple certificates by IDs
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:certificates,id',
        ]);

        $deletedCount = Certificate::whereIn('id', $request->ids)->delete();

        return response()->json(['message' => "$deletedCount certificates deleted successfully"]);
    }

    // Update a certificate
    public function update(Request $request, $id)
    {
        $certificate = Certificate::find($id);

        if (!$certificate) {
            return response()->json(['message' => 'Certificate not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'string|max:255',
            'national_id' => 'string|unique:certificates,national_id,' . $id,
            'gender' => 'in:male,female',
            'phone_number' => 'string|max:15',
            'city' => 'string|max:100',
            'accept_policy' => 'boolean',
            'transferred_by' => 'in:trainee,other',
            'other' => 'nullable|string|max:255',
            'from_date' => 'date',
            'to_date' => 'date|after_or_equal:from_date',
            'hours' => 'integer|min:1',
        ]);

        $certificate->update($validated);

        return response()->json(['message' => 'Certificate updated successfully', 'data' => (new CertificateResource($certificate))]);
    }


    public function index()
    {
        $certificates = $this->certificateRepository->all();
        return CertificateResource::collection($certificates); 
    }
}
