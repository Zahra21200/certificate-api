<?php


use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;




Route::prefix('admin')->group(function() {
    Route::post('register', [AdminAuthController::class, 'register']);
    Route::post('logout', [AdminAuthController::class, 'logout']);
    Route::post('login', [AdminAuthController::class, 'login']);

});


Route::middleware('auth:admin')->group(function () {
    Route::post('certificates', [CertificateController::class, 'store']);
    Route::get('all-certificates', [CertificateController::class, 'index']);
    Route::get('certificates/{national_id}', [CertificateController::class, 'show']);
    Route::get('certificate/{id}', [CertificateController::class, 'getbyid']);
    
    Route::delete('certificates/{id}', [CertificateController::class, 'destroy']);
    Route::delete('certificates', [CertificateController::class, 'bulkDelete']);
    Route::put('certificates/{id}', [CertificateController::class, 'update']);
    
    

});
