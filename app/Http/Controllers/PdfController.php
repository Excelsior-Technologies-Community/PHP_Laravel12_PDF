<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PdfController extends Controller
{

    // Show form
    public function create()
    {
        return view('pdfs.create');
    }

    // Store data
    public function store(Request $request)
    {
        $items = [];

        foreach ($request->item_name as $key => $name) {
            $items[] = [
                'name' => $name,
                'quantity' => $request->quantity[$key],
                'price' => $request->price[$key],
            ];
        }

        $total = array_sum(array_map(fn($i) => $i['quantity'] * $i['price'], $items));

        $invoice = Invoice::create([
            'customer_name' => $request->customer_name,
            'items' => $items,
            'total' => $total
        ]);

        return redirect('/pdf/' . $invoice->id);
    }

    // Generate PDF from DB (THIS IS MAIN CHANGE)
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);

        return Pdf::view('pdfs.invoice', compact('invoice'))
            ->format('a4')
            ->name('invoice.pdf');
    }


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