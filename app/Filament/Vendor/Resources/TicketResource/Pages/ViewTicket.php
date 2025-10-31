<?php

namespace App\Filament\Vendor\Resources\TicketResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Vendor\Resources\TicketResource;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected static ?string $title = 'Massage View';

    public function getView(): string
    {
        return 'filament.vendor.pages.ticket_view';
    }
}

