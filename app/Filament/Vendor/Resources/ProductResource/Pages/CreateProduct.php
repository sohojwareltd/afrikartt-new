<?php

namespace App\Filament\Vendor\Resources\ProductResource\Pages;

use App\Filament\Vendor\Resources\ProductResource;
use App\Setting\Settings;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Product created')
            ->body('The product has been created successfully.');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure shop_id is set
        $user = Auth::user();
        if ($user && $user->shop) {
            $data['shop_id'] = $user->shop->id;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $product = $this->record;
        // Send email notification to admin
        try {
            Mail::to(Settings::setting(key: 'admin_email'))->send(new \App\Mail\ProductCreatedAdminMail($product));
        } catch (\Exception $e) {
            // Log error or handle gracefully
            Log::error('Failed to send product creation email: ' . $e->getMessage());
        }
    }
}
