<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderInvoiceController extends Controller
{
    public function downloadPdf(Order $order)
    {
        $pdf = Pdf::loadView('pdf.order', ['order' => $order]);

        return $pdf->download("order-{$order->id}.pdf");
    }
}
