<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

Route::get('/pdf/generate', [PdfController::class, 'generate']);
Route::get('/pdf/save', [PdfController::class, 'save']);

Route::get('/', function () {
    return view('welcome');
});
