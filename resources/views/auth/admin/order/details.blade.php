@extends('voyager::master')


@section('css')
    <style>
        .invoice-container {
            max-width: 1030px;
            margin: 0 auto;
            padding: 20px;
            /* background-color: #fff;
                                border-top: 8px solid #4a4a4a;
                                border-bottom: 8px solid #4a4a4a;
                                border-left: 1px solid #ccc;
                                border-right: 1px solid #ccc;
                                color: #333; */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: white;
            font-family: Arial, sans-serif;
        }

        @media print {
            .invoice-container {
                max-width: 800px;
                height: auto;
            }
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .invoice-header h2 {
            font-size: 24px;
            margin: 0;
            color: #555;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .invoice-info .shop-info {
            flex-grow: 1;
        }

        .invoice-info .shop-info p {
            margin: 0;
            color: #777;
        }

        .invoice-info .customer-info {
            text-align: right;
        }

        .invoice-info .customer-info p {
            margin: 0;
            color: #777;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .invoice-table-shop {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .invoice-table th {
            border-bottom: 2px solid #000;
            padding: 10px;
            text-align: center;
            color: #000;
        }

        .cricle {
            background-color: #000;
            border-radius: 50%;
            height: 10px;
            width: 10px;
        }

        .invoice-table th {
            /* background-color: #f7f7f7; */
        }

        .invoice-total {
            text-align: right;
            margin-bottom: 40px;
        }

        .total-amount {
            font-size: 20px;
            margin: 0;
            color: #555;
        }

        .thank-you {
            text-align: center;
            margin-top: 40px;
            font-style: italic;
            color: #777;
        }

        .shop p {
            font-size: 12px
        }
    </style>
@stop

@section('page_header')

@stop


@section('content')
    <div class="ec-shop-rightside col-lg-12 col-md-12">
        {{-- <div class="d-flex justify-content-end mb-2">
    <button onclick="printDiv('printableArea')" class="btn btn-dark ">Print this page</button>
   
</div> --}}

        <div id="printableArea">
            <div class="invoice-container">

                <div class="invoice-info row">
                    <div class="shop-info col-md-6">
                        <h4>Invoice</h4>
                        <h6> {{ $order->first_name }} {{ $order->last_name }}</h6>
                        <p>{{ $order->created_at->format('M-d-Y') }}</p>
                        <p> Order No: {{ $order->id }}</p>
                    </div>
                    <div class="customer-info col-md-6">
                        <h5>Afrikar E-commerce</h5>

                        <p>New York, USA</p>
                        {{-- <p>+1 (518) 653-8997</p> --}}
                        <p> Info@afrikartt.com</p>

                    </div>
                </div>

                <table class="invoice-table ">

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Info</th>
                                <th scope="col">Shipping cost</th>
                                <th scope="col">Vendor total</th>
                                {{-- <th scope="col">Commision</th> --}}
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                <th scope="col" style="text-align: right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->childs as $item)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $item->quantity }} x {{ $item->product->name }},
                                        @php
                                            $variation = $item->orderproduct->variation
                                                ? json_decode($item->orderproduct->variation)
                                                : null;
                                        @endphp
                                        @if ($variation)
                                            @foreach ($variation as $key => $item)
                                                {{ $key }} : {{ $item }}
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ Sohoj::price($item->shipping_total) }}</td>
                                    <td>{{ Sohoj::price($item->vendor_total) }}</td>
                                    {{-- <td>{{Sohoj::price($item->total - ($item->vendor_total + $item->shipping_total))}}</td> --}}
                                    <td>{{ Sohoj::price($item->total) }}</td>
                                    <td>
                                        @if ($item->status == 1)
                                            <span
                                                style="
                font-size: 13px;color: white;background-color: orange;padding: 0;margin-top: 15px;
            ">Processing</span>
                                        @elseif($item->status == 2)
                                            <span
                                                style="
                font-size: 11px;color: white;background-color: blue;padding: 0;margin-top: 15px;
            ">On
                                                it's way</span>
                                        @elseif($item->status == 3)
                                            <span
                                                style="
                font-size: 13px;color: white;background-color: red;padding: 0;margin-top: 15px;
            ">Canceled</span>
                                        @elseif($item->status == 4)
                                            <span
                                                style="
                font-size: 13px;color: white;background-color: green;padding: 0;margin-top: 15px;
            ">Delivered</span>
                                        @elseif($item->status == 5)
                                            <span
                                                style="
                font-size: 13px;color: white;background-color: rgb(192, 97, 14);padding: 0;margin-top: 15px;
            ">Refund
                                                Request</span>
                                        @else
                                            <span
                                                style="
                font-size: 13px;color: white;background-color: indianred;padding: 0;margin-top: 15px;
            ">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('payout', $item) }}"
                                            OnClick='return (confirm("Are you sure you want to payment request?"));'
                                            title="Payouts" class="btn btn-sm btn-success pull-right ">
                                            <i class="voyager-wallet"></i> <span class="hidden-xs hidden-sm">Payouts</span>
                                        </a>
                                        <a href="{{ url('admin/orders/') . '/' . $item->id }}" title="View"
                                            class="btn btn-sm btn-primary pull-right" style="margin-right: 5px">
                                            <i class="voyager-wallet"></i> <span class="hidden-xs hidden-sm">View</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>

                                <td colspan="4">
                                    <p class="text-primary" style="font-size: 20px">Platform Fee</p>
                                </td>

                                <td colspan="2">
                                    <p class="text-primary" style="font-size: 20px">
                                        {{ Sohoj::price($order->platform_fee) }}</p>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <tfoot>

                        {{-- <tr style="border-top: 2px solid black">
                    <td colspan="2"></td>
                    <td class="text-center">
                        {{ Sohoj::price($order->total + $order->shipping_total) }}
                    </td>
                </tr> --}}



                    </tfoot>
                </table>

                {{-- <div class="invoice-total">
            <p class="total-amount">Total Amount: {{ Sohoj::price($order->vendor_total) }}</p>
        </div> --}}
                {{-- <table class="invoice-table">
            <thead>
                <tr>

                    <th class="text-start">Shop</th>
                    <th class="text-start">Id</th>
                    <th class="text-start">Address</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> {{ $order->shop->name }}</td>
                    <td>{{ $order->shop->id }}</td>
                    <td>{{ $order->shop->city }}, {{ $order->shop->state }}</td>
                </tr>
            </tbody>
        </table> --}}
                {{-- <div class="row shop" style="
        margin-top: 120px;">
            <div class="col-md-6">
                <h6>Shop</h6>
                <p>{{ $order->shop->name }}</p>
            </div>
            <div class="col-md-3">
                <h6>Id</h6>
                <p>{{ $order->shop->id }}</p>
            </div>
            <div class="col-md-3">
                <h6>Address</h6>
                <p>{{ $order->shop->city }}, {{ $order->shop->state }}</p>
            </div>
        </div> --}}
                <div class=" mt-5 p-3" style="border: 1px solid black">
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th class="text-start">Additional Information:</th>
                                <th class="text-end">Total Paid:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>

                                    Transaction Number:{{ $order->transaction_id }}
                                </td>
                                <td class="text-end">
                                    <h1> {{ Sohoj::price($order->total + $order->shipping_total) }}</h1>
                                </td>
                            </tr>
                            <tr style="border-top: 2px solid black">
                                <td class="p-1 d-flex align-items-center">

                                    <span class="ms-1">Thank You! -Afrikart E-commerce</span>
                                </td>
                                <td class="text-end " style="text-transform:uppercase">usd</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@stop
@section('javascript')
    <script type="text/javascript">
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@stop
