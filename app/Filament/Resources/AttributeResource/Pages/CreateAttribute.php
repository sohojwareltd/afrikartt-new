<?php

namespace App\Filament\Resources\AttributeResource\Pages;

use App\Filament\Resources\AttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateAttribute extends CreateRecord
{
    protected static string $resource = AttributeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Attribute created')
            ->body('The attribute has been created successfully.');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Add any data mutations before creating if needed
        return $data;
    }
}
