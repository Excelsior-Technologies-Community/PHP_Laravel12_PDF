<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

Route::get('/pdf/generate', [PdfController::class, 'generate']);
Route::get('/pdf/save', [PdfController::class, 'save']);
Route::get('/invoice/create', [PdfController::class, 'create']);
Route::post('/invoice/store', [PdfController::class, 'store']);
Route::get('/pdf/{id}', [PdfController::class, 'show']);

Route::get('/', function () {
    return view('welcome');
});
