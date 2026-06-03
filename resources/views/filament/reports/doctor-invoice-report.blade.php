<div style="font-family: Arial, sans-serif; background:#f5f7fa; padding:25px;">

    {{-- MAIN CONTAINER --}}
    <div style="
        background:white;
        border-radius:14px;
        overflow:hidden;
        box-shadow:0 10px 25px rgba(0,0,0,0.08);
        border:1px solid #e5e7eb;
    ">

        {{-- HEADER --}}
        <div style="
            background:#1e293b;
            padding:30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        ">

            {{-- LEFT --}}
            <div style="display:flex; align-items:center; gap:20px;">

                {{-- LOGO --}}
                <div style="
                    background:white;
                    padding:10px;
                    border-radius:10px;
                ">

                    <img
                        src="{{ asset('images/OakWood Logo Logo Mark (1).webp') }}"
                        alt="Logo"
                        style="height:60px;"
                    >

                </div>

                {{-- TITLE --}}
                <div>

                    <h1 style="
                        color:white;
                        margin:0;
                        font-size:30px;
                        font-weight:bold;
                    ">
                        Doctor Invoice Report
                    </h1>

                    <p style="
                        color:#cbd5e1;
                        margin-top:8px;
                        font-size:14px;
                    ">
                        Financial Reporting & Invoice Summary
                    </p>

                    <p style="
                        color:#94a3b8;
                        font-size:12px;
                        margin-top:5px;
                    ">
                        Generated:
                        {{ now()->format('d M Y h:i A') }}
                    </p>

                </div>

            </div>

            {{-- PRINT BUTTON --}}
            <button
                onclick="window.print()"
                style="
                    background:#10b981;
                    color:white;
                    border:none;
                    padding:14px 22px;
                    border-radius:10px;
                    font-size:15px;
                    font-weight:600;
                    cursor:pointer;
                "
            >
                Print Report
            </button>

        </div>

        {{-- SUMMARY CARDS --}}
        <div style="
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:20px;
            padding:30px;
            background:#f8fafc;
            border-bottom:1px solid #e5e7eb;
        ">

            {{-- CARD --}}
            <div style="
                background:white;
                padding:25px;
                border-radius:12px;
                border:1px solid #e5e7eb;
            ">

                <p style="
                    margin:0;
                    color:#64748b;
                    font-size:14px;
                ">
                    Total Invoices
                </p>

                <h2 style="
                    margin-top:15px;
                    font-size:36px;
                    color:#0f172a;
                ">
                    {{ $records->count() }}
                </h2>

            </div>

            {{-- CARD --}}
            <div style="
                background:white;
                padding:25px;
                border-radius:12px;
                border:1px solid #e5e7eb;
            ">

                <p style="
                    margin:0;
                    color:#64748b;
                    font-size:14px;
                ">
                    Total Revenue
                </p>

                <h2 style="
                    margin-top:15px;
                    font-size:36px;
                    color:#059669;
                ">
                    £{{ number_format($totalAmount, 2) }}
                </h2>

            </div>

            {{-- CARD --}}
            <div style="
                background:white;
                padding:25px;
                border-radius:12px;
                border:1px solid #e5e7eb;
            ">

                <p style="
                    margin:0;
                    color:#64748b;
                    font-size:14px;
                ">
                    Paid Invoices
                </p>

                <h2 style="
                    margin-top:15px;
                    font-size:36px;
                    color:#2563eb;
                ">
                    {{ $records->where('payment_status','paid')->count() }}
                </h2>

            </div>

            {{-- CARD --}}
            <div style="
                background:white;
                padding:25px;
                border-radius:12px;
                border:1px solid #e5e7eb;
            ">

                <p style="
                    margin:0;
                    color:#64748b;
                    font-size:14px;
                ">
                    Unpaid Invoices
                </p>

                <h2 style="
                    margin-top:15px;
                    font-size:36px;
                    color:#dc2626;
                ">
                    {{ $records->where('payment_status','unpaid')->count() }}
                </h2>

            </div>

        </div>

        {{-- TABLE SECTION --}}
        <div style="padding:30px;">

            <table style="
                width:100%;
                border-collapse:collapse;
                overflow:hidden;
                border-radius:12px;
            ">

                {{-- TABLE HEADER --}}
                <thead>

                    <tr style="background:#1e293b;">

                        <th style="padding:16px; color:white; text-align:left;">
                            Doctor
                        </th>

                        <th style="padding:16px; color:white; text-align:left;">
                            Client
                        </th>

                        <th style="padding:16px; color:white; text-align:left;">
                            Ref
                        </th>

                        <th style="padding:16px; color:white; text-align:right;">
                            Amount
                        </th>

                        <th style="padding:16px; color:white; text-align:right;">
                            VAT
                        </th>

                        <th style="padding:16px; color:white; text-align:right;">
                            Total
                        </th>

                        <th style="padding:16px; color:white; text-align:center;">
                            Status
                        </th>

                        <th style="padding:16px; color:white; text-align:center;">
                            Date
                        </th>

                    </tr>

                </thead>

                {{-- TABLE BODY --}}
                <tbody>

                    @forelse($records as $record)

                        <tr style="border-bottom:1px solid #e5e7eb;">

                            <td style="padding:18px; font-weight:600;">
                                {{ $record->doctor?->name }}
                            </td>

                            <td style="padding:18px;">
                                {{ $record->client?->client_name }}
                            </td>

                            <td style="padding:18px;">
                                {{ $record->our_ref }}
                            </td>

                            <td style="padding:18px; text-align:right;">
                                £{{ number_format($record->amount,2) }}
                            </td>

                            <td style="padding:18px; text-align:right;">
                                £{{ number_format($record->vat_amount,2) }}
                            </td>

                            <td style="
                                padding:18px;
                                text-align:right;
                                font-weight:bold;
                                color:#059669;
                            ">
                                £{{ number_format($record->total_amount,2) }}
                            </td>

                            <td style="padding:18px; text-align:center;">

                                @if($record->payment_status === 'paid')

                                    <span style="
                                        background:#dcfce7;
                                        color:#166534;
                                        padding:6px 14px;
                                        border-radius:30px;
                                        font-size:12px;
                                        font-weight:600;
                                    ">
                                        Paid
                                    </span>

                                @else

                                    <span style="
                                        background:#fee2e2;
                                        color:#991b1b;
                                        padding:6px 14px;
                                        border-radius:30px;
                                        font-size:12px;
                                        font-weight:600;
                                    ">
                                        Unpaid
                                    </span>

                                @endif

                            </td>

                            <td style="padding:18px; text-align:center;">
                                {{ $record->created_at->format('d M Y') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" style="
                                padding:40px;
                                text-align:center;
                                color:#64748b;
                            ">
                                No Records Found
                            </td>

                        </tr>

                    @endforelse

                </tbody>

                {{-- FOOTER --}}
                <tfoot>

                    <tr style="background:#f8fafc;">

                        <td colspan="5" style="
                            padding:20px;
                            text-align:right;
                            font-size:18px;
                            font-weight:bold;
                        ">
                            Total Revenue:
                        </td>

                        <td style="
                            padding:20px;
                            text-align:right;
                            font-size:24px;
                            font-weight:bold;
                            color:#059669;
                        ">
                            £{{ number_format($totalAmount,2) }}
                        </td>

                        <td colspan="2"></td>

                    </tr>

                </tfoot>

            </table>

        </div>

        {{-- FOOTER --}}
        <div style="
            background:#f8fafc;
            padding:20px 30px;
            border-top:1px solid #e5e7eb;
            display:flex;
            justify-content:space-between;
        ">

            <p style="
                margin:0;
                color:#64748b;
                font-size:14px;
            ">
                © {{ now()->year }} Your Company Name
            </p>

            <p style="
                margin:0;
                color:#64748b;
                font-size:14px;
            ">
                Confidential Financial Report
            </p>

        </div>

    </div>

</div>
