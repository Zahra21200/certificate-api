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
    // الحصول على الشهادة بناءً على الـ ID
    $certificate = $this->certificateRepository->getById($id);

    if (!$certificate) {
        return response()->json([
            'status' => false,
            'message' => 'Certificate not found',
        ], 404);
    }

    // بناء الاستجابة المخصصة
    return response()->json([
        'status' => true,
        'data' => [
            'id' => $certificate->id,
            'name' => $certificate->name,
            'national_id' => $certificate->national_id,
            'gender' => $certificate->gender,
            'phone_number' => $certificate->phone_number,
            'city' => $certificate->city,
            'accept_policy' => $certificate->accept_policy,
            'transferred_by' => $certificate->transferred_by,
            'other' => $certificate->other,
            'from_date' => $certificate->from_date,
            'to_date' => $certificate->to_date,
            'hours' => $certificate->hours,
            'created_at' => $certificate->created_at->format('Y-m-d H:i:s'),
        ],
    ], 200);
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
