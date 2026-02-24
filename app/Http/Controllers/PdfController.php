<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PdfController extends Controller
{
    // Generate and stream PDF to browser
    public function generate()
    {
        $invoice = (object) [
            'id' => 1,
            'customer_name' => 'John Doe',
            'items' => [
                ['name' => 'Product A', 'quantity' => 2, 'price' => 50],
                ['name' => 'Product B', 'quantity' => 1, 'price' => 30],
            ],
            'total' => 130
        ];

        return Pdf::view('pdfs.invoice', ['invoice' => $invoice])
                  ->format('a4')
                  ->name('invoice.pdf'); // Streams PDF to browser
    }

    // Save PDF to storage folder and download
    public function save()
    {
        $invoice = (object) [
            'id' => 2,
            'customer_name' => 'Jane Smith',
            'items' => [
                ['name' => 'Product C', 'quantity' => 3, 'price' => 40]
            ],
            'total' => 120
        ];

        // Path to save PDF
        $filePath = storage_path('app/public/invoice_saved.pdf');

        // Save PDF to storage
        Pdf::view('pdfs.invoice', ['invoice' => $invoice])
           ->format('a4')
           ->save($filePath);

        // Return file as download
        return response()->download($filePath, 'invoice_saved.pdf', [
            'Content-Type' => 'application/pdf'
        ]);
    }
}