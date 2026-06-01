<!DOCTYPE html>
<html>
<head>
    <title>Create Invoice</title>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eef2f7;
            display: flex;
            justify-content: center;
            padding: 40px 20px;
            margin: 0;
        }
        .container {
            background: #ffffff;
            padding: 30px 40px;
            width: 100%;
            max-width: 650px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 24px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input, select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #dce1e7;
            outline: none;
            box-sizing: border-box;
            font-size: 14px;
            transition: border-color 0.2s ease;
        }
        input:focus, select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0,123,255,0.2);
        }
        .row {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
            align-items: center;
        }
        .row input {
            flex: 1;
        }
        .btn {
            width: 100%;
            padding: 14px;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s ease;
        }
        .btn-primary {
            background: #007bff;
            margin-top: 25px;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .btn-success {
            background: #10b981;
            margin-top: 10px;
            width: auto;
            padding: 10px 20px;
            font-size: 14px;
        }
        .btn-success:hover {
            background: #059669;
        }
        .dropzone {
            border: 2px dashed #007bff;
            border-radius: 12px;
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            margin-bottom: 25px;
            color: #64748b;
        }
        .items-header {
            font-weight: 600;
            color: #333;
            margin: 20px 0 10px;
            border-bottom: 2px solid #eef2f7;
            padding-bottom: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Create Invoice</h2>

    <form action="{{ route('invoice.uploadLogo') }}" class="dropzone" id="logoDropzone">
        @csrf
        <div class="dz-message">Drag & Drop Logo Here or Click to Upload</div>
    </form>

    <form method="POST" action="{{ route('invoice.store') }}">
        @csrf
        <input type="hidden" name="logo_path" id="logo_path">
        
        <div class="form-group">
            <select name="language" required>
                <option value="en">English</option>
                <option value="gu">Gujarati (ગુજરાતી)</option>
            </select>
        </div>

        <div class="form-group">
            <input type="text" name="customer_name" placeholder="Customer Name" required>
        </div>

        <div class="form-group">
            <input type="email" name="customer_email" placeholder="Customer Email" required>
        </div>

        <div class="items-header">Invoice Items</div>

        <div id="items">
            <div class="row">
                <input type="text" name="item_name[]" placeholder="Item Name" required>
                <input type="number" name="quantity[]" placeholder="Quantity" required>
                <input type="number" step="0.01" name="price[]" placeholder="Price" required>
            </div>
        </div>

        <button type="button" class="btn btn-success" onclick="addRow()">+ Add New Item</button>

        <button type="submit" class="btn btn-primary">Generate PDF Invoice</button>
    </form>
</div>

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    Dropzone.options.logoDropzone = {
        maxFiles: 1,
        acceptedFiles: 'image/*',
        success: function(file, response) {
            document.getElementById('logo_path').value = response.path;
        }
    };

    function addRow() {
        let html = `
            <div class="row">
                <input type="text" name="item_name[]" placeholder="Item Name" required>
                <input type="number" name="quantity[]" placeholder="Quantity" required>
                <input type="number" step="0.01" name="price[]" placeholder="Price" required>
            </div>
        `;
        document.getElementById('items').insertAdjacentHTML('beforeend', html);
    }
</script>

</body>
</html>