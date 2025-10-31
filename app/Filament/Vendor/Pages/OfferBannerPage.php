<?php

namespace App\Filament\Vendor\Pages;

use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class OfferBannerPage extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.vendor.pages.offer-banner-page';
    // protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $title = '';

    // Declare your data array (public so Livewire sees it)
    public array $data = [];

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make('Offer Banners')
                ->url(fn() => route('filament.vendor.pages.offer-banner-page'))
                ->badge(fn() => 'New')
                ->icon('heroicon-o-photo')
                ->sort(5)
                ->group('Marketing'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->check()) {
            $shop = auth()->user()->shop;
            return $shop && $shop->status == 1;
        }
        return false;
    }



    public function mount(): void
    {
        $shop = Auth::user()->shop;

        $this->form->fill([
            'title1' => $shop->title1,
            'category1' => $shop->category1,
            'image1' => $shop->image1 ? [$shop->image1] : [],
            'link1' => $shop->link1,
            'title2' => $shop->title2,
            'category2' => $shop->category2,
            'image2' => $shop->image2 ? [$shop->image2] : [],
            'link2' => $shop->link2,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Grid::make('3')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('title1')
                            ->label('Banner 1 Title')
                            ->maxLength(100),
                        \Filament\Forms\Components\TextInput::make('category1')
                            ->label('Banner 1 Category')
                            ->maxLength(50),
                        \Filament\Forms\Components\TextInput::make('link1')
                            ->label('Banner 1 URL')
                            ->url(),
                    ]),
                \Filament\Forms\Components\FileUpload::make('image1')
                    ->label('Banner 1 Image')
                    ->image()
                    ->disk('public')
                    ->directory('offer-banners')
                    ->imagePreviewHeight('150')
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
                    ->helperText('Upload banner image (max 2MB). Recommended size: 800x400px'),

                Grid::make('3')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('title2')
                            ->label('Banner 2 Title')
                            ->maxLength(100),
                        \Filament\Forms\Components\TextInput::make('category2')
                            ->label('Banner 2 Category')
                            ->maxLength(50),
                        \Filament\Forms\Components\TextInput::make('link2')
                            ->label('Banner 2 URL')
                            ->url(),
                    ]),
                \Filament\Forms\Components\FileUpload::make('image2')
                    ->label('Banner 2 Image')
                    ->image()
                    ->disk('public')
                    ->directory('offer-banners')
                    ->imagePreviewHeight('150')
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
                    ->helperText('Upload banner image (max 2MB). Recommended size: 800x400px'),
            ]);
    }

    public function submit()
    {
        if (is_array($this->data['image1'])) {
            foreach ($this->data['image1'] as $image) {
                $this->data['image1'] = $image;
            }
        }

        if (is_array($this->data['image2'])) {
            foreach ($this->data['image2'] as $image) {
                $this->data['image2'] = $image;
            }
        }

        $shop = Auth::user()->shop;

        $data = $this->data;

        if (isset($data['image1']) && $data['image1'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $data['image1'] = $data['image1']->store('metas', 'public');
        }

        if (isset($data['image2']) && $data['image2'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $data['image2'] = $data['image2']->store('metas', 'public');
        }

        $data = $shop->createMetas($data);
        // dd($data);

        Notification::make()
            ->title('Success')
            ->body('Offer banners updated successfully!')
            ->success()
            ->send();
    }
}
