<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function orderDetails(Order $order) {
        return view('auth.admin.order.details',compact('order'));
    }

    public function toggleShopStatus(\Illuminate\Http\Request $request, \App\Models\Shop $shop)
    {
        if ($request->has('deactivate')) {
            $shop->status = 0;
        } else {
            $shop->status = 1;
        }
        $shop->save();

        return back()->with('success', 'Shop status updated!');
    }
}
