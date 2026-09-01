<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #2c2c2c;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
        }

        .row {
            width: 100%;
            margin-bottom: 18px;
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
            margin-bottom: 20px;
        }

        .company-details {
            line-height: 1.3;
        }

        .label {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            color: #777;
            margin-bottom: 5px;
        }

        .clear {
            clear: both;
        }

        h1 {
            margin: 0 0 12px 0;
            font-size: 30px;
            letter-spacing: 2px;
        }

        /* =========================================
           INVOICE INFORMATION
        ========================================= */

        .invoice-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
        }

        .invoice-box td {
            padding: 5px 0;
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

        /* =========================================
           STATUS
        ========================================= */

        .status-box {
            margin-top: 14px;
            display: inline-block;
            padding: 5px 12px;
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

        /* =========================================
           DIVIDER
        ========================================= */

        .divider {
            border-bottom: 1px solid #e5e5e5;
            margin: 18px 0;
        }

        /* =========================================
           EXPERT REPORT
        ========================================= */

        .expert-report {
            width: 100%;
            border: 1px solid #d9e2ec;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .expert-report-title {
            background-color: #1f4e78;
            color: #ffffff;
            text-align: center;
            padding: 9px 12px;
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 0.8px;
        }

        .expert-report-subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 10px;
            padding: 6px 10px;
            border-bottom: 1px solid #e5e7eb;
            background-color: #f8fafc;
        }

        .expert-report-info {
            width: 100%;
            border-collapse: collapse;
        }

        .expert-report-info td {
            width: 33.33%;
            padding: 10px 12px;
            vertical-align: top;
            border-right: 1px solid #e5e7eb;
        }

        .expert-report-info td:last-child {
            border-right: none;
        }

        .report-label {
            display: block;
            font-size: 9px;
            text-transform: uppercase;
            color: #6b7280;
            font-weight: bold;
            margin-bottom: 4px;
            letter-spacing: 0.4px;
        }

        .report-value {
            display: block;
            font-size: 12px;
            font-weight: bold;
            color: #1f2937;
            line-height: 1.35;
        }

        /* =========================================
           ITEMS TABLE
        ========================================= */

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .items-table thead {
            display: table-header-group;
        }

        .items-table th {
            text-align: left;
            font-size: 13px;
            padding: 7px 8px;
            border-bottom: 2px solid #000;
        }

        .items-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #eaeaea;
            font-size: 13px;
            line-height: 1.25;
            vertical-align: top;
        }

        .items-table tr {
            page-break-inside: avoid;
        }

        .text-right {
            text-align: right;
        }

        /* =========================================
           SUMMARY
        ========================================= */

        .summary {
            width: 45%;
            float: right;
            margin-top: 18px;
            background: #f9fafb;
            padding: 13px;
            border: 1px solid #e5e7eb;
            page-break-inside: avoid;
        }

        .summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary table td {
            border: none;
            padding: 5px 0;
            font-size: 16px;
        }

        .summary-total {
            font-size: 16px !important;
            font-weight: bold;
            border-top: 1px solid #ccc !important;
            padding-top: 7px !important;
        }

        /* =========================================
           PAYMENT DETAILS
        ========================================= */

        .payment-section {
            margin-top: 20px;
            padding: 9px 13px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            font-size: 12px;
            line-height: 1.3;
            page-break-inside: avoid;
        }

        /* =========================================
           FOOTER
        ========================================= */

        .footer-note {
            margin-top: 12px;
            text-align: center;
            font-size: 10px;
            color: #777;
            page-break-inside: avoid;
        }

        /* =========================================
   EXPERT REPORT - VERY COMPACT
========================================= */

.expert-report {
    width: 100%;
    border: 1px solid #d9e2ec;
    margin: 10px 0 12px 0;
    page-break-inside: avoid;
}

.expert-report-title {
    background-color: #1f4e78;
    color: #ffffff;
    text-align: center;
    padding: 5px 8px;
    font-size: 14px;
    font-weight: bold;
    letter-spacing: 0.5px;
}

.expert-report-info {
    width: 100%;
    border-collapse: collapse;
}

.expert-report-info td {
    width: 33.33%;
    padding: 5px 8px;
    vertical-align: middle;
    border-right: 1px solid #e5e7eb;
}

.expert-report-info td:last-child {
    border-right: none;
}

.report-label {
    display: block;
    font-size: 8px;
    text-transform: uppercase;
    color: #777;
    font-weight: bold;
    margin-bottom: 2px;
}

.report-value {
    display: block;
    font-size: 10px;
    font-weight: bold;
    color: #222;
    line-height: 1.15;
}

    </style>
</head>

<body>

<div class="container">

    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="row">

        <!-- LEFT -->
        <div class="left">

            <img
                src="{{ public_path('images/OakWood-Logo-Hq-1.webp') }}"
                class="logo"
            >

            <div class="label">
                Billed From
            </div>

            <div class="company-details">

                <strong>
                    Oakwood Edge Ltd
                </strong>

                <br>

                Second floor,
                <br>

                9 Portland Street,
                <br>

                Manchester,
                <br>

                M1 3BE

                <br>

            </div>

        </div>


        <!-- RIGHT -->
        <div class="right">

            <h1>
                {{ $documentType ?? 'INVOICE' }}
            </h1>


            <!-- INVOICE INFORMATION -->

            <table class="invoice-box">

                <tr>

                    <td class="label-cell">
                        Invoice Number
                    </td>

                    <td class="value-cell">
                        SOL-INV#{{ $invoice->id }}
                    </td>

                </tr>

                <tr>

                    <td class="label-cell">
                        Invoice Date
                    </td>

                    <td class="value-cell">
                        {{ $invoice->created_at?->format('d M Y') }}
                    </td>

                </tr>

                <tr>

                    <td class="label-cell">
                        Due Date
                    </td>

                    <td class="value-cell">

                        {{
                            $invoice->due_date
                                ? \Carbon\Carbon::parse($invoice->due_date)->format('d M Y')
                                : '-'
                        }}

                    </td>

                </tr>

            </table>


            <!-- CLIENT / SOLICITOR -->

            <div style="margin-top: 25px;">

                <div class="label">
                    Billed To
                </div>

                <strong>
                    {{ $invoice->solicitor?->name ?? '-' }}
                </strong>

                <br>

                {!! nl2br(e($invoice->solicitor_address ?? '-')) !!}

            </div>


          <!-- PAYMENT STATUS -->

