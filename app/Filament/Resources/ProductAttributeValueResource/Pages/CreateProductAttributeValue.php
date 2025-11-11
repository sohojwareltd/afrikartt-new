<?php

namespace App\Filament\Resources\ProductAttributeValueResource\Pages;

use App\Filament\Resources\ProductAttributeValueResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateProductAttributeValue extends CreateRecord
{
    protected static string $resource = ProductAttributeValueResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Attribute Value Created')
            ->body('The attribute value has been created successfully.');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If type is text and value is empty, set it to null
        if ($data['type'] === 'text' && empty($data['value'])) {
            $data['value'] = null;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // Add any additional logic after creating the record
    }
}
