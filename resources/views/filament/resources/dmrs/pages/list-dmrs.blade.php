<x-filament-panels::page>

    <style>
        /* ============================================
           DMR PROFESSIONAL STYLING
        ============================================ */

        .dmr-wrapper {
            --dmr-navy: #172033;
            --dmr-navy-light: #1f2a44;
            --dmr-border: #e5e7eb;
            --dmr-bg: #f8fafc;
            --dmr-primary: #4f46e5;
        }

        /* Main card */
        .dmr-card {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow:
                0 1px 2px rgba(0, 0, 0, 0.04),
                0 8px 24px rgba(15, 23, 42, 0.04);
        }

        /* ============================================
           TOOLBAR
        ============================================ */

        .dmr-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 24px;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }

        .dmr-title {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .dmr-title-icon {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: white;
            box-shadow: 0 5px 12px rgba(79, 70, 229, 0.20);
        }

        .dmr-title-text h1 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.02em;
        }

        .dmr-title-text p {
            margin: 3px 0 0;
            font-size: 13px;
            color: #6b7280;
        }

        .dmr-toolbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dmr-year-label {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .dmr-year-select {
            height: 40px;
            min-width: 110px;
            padding: 0 34px 0 12px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            background: #ffffff;
            color: #111827;
            font-size: 13px;
            font-weight: 600;
            outline: none;
            transition: all .15s ease;
        }

        .dmr-year-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .10);
        }

        /* ============================================
           REPORT INFO BAR
        ============================================ */

        .dmr-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 24px;
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
        }

        .dmr-info-left {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #64748b;
        }

        .dmr-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, .10);
        }

        .dmr-info-right {
            font-size: 12px;
            color: #64748b;
        }

        /* ============================================
           TABLE CONTAINER
        ============================================ */

        .dmr-scroll-container {
            position: relative;
            width: 100%;
            height: calc(100vh - 330px);
            min-height: 480px;
            max-height: 720px;
            overflow: auto;
            background: #ffffff;
        }

        /* Horizontal scrollbar */
        .dmr-scroll-container::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        .dmr-scroll-container::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .dmr-scroll-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
            border: 2px solid #f1f5f9;
        }

        .dmr-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* ============================================
           TABLE
        ============================================ */

        .dmr-table {
            width: max-content;
            min-width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
        }

        /* ============================================
           HEADER
        ============================================ */

        .dmr-table thead th {
            position: sticky;
            top: 0;
            z-index: 20;
            height: 54px;
            padding: 0 14px;
            background: var(--dmr-navy);
            border-right: 1px solid rgba(255,255,255,.07);
            color: #dbe4f0;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            text-align: center;
            white-space: nowrap;
        }

        .dmr-table thead th.month-column {
            width: 120px;
            min-width: 120px;
        }

        .dmr-table thead th.number-column {
            width: 55px;
            min-width: 55px;
        }

        .dmr-table thead th.solicitor-column {
            width: 280px;
            min-width: 280px;
            text-align: left;
        }

        .dmr-table thead th.total-column {
            width: 125px;
            min-width: 125px;
        }

        /* ============================================
           STICKY COLUMNS
        ============================================ */

        .sticky-number {
            position: sticky !important;
            left: 0;
            z-index: 25 !important;
        }

        .sticky-solicitor {
            position: sticky !important;
            left: 55px;
            z-index: 25 !important;
        }

        .sticky-total {
            position: sticky !important;
            right: 0;
            z-index: 25 !important;
        }

        .dmr-table thead .sticky-number,
        .dmr-table thead .sticky-solicitor,
        .dmr-table thead .sticky-total {
            background: var(--dmr-navy);
        }

        /* ============================================
           BODY
        ============================================ */

        .dmr-table tbody td {
            height: 62px;
            padding: 7px 10px;
            border-right: 1px solid #f1f5f9;
            border-bottom: 1px solid #edf0f3;
            background: #ffffff;
            vertical-align: middle;
        }

        .dmr-table tbody tr:nth-child(even) td {
            background: #fafbfc;
        }

        .dmr-table tbody tr:hover td {
            background: #f5f7ff;
        }

        /* Sticky body cells */
        .dmr-table tbody tr:nth-child(odd) .sticky-number,
        .dmr-table tbody tr:nth-child(odd) .sticky-solicitor {
            background: #ffffff;
        }

        .dmr-table tbody tr:nth-child(even) .sticky-number,
        .dmr-table tbody tr:nth-child(even) .sticky-solicitor {
            background: #fafbfc;
        }

        .dmr-table tbody tr:hover .sticky-number,
        .dmr-table tbody tr:hover .sticky-solicitor {
            background: #f5f7ff;
        }

        /* ============================================
           SOLICITOR
        ============================================ */

        .solicitor-cell {
            display: flex;
            align-items: center;
            gap: 11px;
            padding-left: 4px;
        }

        .solicitor-avatar {
            width: 34px;
            height: 34px;
            min-width: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 11px;
            font-weight: 800;
        }

        .solicitor-name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #1e293b;
            font-size: 13px;
            font-weight: 600;
        }

        .solicitor-number {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 600;
        }

        /* ============================================
           INPUTS
        ============================================ */

        .dmr-input {
            display: block;
            width: 100%;
            height: 38px;
            padding: 0 8px;
            border: 1px solid #e2e8f0 !important;
            border-radius: 7px !important;
            background: #f8fafc !important;
            color: #1e293b !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            text-align: center;
            outline: none;
            box-shadow: none !important;
            transition:
                border-color .15s ease,
                background .15s ease,
                box-shadow .15s ease;
        }

        .dmr-input:hover {
            border-color: #cbd5e1 !important;
            background: #ffffff !important;
        }

        .dmr-input:focus {
            border-color: #6366f1 !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .10) !important;
        }

        /* Remove arrows */
        .dmr-input::-webkit-outer-spin-button,
        .dmr-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .dmr-input[type=number] {
            -moz-appearance: textfield;
        }

        /* ============================================
           TOTAL
        ============================================ */

        .dmr-row-total {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 70px;
            height: 36px;
            padding: 0 10px;
            border-radius: 8px;
            background: #f1f5f9;
            color: #334155;
            font-size: 13px;
            font-weight: 800;
        }

        .dmr-table tbody .sticky-total {
            background: #f8fafc;
            border-left: 1px solid #e2e8f0;
        }

        .dmr-table tbody tr:hover .sticky-total {
            background: #eef2ff;
        }

        /* ============================================
           GRAND TOTAL
        ============================================ */

        .dmr-grand-total td {
            position: sticky;
            bottom: 0;
            z-index: 15;
            height: 68px !important;
            background: #eef2f7 !important;
            border-top: 2px solid #cbd5e1 !important;
            border-bottom: 0 !important;
        }

        .dmr-grand-total .sticky-number,
        .dmr-grand-total .sticky-solicitor {
            z-index: 30 !important;
            background: #eef2f7 !important;
        }

        .dmr-grand-total .sticky-total {
            z-index: 30 !important;
            background: #e2e8f0 !important;
            border-left: 1px solid #cbd5e1 !important;
        }

        .grand-total-label {
            color: #334155;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .month-total {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 62px;
            height: 34px;
            padding: 0 9px;
            border-radius: 7px;
            background: #ffffff;
            color: #1e293b;
            font-size: 13px;
            font-weight: 800;
            box-shadow: 0 1px 2px rgba(0,0,0,.04);
        }

        .year-total {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 78px;
            height: 36px;
            padding: 0 12px;
            border-radius: 8px;
            background: #4f46e5;
            color: #ffffff;
            font-size: 14px;
            font-weight: 800;
            box-shadow: 0 3px 8px rgba(79,70,229,.20);
        }

        /* ============================================
           FOOTER
        ============================================ */

        .dmr-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 15px 24px;
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
        }

        .dmr-footer-text {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 12px;
        }

        .dmr-footer-text strong {
            color: #334155;
        }

        /* ============================================
           RESPONSIVE
        ============================================ */

        @media (max-width: 768px) {

            .dmr-toolbar {
                align-items: flex-start;
                flex-direction: column;
                padding: 18px;
            }

            .dmr-toolbar-right {
                width: 100%;
                justify-content: space-between;
            }

            .dmr-info {
                padding: 10px 18px;
            }

            .dmr-scroll-container {
                height: calc(100vh - 400px);
            }

        }
    </style>


    <div class="dmr-wrapper space-y-5">


        {{-- =====================================================
             TOP HEADER
        ====================================================== --}}

        <div class="dmr-card">

            <div class="dmr-toolbar">

                <div class="dmr-title">

                    <div class="dmr-title-icon">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            style="width:22px;height:22px;"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.75 3v18m0 0h18M7.5 16.5l3-3 2.25 2.25L18 10.5"
                            />
                        </svg>

                    </div>

                    <div class="dmr-title-text">

                        <h1>
                            DMR Report
                        </h1>

                        <p>
                            Monthly solicitor case report
                        </p>

                    </div>

                </div>


                <div class="dmr-toolbar-right">

    {{-- Start Date --}}
    <div>
        <div class="dmr-year-label">
            Start Date
        </div>

        <input
            type="date"
            wire:model="startDate"
            class="dmr-year-select"
        >
    </div>


    {{-- End Date --}}
    <div>
        <div class="dmr-year-label">
            End Date
        </div>

        <input
            type="date"
            wire:model="endDate"
            class="dmr-year-select"
        >
    </div>


    {{-- Apply Filter --}}
    <div style="padding-top:18px;">

        <x-filament::button
            wire:click="applyDateFilter"
            icon="heroicon-m-funnel"
        >
            Apply Filter
        </x-filament::button>

    </div>


    {{-- Clear Filter --}}
    <div style="padding-top:18px;">

        <x-filament::button
            wire:click="clearDateFilter"
            color="gray"
        >
            Clear
        </x-filament::button>

    </div>


    {{-- Reporting Year --}}
    <div>
        <div class="dmr-year-label">
            Reporting Year
        </div>

        <select
            wire:model.live="year"
            class="dmr-year-select"
        >
            @foreach(range(now()->year - 2, now()->year + 2) as $yearOption)

                <option value="{{ $yearOption }}">
                    {{ $yearOption }}
                </option>

            @endforeach
        </select>
    </div>


    {{-- Save --}}
    <div style="padding-top:18px;">

        <x-filament::button
            wire:click="save"
            icon="heroicon-m-check"
        >
            Save Changes
        </x-filament::button>

    </div>

