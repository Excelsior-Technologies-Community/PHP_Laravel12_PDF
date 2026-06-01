<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use App\Mail\InvoiceMail;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PdfController extends Controller
{
    public function create()
    {
        return view('pdfs.create');
    }

    public function uploadLogo(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('logos', 'public');
            return response()->json(['path' => $path]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

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
            'customer_email' => $request->customer_email,
            'language' => $request->language,
            'logo_path' => $request->logo_path,
            'items' => $items,
            'total' => $total
        ]);

        return redirect()->route('invoice.show', $invoice->id);
    }

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        App::setLocale($invoice->language);
        
        $upiId = "yourupi@okbank";
        $upiString = "upi://pay?pa={$upiId}&pn={$invoice->customer_name}&am={$invoice->total}&cu=INR";

        return Pdf::view('pdfs.invoice', compact('invoice', 'upiString'))
            ->format('a4')
            ->name("invoice_{$invoice->id}.pdf");
    }

    public function sendEmail($id)
    {
        $invoice = Invoice::findOrFail($id);
        App::setLocale($invoice->language);

        $upiId = "yourupi@okbank";
        $upiString = "upi://pay?pa={$upiId}&pn={$invoice->customer_name}&am={$invoice->total}&cu=INR";

        $pdfPath = storage_path("app/public/invoice_{$id}.pdf");
        
        Pdf::view('pdfs.invoice', compact('invoice', 'upiString'))
            ->format('a4')
            ->save($pdfPath);

        Mail::to($invoice->customer_email)->send(new InvoiceMail($pdfPath));

        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }

        return back()->with('success', 'Invoice sent successfully!');
    }

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
            ->name('invoice.pdf');
    }

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

        $filePath = storage_path('app/public/invoice_saved.pdf');

        Pdf::view('pdfs.invoice', ['invoice' => $invoice])
            ->format('a4')
            ->save($filePath);

        return response()->download($filePath, 'invoice_saved.pdf', [
            'Content-Type' => 'application/pdf'
        ]);
    }
}