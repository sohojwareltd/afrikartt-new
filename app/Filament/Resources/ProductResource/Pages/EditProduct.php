<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Services\SkuGenerationService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('regenerateSkus')
                ->label('Regenerate SKUs')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Regenerate SKUs')
                ->modalDescription('This will delete all existing SKUs and regenerate them from current attribute values. Are you sure?')
                ->action(function () {
                    $service = new SkuGenerationService();
                    $skuIds = $service->generateSkus($this->record);
                    
                    Notification::make()
                        ->title('SKUs regenerated successfully')
                        ->body(count($skuIds) . ' SKU(s) generated.')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->attributeValues()->count() > 0),
        ];
    }

    protected function afterSave(): void
    {
        // Refresh the record to ensure attribute values are loaded
        $this->record->refresh();
        
        // Generate SKUs after saving attribute values
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
