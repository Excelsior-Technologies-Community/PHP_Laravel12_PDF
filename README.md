# PHP_Laravel12_PDF

## Introduction

PHP_Laravel12_PDF is a Laravel 12 demonstration project that shows how to generate high-quality PDF documents using the Spatie Laravel PDF package.

This project explains step-by-step how to:

- Generate PDFs from Blade views

- Stream PDFs directly to the browser

- Save PDFs to the local storage

- Automatically download saved PDFs

- Configure Browsershot for advanced rendering

---

## Project Overview

This project demonstrates practical implementation of PDF generation in Laravel using:

- Laravel 12

- Spatie Laravel PDF

- Browsershot (Headless Chrome via Puppeteer)

- Blade templating engine

The application includes:

- A sample invoice Blade template

- A controller to generate and download PDFs

- File storage configuration

- Proper routing setup

- Browsershot installation for professional-grade PDF rendering

---

## Step 1: Create Laravel 12 Project

Open terminal and run:

```bash
composer create-project laravel/laravel PHP_Laravel12_PDF "12.*"
cd PHP_Laravel12_PDF
php artisan serve
```

This will start your Laravel 12 application at `http://127.0.0.1:8000`.

---

## Step 2: Install Spatie Laravel PDF Package

```bash
composer require spatie/laravel-pdf
```

Publish config if needed (Optional): 

```bash
php artisan vendor:publish --provider="Spatie\LaravelPdf\PdfServiceProvider" --tag="config"
```

---

## Step 3: Create Blade View for PDF

Create a folder and view file:

```
resources/views/pdfs/invoice.blade.php
```

Example content:

```html
<!DOCTYPE html>
<html>

<head>
    <title>Invoice PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Invoice</h1>
    </div>

    <div class="content">
        <p>Invoice ID: {{ $invoice->id }}</p>
        <p>Customer Name: {{ $invoice->customer_name }}</p>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['price'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p>Total: {{ $invoice->total }}</p>
    </div>
</body>

</html>
```

---

## Step 4: Create Controller

```bash
php artisan make:controller PdfController
```

Controller code:

```php
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
```

---

## Step 5: Define Routes

Add in `routes/web.php`:

```php
use App\Http\Controllers\PdfController;

Route::get('/pdf/generate', [PdfController::class, 'generate']);
Route::get('/pdf/save', [PdfController::class, 'save']);
```

---

## Step 6: Configure Storage (for saving PDFs)

```bash
php artisan storage:link
```

This allows saved PDFs to be accessible from `storage/app/public`.

---

## Step 7: Install Browsershot (recommended)

If you want full Browsershot support for advanced PDF rendering:

Install the package:

```bash
composer require spatie/browsershot
```

Install Node.js and npm (if not already installed):

```bash
node -v
npm -v
```

If not installed, download Node.js LTS from nodejs.org

Install Puppeteer (required by Browsershot):

```bash
npm install puppeteer --global
```

Clear config cache:

```bash
php artisan config:clear
```
Now your PDFs can use the Browsershot driver with Spatie for better rendering.

## Step 8: Testing

1. Run the server:

```bash
php artisan serve
```

2. Visit `http://127.0.0.1:8000/pdf/generate` to view the PDF in browser.
3. Visit `http://127.0.0.1:8000/pdf/save` to save and download the PDF.

---

## Output

<img width="1818" height="1087" alt="Screenshot 2026-02-24 104639" src="https://github.com/user-attachments/assets/e12a855e-6d06-424d-8a79-d88a7dbf2c51" />

<img width="1829" height="1094" alt="Screenshot 2026-02-24 105812" src="https://github.com/user-attachments/assets/5188fa5f-6834-4ec7-92cb-91d2f7f3794c" />

---

## Project Structure

```
PHP_Laravel12_PDF/
├── app/
│   └── Http/
│       └── Controllers/
│           └── PdfController.php
├── resources/
│   └── views/
│       └── pdfs/
│           └── invoice.blade.php
├── routes/
│   └── web.php
├── storage/
│   └── app/
│       └── public/
│           └── invoice_saved.pdf
├── composer.json
├── artisan
└── README.md
```

---

Your PHP_Laravel12_PDF Project is now ready!
