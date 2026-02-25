<!DOCTYPE html>
<html>

<head>
 <meta charset="utf-8">
 <title>{{ __('Statement of Account') }}</title>
 <style>
 body {
 font-family: sans-serif;
 font-size: 12px;
 color: #333;
 }

 .header {
 margin-bottom: 30px;
 border-bottom: 2px solid #eee;
 padding-bottom: 20px;
 }

 .business-info {
 float: left;
 }

 .client-info {
 float: right;
 text-align: right;
 }

 .clear {
 clear: both;
 }

 table {
 width: 100%;
 border-collapse: collapse;
 margin-top: 20px;
 }

 th {
 background: #f8f9fa;
 padding: 10px;
 border-bottom: 1px solid #dee2e6;
 text-align: left;
 }

 td {
 padding: 10px;
 border-bottom: 1px solid #eee;
 }

 .totals {
 margin-top: 30px;
 float: right;
 width: 250px;
 }

 .total-row {
 display: flex;
 justify-content: space-between;
 border-bottom: 1px solid #eee;
 padding: 5px 0;
 }

 .grand-total {
 font-weight: bold;
 font-size: 14px;
 border-top: 2px solid #333;
 margin-top: 5px;
 padding-top: 10px;
 }
 </style>
</head>

<body>
 <div class="header">
 <div class="business-info">
 <h1 style="margin: 0; color: #1a56db;">{{ $business->name }}</h1>
 <p>{{ $business->email }}</p>
 </div>
 <div class="client-info">
 <h2>{{ __('Statement of Account') }}</h2>
 <p>{{ __('Date') }}: {{ now()->format('M d, Y') }}</p>
 </div>
 <div class="clear"></div>
 </div>

 <div style="margin-bottom: 40px;">
 <p><strong>{{ __('Bill To') }}:</strong></p>
 <p>{{ $client->name }}<br>
 {{ $client->address }}</p>
 </div>

 <table>
 <thead>
 <tr>
 <th>{{ __('Date') }}</th>
 <th>{{ __('Particulars') }}</th>
 <th>{{ __('Amount') }}</th>
 <th>{{ __('Status') }}</th>
 </tr>
 </thead>
 <tbody>
 @foreach($invoices as $invoice)
 <tr>
 <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
 <td>{{ __('Invoice') }} #{{ $invoice->invoice_number }}</td>
 <td>{{ $invoice->currency_symbol }}{{ number_format($invoice->grand_total, 2) }}</td>
 <td>{{ ucfirst($invoice->status) }}</td>
 </tr>
 @endforeach
 </tbody>
 </table>

 <div class="totals text-right">
 <div style="border-top: 2px solid #f3f4f6; margin-top: 20px; padding-top: 20px;">
 <p><strong>{{ __('Total Invoiced') }}:</strong>
 {{ $invoices->first()->currency_symbol ?? '$' }}{{ number_format($totalInvoiced, 2) }}</p>
 <p><strong>{{ __('Total Paid') }}:</strong>
 {{ $invoices->first()->currency_symbol ?? '$' }}{{ number_format($totalPaid, 2) }}</p>
 <p style="font-size: 1.25em; color: #b91c1c;"><strong>{{ __('Amount Due') }}:</strong>
 {{ $invoices->first()->currency_symbol ?? '$' }}{{ number_format($totalOutstanding, 2) }}</p>
 </div>
 </div>
</body>

</html>