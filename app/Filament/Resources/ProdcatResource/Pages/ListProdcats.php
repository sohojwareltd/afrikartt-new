<?php

namespace App\Filament\Resources\ProdcatResource\Pages;

use App\Filament\Resources\ProdcatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProdcats extends ListRecords
{
    protected static string $resource = ProdcatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
