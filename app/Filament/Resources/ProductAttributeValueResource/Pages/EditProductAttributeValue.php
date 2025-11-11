<?php

namespace App\Filament\Resources\ProductAttributeValueResource\Pages;

use App\Filament\Resources\ProductAttributeValueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class EditProductAttributeValue extends EditRecord
{
    protected static string $resource = ProductAttributeValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->after(function ($record) {
                    // Delete image file if type is image
                    if ($record->type === 'image' && $record->value) {
                        Storage::disk('public')->delete($record->value);
                    }
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Attribute Value Updated')
            ->body('The attribute value has been updated successfully.');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle type changes - if switching from image to text, keep the value
        $originalType = $this->record->type;

        if ($originalType === 'image' && $data['type'] === 'text') {
            // If switching from image to text, delete the old image
            if ($this->record->value) {
                Storage::disk('public')->delete($this->record->value);
            }
            $data['value'] = null;
        }

        if ($originalType === 'text' && $data['type'] === 'image') {
            // If switching from text to image, clear the text value
            $data['value'] = null;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        // Add any additional logic after saving the record
    }
}
