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
                ->modalDescription('This will delete all auto-generated SKUs and regenerate them from current attribute values. Manual SKUs will be preserved. Are you sure?')
                ->action(function () {
                    $this->regenerateSkus();
                })
                ->visible(fn () => $this->record && $this->record->attributeValues()->count() > 0),
        ];
    }

    protected function afterSave(): void
    {
        // Refresh the record to ensure attribute values are loaded
        $this->record->refresh();
        
        // Handle manual SKU attribute assignments
        $this->record->load('skus');

        $formData = $this->form->getState();
        if (isset($formData['skus']) && is_array($formData['skus'])) {
            foreach ($formData['skus'] as $skuData) {
                if (isset($skuData['attribute_value_ids']) && is_array($skuData['attribute_value_ids']) && !empty($skuData['attribute_value_ids'])) {
                    // Find SKU by ID or by SKU code (for newly created ones)
                    $sku = null;
                    if (isset($skuData['id'])) {
                        $sku = \App\Models\Sku::find($skuData['id']);
                    } elseif (isset($skuData['sku'])) {
                        $sku = \App\Models\Sku::where('product_id', $this->record->id)
                            ->where('sku', $skuData['sku'])
                            ->first();
                    }
                    
                    if ($sku) {
                        $sku->attributeValues()->sync($skuData['attribute_value_ids']);
                    }
                }
            }
        }

        // Refresh the form with the latest record data so removals/additions persist visually
        $this->record->load('skus.attributeValues', 'attributeValues');
        $this->form->model($this->record)->fill($this->record->toArray());
    }

    /**
     * Regenerate SKUs for the current product.
     * Can be called via Livewire action.
     */
    public function regenerateSkus(): void
    {
        if (!$this->record) {
            return;
        }
        
        // Refresh the record to ensure attribute values are loaded
        $this->record->refresh();
        
        // Generate SKUs
        $service = new SkuGenerationService();
        $skuIds = $service->generateSkus($this->record);
        
        // Refresh the record with relationships
        $this->record->refresh();
        $this->record->load('skus', 'attributeValues');
        
        // Refresh the form data to show new SKUs
        // Reload the form with updated data
        $this->form->model($this->record)->fill($this->record->toArray());
        
        if (count($skuIds) > 0) {
            Notification::make()
                ->title('SKUs generated')
                ->body(count($skuIds) . ' SKU(s) generated from attribute combinations. The SKUs tab will refresh automatically.')
                ->success()
                ->send();
            
            // Dispatch browser event to refresh the page component
            $this->dispatch('skus-regenerated');
        } else {
            Notification::make()
                ->title('No SKUs generated')
                ->body('No attribute values found or combinations could not be generated.')
                ->warning()
                ->send();
        }
    }
}