</div>


            </div>


            {{-- =================================================
                 INFO BAR
            ================================================== --}}

            <div class="dmr-info">

                <div class="dmr-info-left">

                    <span class="dmr-dot"></span>

                    <span>
                        Editing {{ $year }} DMR
                    </span>

                </div>

                <div class="dmr-info-right">

                    {{ $solicitors->count() }} solicitors
                    <span style="margin:0 6px;">•</span>
                    12 months

                </div>

            </div>


            {{-- =================================================
                 TABLE
            ================================================== --}}

            <div class="dmr-scroll-container">

                <table class="dmr-table">

                    <thead>

                        <tr>

                            {{-- Number --}}
                            <th class="number-column sticky-number">
                                #
                            </th>


                            {{-- Solicitor --}}
                            <th class="solicitor-column sticky-solicitor">
                                Solicitor
                            </th>


                            {{-- Months --}}
                            @foreach($months as $month => $monthName)

                                <th class="month-column">

                                    {{ $monthName }}

                                </th>

                            @endforeach


                            {{-- Total --}}
                            <th class="total-column sticky-total">

                                Annual Total

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($solicitors as $index => $solicitor)

                            <tr>

                                {{-- Number --}}
                                <td class="sticky-number">

                                    <span class="solicitor-number">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>

                                </td>


                                {{-- Solicitor --}}
                                <td class="sticky-solicitor">

                                    <div class="solicitor-cell">

                                        <div class="solicitor-avatar">

                                            {{ strtoupper(substr($solicitor->name, 0, 1)) }}

                                        </div>

                                        <div class="solicitor-name">

                                            {{ $solicitor->name }}

                                        </div>

                                    </div>

                                </td>


                                {{-- Months --}}
                                @foreach($months as $month => $monthName)

                                    <td>

                                        <input
                                            type="number"
                                            min="0"
                                            wire:model.live="cases.{{ $solicitor->id }}.{{ $month }}"
                                            class="dmr-input"
                                            placeholder="0"
                                        >

                                    </td>

                                @endforeach


                                {{-- Annual Total --}}
                                <td class="sticky-total">

                                    <span class="dmr-row-total">

                                       {{
    collect(
        $cases[$solicitor->id] ?? []
    )->sum(fn ($value) => (int) $value)
}}


                                    </span>

                                </td>

                            </tr>

                        @endforeach


                        {{-- =================================================
                             GRAND TOTAL
                        ================================================== --}}

                        <tr class="dmr-grand-total">

                            <td
    colspan="2"
    class="dmr-total-label-cell"
