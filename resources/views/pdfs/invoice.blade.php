<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ __('invoice.title') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .action-bar {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-email {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .alert {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            border: 1px solid #c3e6cb;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background: #fff;
        }
        table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        table td {
            padding: 12px;
            vertical-align: top;
        }
        table tr td:nth-child(2), table tr td:nth-child(3) {
            text-align: right;
        }
        table tr.top table td {
            padding-bottom: 30px;
        }
        table tr.top table td.title {
            color: #333;
        }
        .logo {
            max-width: 180px;
            max-height: 90px;
        }
        .invoice-title-text {
            font-size: 32px;
            font-weight: bold;
            color: #007bff;
            margin: 0;
            text-transform: uppercase;
        }
        table tr.heading td {
            background: #007bff;
            color: white;
            font-weight: bold;
            border-bottom: 2px solid #0056b3;
        }
        table tr.item td {
            border-bottom: 1px solid #eee;
        }
        table tr.item:last-child td {
            border-bottom: none;
        }
        table tr.total td {
            border-top: 2px solid #333;
            font-weight: bold;
            font-size: 20px;
            color: #d9534f;
            padding-top: 15px;
        }
        .qr-section {
            text-align: right;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px dashed #ccc;
        }
        .qr-section h4 {
            margin: 0 0 10px 0;
            color: #555;
            font-size: 14px;
        }
        .qr-code-img {
            border: 1px solid #eee;
            padding: 5px;
            border-radius: 5px;
            background: #fff;
        }
    </style>
</head>
<body>

    @if(request()->routeIs('invoice.show'))
        <div class="action-bar">
            @if(session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif
            <a href="{{ route('invoice.sendEmail', $invoice->id) }}" class="btn-email">📧 Send PDF via Email</a>
        </div>
    @endif

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="3">
                    <table>
                        <tr>
                            <td class="title">
                                @if($invoice->logo_path)
                                    <img src="{{ storage_path('app/public/' . $invoice->logo_path) }}" class="logo">
                                @else
                                    <h2 class="invoice-title-text">{{ __('invoice.title') }}</h2>
                                @endif
                            </td>
                            <td>
                                <strong>{{ __('invoice.invoice_id') }}:</strong> #{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}<br>
                                <strong>{{ __('invoice.customer_name') }}:</strong> {{ $invoice->customer_name }}<br>
                                <strong>Date:</strong> {{ $invoice->created_at->format('d M, Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>{{ __('invoice.item') }}</td>
                <td>{{ __('invoice.quantity') }}</td>
                <td>{{ __('invoice.price') }}</td>
            </tr>

            @foreach($invoice->items as $item)
            <tr class="item">
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['price'], 2) }}</td>
            </tr>
            @endforeach

            <tr class="total">
                <td></td>
                <td>{{ __('invoice.total') }}:</td>
                <td>{{ number_format($invoice->total, 2) }}</td>
            </tr>
        </table>

        <div class="qr-section">
            <h4>{{ __('invoice.scan_to_pay') }}</h4>
            <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::size(110)->generate($upiString)) }}" class="qr-code-img">
        </div>
    </div>

</body>
</html>