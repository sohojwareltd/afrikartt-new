<x-email>
    <table style="width: 100%">
        <tr>
            <td class="review-name" style="margin-bottom: 20px; display: block;">
                <h5>Hello {{ $order->firstname }},</h5>
            </td>
        </tr>
        <tr>
            <td class="header-contain" style="margin-bottom: 40px; display: block;text-align:center">
                <a class="cart-button" style="background-color:black; border:none;" href="{{ route('cart') }}">take me back
                    to
                    my
                    cart</a>

            </td>
        </tr>
        <tr>
            <td style="display: block;margin-bottom:30px">
                <table style="width: 100%">
                    <td style="text-align: left">

                        <h6 style="font-size: 16px;margin:0px"> {{ $order->first_name }} {{ $order->last_name }}</h6>
                        <br>
                        <p style="font-size: 12px;margin:0px">{{ $order->created_at->format('M-d-Y') }}</p>
                        <p style="font-size: 12px;margin:0px"> Order No: {{ $order->id }}</p>
                    </td>
                    <td style="text-align: right">
                        <h6 style="font-size: 16px;margin:0px">Afrikart E-commerce</h6>
                        <br>
                        <p style="font-size: 12px;margin:0px">New York, USA</p>
                        {{-- <p>+1 (518) 653-8997</p> --}}
                        <p style="font-size: 12px;margin:0px"> Info@Afrikart.com</p>
                    </td>
        </tr>
    </table>
    </td>

    </tr>
    <tr>
        <td style="margin-bottom: 20px; display: block;">
            <h4 style="margin: 0px 0px 5px;font-weight: 500;">Your Shopping Bag</h4>
            <table class="order-detail" border="0" cellpadding="0" cellspacing="0" align="left"
                style="width: 100%; margin-bottom: 20px;">
                <tr align="left">
                    <th>Image</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
                @if ($order->childs->count() > 0)
                    @foreach ($order->childs as $item)
                        <tr>
                            <td>
                                <img src="{{ Storage::url($item->product->image) }}" alt="" width="100">
                            </td>

                            <td align="top">
                                <h5 style="margin-top: 15px;">{{ $item->product->name }}
                                </h5>

                                {{-- <h5 style="font-size: 14px;color:#444;margin-top: 8px;margin-bottom: 0px;">
                                Size : <span>S</span>
                            </h5> --}}
                            </td>
                            <td align="top">
                                <h5 style="font-size: 14px; color:#444;margin-top: 15px;">{{ $item->quantity }}
                                </h5>
                            </td>

                            <td align="top">
                                <h5 style="font-size: 14px; color:#444;margin-top:15px">
                                    <b>{{ Sohoj::price($item->product_price) }}</b>
                                </h5>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>
                            <img src="{{ Storage::url($order->product->image) }}" alt="" width="100">
                        </td>

                        <td align="top">
                            <h5 style="margin-top: 15px;">{{ $order->product->name }}
                            </h5>

                            {{-- <h5 style="font-size: 14px;color:#444;margin-top: 8px;margin-bottom: 0px;">
                                Size : <span>S</span>
                            </h5> --}}
                        </td>
                        <td align="top">
                            <h5 style="font-size: 14px; color:#444;margin-top: 15px;">{{ $order->quantity }}
                            </h5>
                        </td>

                        <td align="top">
                            <h5 style="font-size: 14px; color:#444;margin-top:15px">
                                <b>{{ Sohoj::price($order->product_price) }}</b>
                            </h5>
                        </td>
                    </tr>
                @endif
                <tr class="pad-left-right-space ">
                    <td class="m-b-5" colspan="2" align="left">
                        <h6 style="font-weight: 400;font-size: 14px; margin: 0;">Platform Fee :</h6>
                    </td>

                    <td class="m-b-5" colspan="2" align="right">
                        <h6 style="font-weight: 400;font-size: 14px; margin: 0;">
                            {{ Sohoj::price($order->platform_fee) }}</h6>
                    </td>
                </tr>
                <tr class="pad-left-right-space ">
                    <td class="m-b-5" colspan="2" align="left">
                        <h6 style="font-weight: 400;font-size: 14px; margin: 0;">Shipping Cost :</h6>
                    </td>

                    <td class="m-b-5" colspan="2" align="right">
                        <h6 style="font-weight: 400;font-size: 14px; margin: 0;">
                            {{ Sohoj::price($order->shipping_total) }}
                        </h6>
                    </td>
                </tr>
                <tr class="pad-left-right-space ">
                    <td class="m-b-5" colspan="2" align="left">
                        <h6 style="font-weight: 700;font-size: 14px; margin: 0;">Grand Total :</h6>
                    </td>

                    <td class="m-b-5" colspan="2" align="right">
                        <h6 style="font-weight: 700;font-size: 14px; margin: 0;">
                            {{ Sohoj::price($order->total + $order->platform_fee) }}</h6>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="display: block;margin-bottom:30px">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <ul style="font-size:14px">
                            <li style="display: block">
                                {{ $order->shop ? $order->shop->name : '' }}
                            </li>

                            <li style="display: block">
                                {{ $order->shop ? $order->shop->city : '' }},
                                {{ $order->shop ? $order->shop->state : '' }}
                            </li>
                        </ul>

                    </td>

                </tr>
            </table>
        </td>

    </tr>
    <tr>

        <td class="header-contain" style="margin: 20px 0; display: block;text-align:center">

            <a class="cart-button" style="background-color:black;border:none;" href="{{ route('login') }}">Login</a>
        </td>
    </tr>
    </table>
</x-email>
