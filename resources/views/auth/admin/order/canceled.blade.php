@extends('voyager::master')
@section('content')
    <!DOCTYPE html>

    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Table Example</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.4);
            }

            .modal-content {
                background-color: #fefefe;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 60%;
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }

            button {
                margin: 0;
                padding: 0;
                border: none;
                background: none;
                font: inherit;
                cursor: pointer;
                outline: none;
            }


            .button {
                display: inline-block;
                padding: 10px 20px;
                font-size: 16px;
                border: 2px solid #3498db;
                background-color: #3498db;
                color: white;
                border-radius: 5px;
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            .button:hover {
                background-color: #2980b9;
            }


            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                align-items: center;
                justify-content: center;
            }

            .modal-content {
                background-color: white;
                border-radius: 5px;
                padding: 20px;
                width: 400px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            }

            .close {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 24px;
                cursor: pointer;
                color: #999;
            }


            .styled-input {
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 16px;
            }

            .button {
                background-color: #3498db;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .button:hover {
                background-color: #2980b9;
            }

            .button-container {
                text-align: right;
             
            }
        </style>
    </head>

    <body>
        <h2 style="text-align: center">Canceled Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Shop</th>
                    <th>Product</th>
                    <th>Tax</th>
                    <th>Discount</th>
                    <th>Vendor Total</th>
                    <th>Total</th>
                    <th>Transaction ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($canceledOrders as $canceledOrder)
                    <tr>
                        
                        <td>
                        <p>Name: {{ $canceledOrder->user->name }}</p>
                        <p>Email: {{ $canceledOrder->user->email }}</p>
                        <p>Phone: {{ $canceledOrder->user->phone }}</p>
                        </td>
                        <td>
                            <p>Name: {{ $canceledOrder->shop->name }}</p>
                            <p>Email: {{ $canceledOrder->shop->email }}</p>
                            <p>Phone: {{ $canceledOrder->shop->phone }}</p>
                            <p>Address: {{ $canceledOrder->shop->city }}, {{ $canceledOrder->shop->state }}</p>
                        </td>
                        <td>{{ $canceledOrder->product->name }}</td>
                        <td>{{ Sohoj::price($canceledOrder->tax) }}</td>
                        <td>{{ Sohoj::price($canceledOrder->discount) }}</td>
                        <td>{{ Sohoj::price($canceledOrder->vendor_total) }}</td>
                        <td>{{ Sohoj::price($canceledOrder->total) }}</td>
                        <td>{{ Sohoj::price($canceledOrder->transaction_id) }}</td>
                        <td><button onclick="openModal({{ $canceledOrder->user->id }}, {{ $canceledOrder->id }})"
                                class="button">Refund
                                Amount</button></td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Refund Amount</h2>
                <form action="{{ route('refund.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="user" name="user_id">
                    <input type="hidden" id="order" name="order_id">

                    <label for="refundAmount">Refund Amount:</label>
                    <input type="text" id="refundAmount" class="styled-input" name="refund_amount">
                    <div class="button-container">
                        <button type="submit" class="button">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            function openModal(userId, orderId) {
                document.getElementById("myModal").style.display = "block";
                document.getElementById("user").value = userId;
                document.getElementById("order").value = orderId;
            }

            function closeModal() {
                document.getElementById("myModal").style.display = "none";
            }
        </script>
    </body>

    </html>
@stop
