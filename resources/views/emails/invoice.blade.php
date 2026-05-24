<!DOCTYPE html>
<html>

<head>
 <style>
 body {
 font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
 line-height: 1.6;
 color: #333;
 }

 .container {
 max-width: 600px;
 margin: 0 auto;
 padding: 20px;
 background-color: #f9fafb;
 border-radius: 8px;
 }

 .header {
 text-align: center;
 padding-bottom: 20px;
 border-bottom: 2px solid #e5e7eb;
 margin-bottom: 20px;
 }

 .content {
 background: #fff;
 padding: 30px;
 border-radius: 8px;
 box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
 }

 .amount-box {
 background: #eff6ff;
 border-left: 4px solid #3b82f6;
 padding: 15px;
 margin: 20px 0;
 border-radius: 4px;
 }

 .button {
 display: inline-block;
 background: #3b82f6;
 color: #ffffff;
 text-decoration: none;
 padding: 12px 25px;
 border-radius: 6px;
 font-weight: bold;
 margin-top: 20px;
 }

 .footer {
 text-align: center;
 font-size: 12px;
 color: #6b7280;
 margin-top: 30px;
 }
 </style>
</head>

<body>
 <div class="container">
 <div class="header">
 <h2>{{ $businessName }}</h2>
 </div>
 <div class="content">
 @if(!empty($customBody))
 {!! nl2br(e($customBody)) !!}
 @else
 <p>Hello <strong>{{ $clientName }}</strong>,</p>
 <p>A new invoice has been generated for you by {{ $businessName }}. Please find the PDF version attached to
 this email.</p>

 <div class="amount-box">
 <p style="margin:0;"><strong>Amount Due:</strong> ${{ number_format($amountDue, 2) }}</p>
 <p style="margin:0; margin-top: 5px;"><strong>Due Date:</strong> {{ $dueDate }}</p>
 </div>

 <p>You can also view your invoice securely online and make payments by clicking the button below:</p>

 <div style="text-align: center;">
 <a href="{{ $publicLink }}" class="button" style="color:white;">View Invoice Online</a>
 </div>

 <p style="margin-top: 30px;">Thank you for your business!</p>
 @endif
 </div>
 <div class="footer">
 <p>This email was sent via InvoiceMaker SaaS.</p>
 </div>
 </div>
</body>

</html>