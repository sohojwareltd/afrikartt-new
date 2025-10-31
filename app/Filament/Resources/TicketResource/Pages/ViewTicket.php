<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected static ?string $title = "Massage View";

    public function getView(): string
    {
        return 'filament.vendor.pages.ticket_view';
    }
}
