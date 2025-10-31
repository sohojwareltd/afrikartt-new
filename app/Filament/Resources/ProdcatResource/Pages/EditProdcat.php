<?php

namespace App\Filament\Resources\ProdcatResource\Pages;

use App\Filament\Resources\ProdcatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProdcat extends EditRecord
{
    protected static string $resource = ProdcatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
