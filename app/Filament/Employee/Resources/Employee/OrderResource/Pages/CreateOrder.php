<?php

namespace App\Filament\Employee\Resources\Employee\OrderResource\Pages;

use App\Filament\Employee\Resources\Employee\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