@if(($documentType ?? 'INVOICE') === 'INVOICE')

    <div>

        <span
            class="status-box
            {{ $invoice->payment_status === 'paid' ? 'paid' : 'unpaid' }}"
        >
            {{ strtoupper($invoice->payment_status ?? 'UNPAID') }}
        </span>

    </div>

@endif


        </div>

        <div class="clear"></div>

    </div>


    <!-- =====================================================
         DIVIDER
    ====================================================== -->

    <div class="divider"></div>


    <!-- =====================================================
         EXPERT REPORT INFORMATION
    ====================================================== -->

    {{-- <div class="expert-report">

        <!-- REPORT TITLE -->

        <div class="expert-report-title">
            EXPERT MEDICAL REPORT
        </div>


        <!-- REPORT SUBTITLE -->

        <div class="expert-report-subtitle">
            Expert report prepared for the client
        </div>


        <!-- REPORT INFORMATION -->

        <table class="expert-report-info">

            <tr>

                <!-- CLIENT -->

                <td>

                    <span class="report-label">
                        Client Name
                    </span>

                    <span class="report-value">
                        {{ $invoice->client?->name ?? '-' }}
                    </span>

                </td>


                <!-- DOCTOR -->

                <td>

                    <span class="report-label">
                        Report Prepared By
                    </span>

                    <span class="report-value">
                        {{ $invoice->doctor?->name ?? '-' }}
                    </span>

                </td>


                <!-- EXPERT TYPE -->

                <td>

                    <span class="report-label">
                        Expert Type
                    </span>

                    <span class="report-value">
                        {{ $invoice->expert_type ?? '-' }}
                    </span>

                </td>

            </tr>

        </table>

    </div> --}}


    <!-- =====================================================
     EXPERT MEDICAL REPORT
====================================================== -->

<div class="expert-report">

    <div class="expert-report-title">
        EXPERT MEDICAL REPORT
    </div>

    <table class="expert-report-info">

        <tr>

            <td>
                <span class="report-label">
                    Client Name
                </span>

                <span class="report-value">
                    {{ $invoice->client?->client_name ?? '-' }}
                </span>
            </td>


            <td>
                <span class="report-label">
                    Expert
                </span>

                <span class="report-value">
                    {{ $invoice->doctor?->name ?? '-' }}
                </span>
            </td>


            <td>
                <span class="report-label">
                    Expert Type
                </span>

                <span class="report-value">
                    {{ $invoice->expert_type ?? '-' }}
                </span>
            </td>

        </tr>

    </table>

</div>

    <!-- =====================================================
         PRODUCTS / SERVICES
    ====================================================== -->

    <table class="items-table">

        <thead>

            <tr>

                <th>
                    Description
                </th>

                <th
                    class="text-right"
                    style="width: 25%;"
                >
                    Amount (GBP)
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($invoice->items as $item)

                <tr>

                    <td>
                        {{ $item->description }}
                    </td>

                    <td class="text-right">
                        £{{ number_format((float) $item->price, 2) }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td>
                        {{ $invoice->description ?? 'Legal / Solicitor Services' }}
                    </td>

                    <td class="text-right">
                        £{{ number_format((float) $invoice->amount, 2) }}
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    <!-- =====================================================
         SUMMARY
    ====================================================== -->

    <div class="summary">

        <table>

            <!-- SUBTOTAL -->

            <tr>

                <td>
                    Subtotal
                </td>

                <td class="text-right">

                    @if($invoice->items->count() > 0)

                        £{{
                            number_format(
                                (float) $invoice->items->sum('price'),
                                2
                            )
                        }}

                    @else

                        £{{ number_format((float) $invoice->amount, 2) }}

                    @endif

                </td>

            </tr>


            <!-- VAT -->

            <tr>

                <td>
                    VAT ({{ $invoice->vat_rate }}%)
                </td>

                <td class="text-right">
                    £{{ number_format((float) $invoice->vat_amount, 2) }}
                </td>

            </tr>


            <!-- TOTAL -->

            <tr class="summary-total">

                <td>
                    Total
                </td>

                <td class="text-right">

                    £{{ number_format((float) $invoice->total_amount, 2) }}

                </td>

            </tr>

        </table>

    </div>


    <div class="clear"></div>


    <!-- =====================================================
         PAYMENT DETAILS
    ====================================================== -->

    <div class="payment-section">

        <strong>
            Payment Details
        </strong>

        <br>

        Oakwood Edge Ltd

        <br>

        Barclays Bank

        <br>

        Account No: 03743012

        <br>

        Sort Code: 20-82-13

    </div>


    <!-- =====================================================
         FOOTER
    ====================================================== -->

    {{-- <div class="footer-note">

        This is a computer generated invoice
        and does not require a signature.

    </div> --}}

</div>

</body>

</html>
