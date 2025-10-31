<?php
namespace App\Filament\Vendor\Pages;

use Filament\Pages\Page;

class ViewInvoice extends Page
{
    public $invoiceId;

    public function mount()
    {
        $this->invoiceId = request()->query('invoiceId');
    }
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.vendor.pages.view-invoice';

    public static function route(string $path = '/vendor/view-invoice'): \Illuminate\Routing\Route
    {
        return parent::route($path);
    }
}

