<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking List - Umrah Cab System</title>
    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 15mm;
            line-height: 1.4;
            background: #fff;
        }

        .print-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 20px;
            font-weight: 600;
            text-transform: uppercase;
            color: #2c3e50;
        }

        .sub-title {
            text-align: center;
            font-size: 11px;
            margin-bottom: 5px;
            color: #666;
        }

        .date-time {
            text-align: center;
            font-size: 10px;
            color: #888;
            margin-bottom: 15px;
        }

        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        th {
            background: #80837f;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
            padding: 12px 8px;
            text-align: left;
            border: 1px solid #4a5568;
        }

        td {
            padding: 10px 8px;
            border: 1px solid #e2e8f0;
            font-size: 11px;
            vertical-align: middle;
            background: #fff;
        }

        tr:nth-child(even) td {
            background: #f8fafc;
        }

        tr:hover td {
            background: #f1f5f9;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .price {
            font-weight: 600;
        }

        .print-footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #cbd5e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
            color: #718096;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .no-data {
            text-align: center;
            color: #a0aec0;
            font-style: italic;
        }

        .print-button {
            background: #4299e1;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
            transition: background 0.3s;
        }

        .print-button:hover {
            background: #3182ce;
        }

        @media print {
            body {
                margin: 10mm;
                font-size: 10px;
            }

            .print-header {
                margin-bottom: 15px;
            }

            h1 {
                font-size: 16px;
            }

            .print-table {
                box-shadow: none;
            }

            th {
                background: #f8fafc !important;
                color: #000 !important;
                font-size: 9px;
                padding: 8px 6px;
            }

            td {
                font-size: 9px;
                padding: 6px;
            }

            tr:nth-child(even) td {
                background: #f8fafc !important;
            }

            tr:hover td {
                background: transparent !important;
            }

            .no-print {
                display: none !important;
            }

            .print-footer {
                margin-top: 20px;
            }

            .footer {
                margin-top: 15px;
            }
        }

        @page {
            margin: 15mm;
            size: A4;
        }
    </style>
</head>

<body>
    <div class="print-header">
        <h1>Booking List</h1>
        <div class="sub-title">Umrah Cab System</div>
        <div class="date-time">Generated on: {{ now()->format('d M Y, h:i A') }}</div>
    </div>

    @yield('print_content')

</body>

</html>
