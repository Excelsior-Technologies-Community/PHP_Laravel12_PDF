<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }
        .body {
            padding: 40px 30px;
            color: #444444;
            line-height: 1.6;
        }
        .body h2 {
            color: #333333;
            margin-top: 0;
            font-size: 20px;
        }
        .invoice-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 25px 0;
            border-left: 4px solid #28a745;
        }
        .invoice-details p {
            margin: 0;
            font-size: 15px;
            color: #555555;
        }
        .footer {
            background-color: #eef2f7;
            padding: 20px;
            text-align: center;
            color: #888888;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Invoice Generated Successfully</h1>
        </div>
        <div class="body">
            <h2>Hello,</h2>
            <p>Thank you for your business. Your invoice has been successfully generated and is attached to this email as a PDF document.</p>
            
            <div class="invoice-details">
                <p><strong>Note:</strong> Please find the attached PDF file. You can download or print it for your records. If it includes a QR code, you can scan it directly from the PDF to make a payment.</p>
            </div>

            <p>If you have any questions or need further assistance regarding this invoice, feel free to reply to this email.</p>
            
            <p>Best Regards,<br><strong>Our Team</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Invoice System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>