>


                                <span class="grand-total-label">
                                    Total Cases
                                </span>

                            </td>


                            @foreach($months as $month => $monthName)

                                <td>

                                    <span class="month-total">

                                        {{
                                            collect($cases)->sum(
                                                fn ($solicitor) =>
                                                    (int) ($solicitor[$month] ?? 0)
                                            )
                                        }}

                                    </span>

                                </td>

                            @endforeach


                            {{-- Year Total --}}
                            <td class="sticky-total">

                                <span class="year-total">

                                    {{
    collect($cases)
        ->flatten()
        ->sum(fn ($value) => (int) $value)
}}

                                </span>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                 FOOTER
            ================================================== --}}

            <div class="dmr-footer">

                <div class="dmr-footer-text">

                    <span>
                        Enter monthly figures and click
                    </span>

                    <strong>
                        Save Changes
                    </strong>

                </div>


               <div style="padding-top:18px; display:flex; gap:8px;">

    <x-filament::button
        wire:click="save"
        icon="heroicon-m-check"
    >
        Save Changes
    </x-filament::button>

    <x-filament::button
        wire:click="downloadPdf"
        color="gray"
        icon="heroicon-m-arrow-down-tray"
    >
        Download PDF
    </x-filament::button>

</div>


            </div>

        </div>

    </div>

</x-filament-panels::page>
