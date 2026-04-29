<!DOCTYPE html>
<html>
<head>
    <title>Create Invoice</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            padding: 40px;
        }

        .container {
            background: #fff;
            padding: 25px;
            width: 500px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 6px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            outline: none;
        }

        input:focus {
            border-color: #007bff;
        }

        .row {
            display: flex;
            gap: 10px;
        }

        .row input {
            flex: 1;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            margin-top: 15px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #0056b3;
        }

        .add-btn {
            background: #28a745;
            margin-top: 10px;
        }

        .add-btn:hover {
            background: #1e7e34;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Create Invoice</h2>

    <form method="POST" action="/invoice/store">
        @csrf

        <input type="text" name="customer_name" placeholder="Customer Name" required>

        <div id="items">
            <div class="row">
                <input type="text" name="item_name[]" placeholder="Item">
                <input type="number" name="quantity[]" placeholder="Qty">
                <input type="number" name="price[]" placeholder="Price">
            </div>
        </div>

        <button type="button" class="add-btn" onclick="addRow()">+ Add Item</button>

        <button type="submit">Generate PDF</button>
    </form>
</div>

<script>
function addRow() {
    let html = `
        <div class="row">
            <input type="text" name="item_name[]" placeholder="Item">
            <input type="number" name="quantity[]" placeholder="Qty">
            <input type="number" name="price[]" placeholder="Price">
        </div>
    `;
    document.getElementById('items').insertAdjacentHTML('beforeend', html);
}
</script>

</body>
</html>