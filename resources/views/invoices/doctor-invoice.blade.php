<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #2c2c2c;
        }

        .container {
            width: 100%;
        }

        .row {
            width: 100%;
            margin-bottom: 25px;
        }

        .left {
            float: left;
            width: 55%;
        }

        .right {
            float: right;
            width: 45%;
            text-align: right;
        }

        .logo {
            height: 130px;
            margin-bottom: 30px;
            /* More spacing between logo & company */
        }

        .company-details {
            line-height: 1.35;
            /* Reduced spacing */
        }

        .label {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            color: #777;
            margin-bottom: 6px;
        }

        .clear {
            clear: both;
        }

        h1 {
            margin: 0 0 15px 0;
            font-size: 30px;
            letter-spacing: 2px;
        }

        /* PROFESSIONAL INVOICE META TABLE */
        .invoice-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }

        .invoice-box td {
            padding: 6px 0;
            font-size: 13px;
        }

        .invoice-box .label-cell {
            text-align: left;
            font-weight: bold;
            color: #555;
            width: 50%;
        }

        .invoice-box .value-cell {
            text-align: right;
            width: 50%;
        }

        .invoice-box tr {
            border-bottom: 1px solid #e5e5e5;
        }

        .invoice-box tr:last-child {
            border-bottom: none;
        }

        /* STATUS BOX */
        .status-box {
            margin-top: 22px;
            display: inline-block;
            padding: 6px 14px;
            font-size: 11px;
            font-weight: bold;
            border-radius: 3px;
            border: 1px solid #000;
        }

        .paid {
            background-color: #e6f4ea;
            color: #1b5e20;
            border-color: #1b5e20;
        }

        .unpaid {
            background-color: #fdecea;
            color: #b71c1c;
            border-color: #b71c1c;
        }

        .divider {
            border-bottom: 1px solid #e5e5e5;
            margin: 30px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            font-size: 12px;
            padding: 10px 8px;
            border-bottom: 2px solid #000;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #eaeaea;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            width: 45%;
            float: right;
            margin-top: 25px;
            background: #f9fafb;
            padding: 15px;
            border: 1px solid #e5e7eb;
        }

        .summary table td {
            border: none;
            padding: 6px 0;
        }

        .summary-total {
            font-size: 15px;
            font-weight: bold;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }

        .payment-section {
            margin-top: 70px;
            padding: 20px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
        }

        .payment-section strong {
            font-size: 14px;
            display: block;
            margin-bottom: 10px;
        }


        .footer-note {
            margin-top: 60px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- HEADER -->
        <div class="row">

            <!-- LEFT SIDE -->
            <div class="left">
                <img src="{{ public_path('images/OakWood-Logo-Hq-1.webp') }}" class="logo">

                <div class="label">Billed From</div>
                <div class="company-details">
                    <strong>Oakwood Edge Ltd</strong><br>
                    medicals@oakwoodedge.com<br>
                    0161383 7553<br>
                    Second floor, 9 Portland Street, Manchester, M1 3BE<br>
                    VAT No: 472172007
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="right">

                <h1>INVOICE</h1>

                <table class="invoice-box">
                    <tr>
                        <td class="label-cell">Invoice Number</td>
                        <td class="value-cell">INV#{{ $invoice->id }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Invoice Date</td>
                        <td class="value-cell">{{ $invoice->created_at?->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Due Date</td>
                        <td class="value-cell">
                            {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') : '-' }}
                        </td>
                    </tr>

                </table>

                <div style="margin-top: 35px;">
                    <div class="label">Billed To</div>
                    <strong>{{ $invoice->doctor->name ?? '-' }}</strong>

                    <div>
                       @php
    $status = $invoice->payment_status ?? 'unpaid';
    $statusClass = strtolower($status) === 'paid' ? 'paid' : 'unpaid';
@endphp

<span class="status-box {{ $statusClass }}">
    {{ $status }}
</span>

                    </div>
                </div>

            </div>

            <div class="clear"></div>
        </div>

        <div class="divider"></div>

        <!-- SERVICES -->
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Amount (GBP)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $invoice->description ?? 'Medical Services' }}</td>
                    <td class="text-right">£{{ number_format($invoice->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- SUMMARY -->
        <div class="summary">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td class="text-right">£{{ number_format($invoice->amount, 2) }}</td>
                </tr>
                <tr>
                    <td>VAT ({{ $invoice->vat_rate }}%)</td>
                    <td class="text-right">£{{ number_format($invoice->vat_amount, 2) }}</td>
                </tr>
                <tr class="summary-total">
                    <td>Total</td>
                    <td class="text-right">£{{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="clear"></div>

        <!-- PAYMENT DETAILS -->
        <div class="payment-section">
            <strong>Payment Details</strong><br><br>
            Oakwood Edge Ltd<br>
            Barclays Bank<br>
            Account No: 03743012<br>
            Sort Code: 20-82-13
        </div>

        <!-- FOOTER -->
        <div class="footer-note">
            This is a computer generated invoice and does not require a signature.
        </div>

    </div>

</body>

</html>
