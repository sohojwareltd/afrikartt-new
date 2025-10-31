@extends('layouts.user_dashboard')
@section('dashboard-content')
    <style>
        /* Redesigned order-header */
        .order-header {
            background: var(--accent-color);
            color: #fff;
            border-radius: 1.5rem;
            padding: 2rem 2.5rem 2rem 2rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 4px 24px rgba(1, 153, 154, 0.13);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            position: relative;
        }

        .order-header .order-header-left {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .order-header .order-header-icon {
            font-size: 2.5rem;
            background: rgba(255, 255, 255, 0.13);
            border-radius: 50%;
            padding: 0.7rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(1, 153, 154, 0.10);
        }

        .order-header .order-header-title {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #fff;
        }

        .order-header .order-header-filter {
            display: flex;
            align-items: center;
        }

        .order-header .btn-group .btn {
            background: #fff;
            color: var(--primary-color);
            font-weight: 600;
            border-radius: 2rem;
            padding: 0.6rem 1.5rem;
            font-size: 1.05rem;
            box-shadow: 0 2px 8px rgba(1, 153, 154, 0.08);
            border: none;
            transition: background 0.2s, color 0.2s;
        }

        .order-header .btn-group .btn:hover,
        .order-header .btn-group .btn:focus {
            background: var(--accent-color);
            color: #fff;
        }

        .order-header .dropdown-menu {
            min-width: 180px;
            border-radius: 1rem;
            box-shadow: 0 2px 12px rgba(1, 153, 154, 0.13);
        }

        @media (max-width: 768px) {
            .order-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 1.2rem 1rem;
            }

            .order-header .order-header-title {
                font-size: 1.3rem;
            }

            .order-header .order-header-icon {
                font-size: 1.5rem;
                padding: 0.4rem 0.7rem;
            }

            .order-header .btn-group .btn {
                font-size: 0.95rem;
                padding: 0.5rem 1.1rem;
            }
        }

        .order-status-badge {
            background: rgb(179 149 0 / 22%);
            color: var(--accent-color);
            border-radius: 0.5rem;
            padding: 0.25rem 0.75rem;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .order-card {
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: none;
            margin-bottom: 2rem;
        }

        .order-card .card-body {
            padding: 2rem 1.5rem;
        }

        .order-product-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
        }

        .btn-green,
        .btn-green:active,
        .btn-green:focus {
            background: #ffffff !important;
            color: #000000 !important;
            border: none !important;
        }

        .btn-green:hover {
            background: #ffffff !important;
            color: #000000 !important;
        }

        .order-meta-label {
            color: #495057;
            font-size: 0.95rem;
        }

        .order-meta-value {
            color: var(--accent-color);
            font-weight: 600;
        }

        .order-action-btns .btn {
            margin-bottom: 0.5rem;
        }

        .order-date {
            color: #fff;
            font-size: 1rem;
            font-weight: 400;
        }

        .btn-danger {
            color: #fff !important;
            background-color: #dc3545 !important;
            border-color: #dc3545;
        }

        .btn-edit-profile {
            background: rgb(179 149 0 / 22%);
            color: var(--accent-color);
            border: none;
            padding: 0.5rem 1rem;
            /* border-radius: 8px; */
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            font-size: 0.85rem;
        }

        .btn-edit-profile:hover {
            background: var(--accent-color);
            color: white;
        }
    </style>
    <div class="ec-shop-rightside col-lg-9 col-md-12 mt-2">
        <div class="order-header">
            <div class="order-header-left">
                <span class="order-header-icon"><i class="fas fa-shopping-bag"></i></span>
                <span class="order-header-title">My Orders</span>
            </div>
            <div class="order-header-filter">
                <div class="btn-group">
                    <button class="btn btn-green btn-sm dropdown-toggle d-flex align-items-center rounded-pill" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        @if (request()->status === '0')
                            Pending Order
                        @elseif (request()->status === '1')
                            Paid Order
                        @elseif(request()->status === '2')
                            On the way
                        @elseif(request()->status === '3')
                            Canceled
                        @else
                            All
                        @endif
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('user.ordersIndex') }}">All</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.ordersIndex', ['status' => 1]) }}">Paid Order</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('user.ordersIndex', ['status' => 0]) }}">Pending
                                order</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('user.ordersIndex', ['status' => 2]) }}">On the way</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('user.ordersIndex', ['status' => 3]) }}">Canceled</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            @if ($latest_orders->count() > 0)
                @foreach ($latest_orders as $order)
                    <div class="card order-card mb-4 shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="mb-1">Order #{{ $order->id }}</h5>
                                    <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                                </div>
                                <div>
                                    <span class="badge px-3 py-2"
                                        style="background: {{ $order->status == 0 ? '#ffc107' : ($order->status == 1 ? '#28a745' : ($order->status == 2 ? '#17a2b8' : ($order->status == 3 ? '#dc3545' : '#6c757d'))) }}; color: white;">
                                        {{ $order->status == 0 ? 'Pending' : ($order->status == 1 ? 'Paid' : ($order->status == 2 ? 'On the Way' : ($order->status == 3 ? 'Canceled' : 'Delivered'))) }}
                                    </span>
                                </div>
                            </div>

                            <div class="order-products-list mb-3">
                                @foreach ($order->products->take(3) as $product)
                              
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ Storage::url($product->image ?? '') }}" alt="" width="45"
                                            height="45" class="rounded me-3">
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold">{{ Str::limit($product->name, 40) }}</div>
                                            <small class="text-muted">x{{ $product->pivot->quantity }} —
                                                {{ Sohoj::price($product->pivot->total_price ?? 0) }}</small>
                                        </div>
                                    </div>
                                @endforeach

                                @if ($order->products->count() > 3)
                                    <div class="text-muted small">+ {{ $order->products->count() - 3 }} more items</div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap border-top pt-3">
                                <div class="mb-2">
                                    <strong>Total:</strong> {{ Sohoj::price($order->total) }}
                                </div>
                                <div class="mb-2">
                                    <span class="me-2">
                                        <strong>Payment:</strong> {{ $order->payment_status == 1 ? 'Paid' : 'Unpaid' }}
                                    </span>
                                    <a href="{{ route('user.invoice', $order) }}" class="btn btn-sm btn-outline-success">
                                        View Invoice
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h3 class="text-center" style="color: var(--primary-green);">No order has been placed</h3>
            @endif
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="returnOrderForm" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="reason">Reason for Return</label>
                            <textarea name="return_reason" id="reason" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="input-group my-3">
                            <label class="input-group-text" for="inputGroupFile01">Attach File (optional)</label>
                            <input type="file" name="return_file" class="form-control"
                                style="height: 37px; min-height: 37px" id="inputGroupFile01">
                        </div>
                        <div class="modal-footer mt-2">
                            <button type="submit" class="btn btn-green">Submit Return Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $("#exampleModal").on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var orderId = button.data('id');
                var url = "{{ route('user.return-order.store', ['order' => ':order']) }}";
                var route = url.replace(':order', orderId);
                $("#returnOrderForm").attr("action", route);
            });
        });
    </script>
@endsection
