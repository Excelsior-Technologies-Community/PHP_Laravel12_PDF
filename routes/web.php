<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pdf/generate', [PdfController::class, 'generate']);
Route::get('/pdf/save', [PdfController::class, 'save']);

Route::get('/invoice/create', [PdfController::class, 'create'])->name('invoice.create');
Route::post('/invoice/upload-logo', [PdfController::class, 'uploadLogo'])->name('invoice.uploadLogo');
Route::post('/invoice/store', [PdfController::class, 'store'])->name('invoice.store');
Route::get('/pdf/{id}', [PdfController::class, 'show'])->name('invoice.show');
Route::get('/pdf/{id}/send', [PdfController::class, 'sendEmail'])->name('invoice.sendEmail');