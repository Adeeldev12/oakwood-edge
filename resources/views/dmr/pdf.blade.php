<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>
        DMR Report - {{ $year }}
    </title>

    <style>
        @page {
            size: A4 landscape;
            margin: 15px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1e293b;
            font-size: 9px;
            margin: 0;
        }

        .header {
            background: #172033;
            color: white;
            padding: 18px 20px;
            margin-bottom: 15px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .subtitle {
            margin-top: 4px;
            color: #cbd5e1;
            font-size: 9px;
        }

        .year {
            float: right;
            font-size: 13px;
            font-weight: bold;
        }

        /* Report date range */
        .report-period {
            margin-top: 8px;
            color: #e2e8f0;
            font-size: 9px;
        }

        .report-period strong {
            color: #ffffff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th {
            background: #172033;
            color: white;
            padding: 8px 4px;
            border: 1px solid #334155;
            font-size: 8px;
        }

        td {
            padding: 7px 4px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }

        td.name {
            text-align: left;
            font-weight: bold;
            width: 18%;
        }

        tr:nth-child(even) td {
            background: #f8fafc;
        }

        .total {
            font-weight: bold;
            background: #eef2f7 !important;
        }

        .grand-total {
            background: #4f46e5 !important;
            color: white;
            font-weight: bold;
        }

        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 9px;
            color: #64748b;
        }
    </style>
</head>

<body>

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="header">

        {{-- Reporting Year --}}
        <div class="year">
            {{ $year }}
        </div>


        {{-- Title --}}
        <div class="title">
            DMR Report
        </div>


        {{-- Subtitle --}}
        <div class="subtitle">
            Monthly Solicitor Case Report
        </div>


        {{-- =================================================
             DATE FILTER
        ================================================== --}}

        <div class="report-period">

            @if($startDate && $endDate)

                <strong>Report Period:</strong>

                {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}

                &nbsp; - &nbsp;

                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}

            @else

                <strong>Report Period:</strong>

                Full Year {{ $year }}

            @endif

        </div>

    </div>


    {{-- =====================================================
         REPORT TABLE
    ====================================================== --}}

    <table>

        <thead>

            <tr>

                <th style="width: 18%;">
                    Solicitor
                </th>

                @foreach($months as $month => $monthName)

                    <th>
                        {{ $monthName }}
                    </th>

                @endforeach

                <th>
                    Annual Total
                </th>

            </tr>

        </thead>


        <tbody>

            {{-- =================================================
                 SOLICITOR ROWS
            ================================================== --}}

            @foreach($solicitors as $solicitor)

                <tr>

                    <td class="name">
                        {{ $solicitor->name }}
                    </td>


                    @foreach($months as $month => $monthName)

                        <td>
                            {{ (int) ($cases[$solicitor->id][$month] ?? 0) }}
                        </td>

                    @endforeach


                    {{-- Annual Total --}}
                    <td class="total">

                        {{
                            collect($cases[$solicitor->id] ?? [])
                                ->sum(fn ($value) => (int) $value)
                        }}

                    </td>

                </tr>

            @endforeach


            {{-- =================================================
                 GRAND TOTAL
            ================================================== --}}

            <tr>

                <td class="total">
                    TOTAL CASES
                </td>


                @foreach($months as $month => $monthName)

                    <td class="total">

                        {{
                            collect($cases)->sum(
                                fn ($solicitor) =>
                                    (int) ($solicitor[$month] ?? 0)
                            )
                        }}

                    </td>

                @endforeach


                {{-- Overall Total --}}
                <td class="grand-total">

                    {{
                        collect($cases)
                            ->flatten()
                            ->sum(fn ($value) => (int) $value)
                    }}

                </td>

            </tr>

        </tbody>

    </table>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="footer">

        Generated on
        {{ now()->format('d M Y h:i A') }}

    </div>

</body>
</html>
