<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Services\SkuGenerationService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterCreate(): void
    {
        // Refresh the record to ensure attribute values are loaded
        $this->record->refresh();
        
        // Generate SKUs after creating product with attribute values
        $service = new SkuGenerationService();
        $skuIds = $service->generateSkus($this->record);
        
        if (count($skuIds) > 0) {
            Notification::make()
                ->title('SKUs generated')
                ->body(count($skuIds) . ' SKU(s) generated from attribute combinations.')
                ->success()
                ->send();
        }
    }
}
