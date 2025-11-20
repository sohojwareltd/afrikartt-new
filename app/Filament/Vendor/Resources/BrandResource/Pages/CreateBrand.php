<?php

namespace App\Filament\Vendor\Resources\BrandResource\Pages;

use App\Filament\Vendor\Resources\BrandResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateBrand extends CreateRecord
{
    protected static string $resource = BrandResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Brand created successfully';
    }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // Ensure shop_id is set
    //     $user = Auth::user();
    //     if ($user && $user->shop) {
    //         $data['shop_id'] = $user->shop->id;
    //     }

    //     return $data;
    // }
}