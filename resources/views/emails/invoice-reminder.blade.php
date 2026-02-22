<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f4f7fa;
            color: #334155;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #2563eb;
            color: #ffffff;
            padding: 40px;
            text-align: center;
        }

        .content {
            padding: 40px;
            line-height: 1.6;
        }

        .footer {
            background-color: #f8fafc;
            padding: 30px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .button {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff !important;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
        }

        .invoice-card {
            background-color: #f1f5f9;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .label {
            font-weight: 600;
            color: #475569;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">Invoice Reminder</h1>
        </div>
        <div class="content">
            <p>Hello {{ $invoice->client->name }},</p>

            @if($type === 'upcoming')
                <p>This is a gentle reminder that your invoice <strong>#{{ $invoice->invoice_number }}</strong> from
                    <strong>{{ $invoice->business->name }}</strong> is due in a few days.</p>
            @elseif($type === 'due')
                <p>This is to remind you that your invoice <strong>#{{ $invoice->invoice_number }}</strong> from
                    <strong>{{ $invoice->business->name }}</strong> is due today.</p>
            @elseif($type === 'overdue')
                <p>We noticed that payment for invoice <strong>#{{ $invoice->invoice_number }}</strong> from
                    <strong>{{ $invoice->business->name }}</strong> is now overdue. We would appreciate it if you could
                    settle this as soon as possible.</p>
            @endif

            <div class="invoice-card">
                <table width="100%">
                    <tr>
                        <td><span class="label">Invoice Number:</span></td>
                        <td align="right">#{{ $invoice->invoice_number }}</td>
                    </tr>
                    <tr>
                        <td><span class="label">Due Date:</span></td>
                        <td align="right">{{ $invoice->due_date->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td><span class="label">Amount Due:</span></td>
                        <td align="right" style="font-size: 18px; font-weight: 700; color: #2563eb;">
                            {{ $invoice->currency_symbol }}{{ number_format($invoice->amount_due, 2) }}</td>
                    </tr>
                </table>
            </div>

            <p style="text-align: center;">
                <a href="{{ route('invoices.public.show', $invoice->share_token) }}" class="button">View & Pay
                    Invoice</a>
            </p>

            <p>If you have already made the payment, please disregard this email.</p>

            <p>Thank you,<br>The {{ $invoice->business->name }} Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ $invoice->business->name }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>