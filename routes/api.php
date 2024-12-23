<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;



Route::post('certificates', [CertificateController::class, 'store']);
Route::get('certificates/{national_id}', [CertificateController::class, 'show']);






