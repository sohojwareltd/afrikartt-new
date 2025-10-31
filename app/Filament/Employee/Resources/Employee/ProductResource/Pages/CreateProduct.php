<?php

namespace App\Filament\Employee\Resources\Employee\ProductResource\Pages;

use App\Filament\Employee\Resources\Employee\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
