<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;



Route::post('certificates', [CertificateController::class, 'store']);
Route::get('all-certificates', [CertificateController::class, 'index']);
Route::get('certificates/{national_id}', [CertificateController::class, 'show']);

Route::delete('certificates/{id}', [CertificateController::class, 'destroy']); 
Route::delete('certificates', [CertificateController::class, 'bulkDelete']); 
Route::put('certificates/{id}', [CertificateController::class, 'update']);




