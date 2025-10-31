@extends('layouts.user_dashboard')
@section('css')
    <style>
        .invoice-container {
            /* max-width: 800px; */
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            border-radius: 8px;
        }

        @media print {
            .invoice-container {
                box-shadow: none;
                border-radius: 0;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 28px;
        }

        .invoice-title p {
            margin: 5px 0 0;
            color: #7f8c8d;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .info-box {
            flex: 1;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            margin: 0 10px;
        }

        .info-box:first-child {
            margin-left: 0;
        }

        .info-box:last-child {
            margin-right: 0;
        }

        .info-box h4 {
            margin-top: 0;
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .info-box p {
            margin: 5px 0;
            color: #555;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .invoice-table th {
            background-color: #DE991B;
            color: white;
            padding: 12px;
            text-align: left;
        }

        .invoice-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .invoice-table tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .total-row:last-child {
            margin-bottom: 0;
            font-weight: bold;
            font-size: 18px;
            color: #2c3e50;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }

        .status-paid {
            background-color: #27ae60;
            color: white;
        }

        .shop-info {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .shop-info h5 {
            margin-top: 0;
            color: #2c3e50;
        }

        .additional-info {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
            margin-top: 30px;
        }
    </style>
@endsection
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <x-invoice :order="$order" />
    </div>

    <script type="text/javascript">
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
