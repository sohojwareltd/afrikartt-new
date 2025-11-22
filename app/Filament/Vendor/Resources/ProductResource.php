<?php

namespace App\Filament\Vendor\Resources;

use App\Facade\Sohoj;
use App\Filament\Vendor\Resources\ProductResource\Pages;
use App\Filament\Vendor\Resources\ProductResource\RelationManagers;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\FilamentProduct;
use App\Models\Product;
use App\Models\ShippingCategory;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Log;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class ProductResource extends Resource
{
    protected static ?string $model = FilamentProduct::class;
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $navigationGroup = 'Inventory';
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $pluralModelLabel = 'Products';
    protected static ?string $modelLabel = 'Product';
    public static function canCreate(): bool
    {
        $user = Auth::user();
        if (!$user || !$user->shop) {
            return false;
        }
        return $user->shop->status == 1;
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        if (!$user || !$user->shop) {
            return parent::getEloquentQuery()->whereRaw('1 = 0'); // Return empty query
        }

        // SIMPLIFIED QUERY - Remove complex with() and select() to prevent memory exhaustion
        return parent::getEloquentQuery()
            ->where('shop_id', $user->shop->id)
            ->whereNull('parent_id');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('shop_id')
                    ->default(function () {
                        $user = Auth::user();
                        return $user && $user->shop ? $user->shop->id : null;
                    }),

                Tabs::make('Product Management')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Section::make('Product Details')
                                    ->description('Essential product information and categorization.')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Product Name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn(string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null)
                                                    ->placeholder('Enter product name')
                                                    ->helperText('Enter a clear, descriptive name for your product. This will be displayed to customers and used to generate the URL slug.')
                                                    ->columnSpan(2),

                                                TextInput::make('sku')
                                                    ->label('SKU')
                                                    ->maxLength(255)
                                                    ->unique(Product::class, 'sku', ignoreRecord: true)
                                                    ->placeholder('Auto-generated or custom')
                                                    ->helperText('Stock Keeping Unit. Leave empty to auto-generate, or enter a unique identifier for inventory tracking.')
                                                    ->columnSpan(1),

                                                TextInput::make('slug')
                                                    ->label('Slug')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->unique(Product::class, 'slug', ignoreRecord: true)
                                                    ->rules(['alpha_dash'])
                                                    ->placeholder('Auto-generated from name')
                                                    ->helperText('URL-friendly version of the product name. Used in web addresses. Auto-generated from product name.')
                                                    ->columnSpan(2),

                                                // Select::make('brand_id')
                                                //     ->label('Brand')
                                                //     ->options(function () {
                                                //         $user = Auth::user();
                                                //         if (!$user || !$user->shop) {
                                                //             return [];
                                                //         }
                                                //         return \App\Models\Brand::where('shop_id', $user->shop->id)
                                                //             ->where('status', true)
                                                //             ->orderBy('name')
                                                //             ->pluck('name', 'id')
                                                //             ->toArray();
                                                //     })
                                                //     ->searchable()
                                                //     ->preload()
                                                //     ->nullable()
                                                //     ->placeholder('Select a brand (optional)')
                                                //     ->helperText('Choose the brand associated with this product. Only your active brands are shown.')
                                                //     ->columnSpan(1),

                                                Select::make('brand_id')
                                                    ->label('Brand')
                                                    ->options(Brand::pluck('name', 'id'))
                                                    ->searchable()
                                                    // ->required()
                                                    ->getSearchResultsUsing(
                                                        fn(string $search): array =>
                                                        Brand::where('name', 'like', "%{$search}%")
                                                            ->limit(50)
                                                            ->pluck('name', 'id')
                                                            ->toArray()
                                                    )
                                                    ->getOptionLabelUsing(
                                                        fn($value): ?string =>
                                                        Brand::find($value)?->name
                                                    ),

                                                TextInput::make('search_keywords')
                                                    ->label('Search Keywords')
                                                    ->maxLength(255)
                                                    ->placeholder('Enter keywords separated by commas')
                                                    ->helperText('Add keywords to improve product searchability. Separate multiple keywords with commas.')
                                                    ->columnSpan(3),
                                            ]),


                                    ]),
                            ]),

                        Tabs\Tab::make('Categories')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Forms\Components\Section::make('Product Categories')
                                    ->description('Select relevant categories for your product to help customers find it easily.')
                                    ->schema([
                                        Forms\Components\Grid::make(1)
                                            ->schema([
                                                // All Categories in One CheckboxList
                                                CheckboxList::make('prodcats')
                                                    ->label('Select Categories')
                                                    ->relationship('prodcats', 'name')
                                                    ->searchable()
                                                    ->bulkToggleable()
                                                    ->options(function () {
                                                        return \App\Models\Prodcat::query()
                                                            ->orderBy('name')
                                                            ->pluck('name', 'id')
                                                            ->toArray();
                                                    })
                                                    ->columns(3)
                                                    ->columnSpanFull()
                                                    ->helperText('Select one or more categories that best describe your product. This helps customers find your product when browsing or searching.'),

                                                // Or use a more organized structure with parent/child categories
                                                // Forms\Components\Fieldset::make('Category Selection Guide')
                                                //     ->schema([
                                                //         Forms\Components\Placeholder::make('category_help')
                                                //             ->label('💡 Category Tips')
                                                //             ->content(new \Illuminate\Support\HtmlString('
                                                //                 <div class="space-y-2 text-sm">
                                                //                     <p><strong>Choose relevant categories:</strong> Select categories that accurately describe your product.</p>
                                                //                     <p><strong>Multiple selections:</strong> You can select multiple categories to increase product visibility.</p>
                                                //                     <p><strong>Search function:</strong> Use the search box above to quickly find specific categories.</p>
                                                //                     <p><strong>Bulk toggle:</strong> Use "Select All" or "Deselect All" for quick selection management.</p>
                                                //                 </div>
                                                //             '))
                                                //             ->columnSpanFull(),
                                                //     ])
                                                //     ->columns(1),

                                                // // Alternative: Hierarchical Category Selection
                                                // Forms\Components\Section::make('Hierarchical Categories (Optional)')
                                                //     ->description('Select primary and secondary categories for better organization.')
                                                //     ->schema([
                                                //         Forms\Components\Select::make('primary_category')
                                                //             ->label('Primary Category')
                                                //             ->options(function () {
                                                //                 return \App\Models\Prodcat::query()
                                                //                     ->whereNull('parent_id')
                                                //                     ->orderBy('name')
                                                //                     ->pluck('name', 'id')
                                                //                     ->toArray();
                                                //             })
                                                //             ->searchable()
                                                //             ->placeholder('Select a main category')
                                                //             ->helperText('Choose the primary category that best represents your product.')
                                                //             ->live()
                                                //             ->afterStateUpdated(function (callable $set) {
                                                //                 $set('secondary_category', null);
                                                //             }),

                                                //         Forms\Components\Select::make('secondary_category')
                                                //             ->label('Secondary Category')
                                                //             ->options(function (callable $get) {
                                                //                 $primaryCategory = $get('primary_category');
                                                //                 if (!$primaryCategory) {
                                                //                     return [];
                                                //                 }

                                                //                 return \App\Models\Prodcat::query()
                                                //                     ->where('parent_id', $primaryCategory)
                                                //                     ->orderBy('name')
                                                //                     ->pluck('name', 'id')
                                                //                     ->toArray();
                                                //             })
                                                //             ->searchable()
                                                //             ->placeholder('Select a subcategory')
                                                //             ->helperText('Choose a more specific subcategory if available.')
                                                //             ->visible(fn (callable $get) => !empty($get('primary_category'))),
                                                //     ])
                                                //     ->columns(2)
                                                //     ->collapsed()
                                                //     ->collapsible(),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Pricing & Inventory')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Forms\Components\Section::make('Pricing Information')
                                    ->description('Set product prices and manage inventory.')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                TextInput::make('vendor_price')
                                                    ->label('Vendor Price')
                                                    ->numeric()
                                                    ->prefix('$')

                                                    ->required()

                                                    ->columnSpanFull(1),
                                            ]),
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Toggle::make('manage_stock')
                                                    ->label('Manage Stock')
                                                    ->live()
                                                    ->helperText('Enable to track inventory levels for this product. When enabled, you can set stock quantities.')
                                                    ->columnSpan(1),

                                                TextInput::make('quantity')
                                                    ->label('Stock Quantity')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->visible(fn(callable $get) => $get('manage_stock'))
                                                    ->helperText('Enter the number of items you have in stock. This will be updated automatically when orders are placed.')
                                                    ->columnSpan(1),
                                            ]),
                                    ]),
                            ]),



                        Tabs\Tab::make('Media')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\Section::make('Product Images')
                                    ->description('Upload product images and media files.')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                FileUpload::make('image')
                                                    ->label('Featured Image')
                                                    ->image()
                                                    ->directory('products')
                                                    ->imagePreviewHeight('120')
                                                    ->visibility('public')
                                                    ->maxSize(100)
                                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/gif', 'image/svg+xml', 'image/avif'])
                                                    ->helperText('Upload a square image (recommended: 450x450px, 1:1 aspect ratio). This will be the main image displayed on product listings and detail pages. Max allowed size is 100KB.')
                                                    ->columnSpan(1),

                                                FileUpload::make('images')
                                                    ->label('Gallery Images')
                                                    ->image()
                                                    ->multiple()
                                                    ->directory('products')
                                                    ->imagePreviewHeight('120')
                                                    ->visibility('public')
                                                    ->maxSize(2048)
                                                    ->maxFiles(10)
                                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/gif', 'image/svg+xml', 'image/avif'])
                                                    ->helperText('Upload additional product images (max 10). Show different angles, details, or variations of your product.')
                                                    ->dehydrateStateUsing(fn($state) => is_array($state) ? $state : [])
                                                    ->columnSpan(1),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Content')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\Section::make('Product Descriptions')
                                    ->description('Add detailed product descriptions and content.')
                                    ->schema([
                                        RichEditor::make('short_description')
                                            ->label('Short Description')
                                            ->placeholder('A brief summary for product listings')
                                            ->helperText('Brief product summary. This appears in product listings and search results to give customers a quick overview.')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'bulletList',
                                                'orderedList',
                                                'link',
                                            ]),

                                        RichEditor::make('description')
                                            ->label('Full Description')
                                            ->placeholder('Detailed product description with features and specifications')
                                            ->helperText('Comprehensive product description with features, specifications, benefits, and usage instructions. This is displayed on the product detail page.')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'strike',
                                                'bulletList',
                                                'orderedList',
                                                'h2',
                                                'h3',
                                                'link',
                                                'blockquote',
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Shipping')
                            ->icon('heroicon-o-truck')
                            ->schema([
                                Section::make('Parcels')
                                    ->schema([
                                        Forms\Components\Group::make()
                                            ->statePath('parcels.0')
                                            ->schema([
                                                Fieldset::make('Safety & Restrictions')
                                                    ->schema([
                                                        Toggle::make('contains_battery_pi966')->label('Battery PI966')->required(),
                                                        Toggle::make('contains_battery_pi967')->label('Battery PI967')->required(),
                                                        Toggle::make('contains_liquids')->label('Liquids')->required(),
                                                    ])
                                                    ->columns(3),

                                                Fieldset::make('Basic Info')
                                                    ->schema([
                                                        TextInput::make('description')->label('Description')->required(),
                                                        Select::make('category_id')
                                                            ->label('Category')
                                                            ->options(
                                                                ShippingCategory::query()
                                                                    ->where('active', true)
                                                                    ->pluck('name', 'hs_code') // key = id, value = name
                                                                    ->toArray()
                                                            )
                                                            ->searchable()
                                                            ->required(),
                                                        TextInput::make('origin_country_alpha2')->label('Origin Country (ISO-2)')->maxLength(2)->required(),

                                                    ])
                                                    ->columns(3),

                                                Fieldset::make('Dimensions (cm)')
                                                    ->schema([
                                                        TextInput::make('length')->numeric()->label('Length')->required(),
                                                        TextInput::make('width')->numeric()->label('Width')->required(),
                                                        TextInput::make('height')->numeric()->label('Height')->required(),
                                                    ])
                                                    ->columns(3),

                                                Fieldset::make('Weight & Value')
                                                    ->schema([
                                                        TextInput::make('actual_weight')->numeric()->label('Weight (kg)')->required(),
                                                        // TextInput::make('declared_customs_value')->numeric()->label('Customs Value'),
                                                    ])
                                                    ->columns(2),
                                            ])->afterStateHydrated(function ($state, callable $set) {
                                                if ($state === null || $state === [] || $state === '') {
                                                    $set('parcels.0', []);
                                                }
                                            }),
                                    ]),
                            ]),
                        Tabs\Tab::make('Settings')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\Section::make('Product Settings')
                                    ->description('Configure product visibility and special features.')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([


                                                Toggle::make('is_variable_product')
                                                    ->label('Variable Product')
                                                    ->helperText('Enable if this product has variations like different sizes, colors, or materials. This will show the Variations tab.')
                                                    ->default(false)
                                                    // ->disabled()
                                                    ->live()
                                                    ->columnSpan(1),

                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Attributes')
                            ->icon('heroicon-o-tag')
                            ->visible(fn(callable $get) => $get('is_variable_product'))
                            ->schema([
                                Forms\Components\Section::make('Product Attributes')
                                    ->description('Define attributes and values for this product. SKUs will be automatically generated from all combinations.')
                                    ->schema([
                                        Forms\Components\Repeater::make('attributeValues')
                                            ->relationship('attributeValues')
                                            ->label('Attribute Values')
                                            ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                                                if (isset($data['type']) && isset($data['value'])) {
                                                    if ($data['type'] === 'text') {
                                                        $data['text_value'] = $data['value'];
                                                    } elseif ($data['type'] === 'image') {
                                                        $value = $data['value'];
                                                        if (is_string($value)) {
                                                            $decoded = json_decode($value, true);
                                                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                                $data['image_name'] = $decoded['name'] ?? '';
                                                                $data['image_value'] = isset($decoded['image_path']) && !empty($decoded['image_path'])
                                                                    ? [$decoded['image_path']]
                                                                    : [];
                                                            } else {
                                                                $data['image_name'] = pathinfo($value, PATHINFO_FILENAME);
                                                                $data['image_value'] = !empty($value) ? [$value] : [];
                                                            }
                                                        } else {
                                                            $data['image_value'] = $value ? (is_array($value) ? $value : [$value]) : [];
                                                            $data['image_name'] = '';
                                                        }
                                                    }
                                                }
                                                return $data;
                                            })
                                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                                                if (isset($data['type'])) {
                                                    if ($data['type'] === 'text' && isset($data['text_value'])) {
                                                        $data['value'] = $data['text_value'];
                                                    } elseif ($data['type'] === 'image') {
                                                        if (isset($data['image_value']) && is_string($data['image_value'])) {
                                                            $data['image_value'] = [$data['image_value']];
                                                        }
                                                        $imagePath = $data['image_value'] ?? $data['value'] ?? null;
                                                        $imageName = $data['image_name'] ?? '';

                                                        if (is_array($imagePath) && !empty($imagePath)) {
                                                            $firstItem = isset($imagePath[0]) ? $imagePath[0] : (reset($imagePath) ?: null);
                                                            if (is_array($firstItem)) {
                                                                $imagePath = $firstItem['path'] ?? $firstItem['name'] ?? $firstItem['url'] ?? null;
                                                            } elseif ($firstItem instanceof TemporaryUploadedFile) {
                                                                $imagePath = $firstItem->store('attribute-values', 'public');
                                                            } elseif (is_string($firstItem)) {
                                                                $imagePath = $firstItem;
                                                            }
                                                        } elseif ($imagePath instanceof TemporaryUploadedFile) {
                                                            $imagePath = $imagePath->store('attribute-values', 'public');
                                                        } elseif (is_string($imagePath) && str_starts_with($imagePath, '{')) {
                                                            $decoded = json_decode($imagePath, true);
                                                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                                $imagePath = $decoded['image_path'] ?? null;
                                                                if (empty($imageName)) {
                                                                    $imageName = $decoded['name'] ?? '';
                                                                }
                                                            }
                                                        }

                                                        if ($imagePath) {
                                                            if (empty($imageName) && is_string($imagePath)) {
                                                                $imageName = pathinfo($imagePath, PATHINFO_FILENAME);
                                                            }
                                                            $data['value'] = json_encode([
                                                                'name' => $imageName,
                                                                'image_path' => $imagePath
                                                            ]);
                                                        } else {
                                                            $data['value'] = null;
                                                        }
                                                    }
                                                }
                                                unset($data['text_value'], $data['image_value'], $data['image_name']);
                                                return $data;
                                            })
                                            ->schema([
                                                Forms\Components\Select::make('attribute_id')
                                                    ->label('Attribute')
                                                    ->relationship('attribute', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->required()
                                                    ->createOptionForm([
                                                        Forms\Components\TextInput::make('name')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->unique(Attribute::class, 'name')
                                                            ->placeholder('Enter attribute name (e.g., Color, Size)'),
                                                    ])
                                                    ->helperText('Select or create an attribute (e.g., Color, Size, Material)')
                                                    ->columnSpan(2),

                                                Forms\Components\Select::make('type')
                                                    ->label('Value Type')
                                                    ->options([
                                                        'text' => 'Text',
                                                        'image' => 'Image',
                                                    ])
                                                    ->default('text')
                                                    ->required()
                                                    ->live()
                                                    ->columnSpan(1)
                                                    ->helperText('Choose text or image value'),

                                                Forms\Components\Hidden::make('value')
                                                    ->dehydrated(),

                                                Forms\Components\TextInput::make('text_value')
                                                    ->label('Value')
                                                    ->required(fn(callable $get) => $get('type') === 'text')
                                                    ->visible(fn(callable $get) => $get('type') === 'text')
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(function (callable $set, $state, callable $get) {
                                                        if ($get('type') === 'text') {
                                                            $set('value', $state ?? '');
                                                        }
                                                    })
                                                    ->placeholder('Enter value (e.g., Red, Small, Large)')
                                                    ->columnSpanFull()
                                                    ->helperText('Enter the attribute value (e.g., Red for Color, Small for Size)'),

                                                Forms\Components\TextInput::make('image_name')
                                                    ->label('Name')
                                                    ->required(fn(callable $get) => $get('type') === 'image')
                                                    ->visible(fn(callable $get) => $get('type') === 'image')
                                                    ->placeholder('Enter a name for this image (e.g., Red, Blue, Pattern A)')
                                                    ->live(onBlur: true)
                                                    ->helperText('Enter a descriptive name for this image attribute value')
                                                    ->columnSpan(1),

                                                Forms\Components\FileUpload::make('image_value')
                                                    ->label('Image')
                                                    ->image()
                                                    ->directory('attribute-values')
                                                    ->disk('public')
                                                    ->imagePreviewHeight('80')
                                                    ->visible(fn(callable $get) => $get('type') === 'image')
                                                    ->required(fn(callable $get) => $get('type') === 'image')
                                                    ->maxFiles(1)
                                                    ->live()
                                                    ->afterStateUpdated(function (callable $set, $state, callable $get) {
                                                        if ($get('type') !== 'image') {
                                                            return;
                                                        }

                                                        $storeTemporaryFile = function ($file) {
                                                            if ($file instanceof TemporaryUploadedFile) {
                                                                return $file->store('attribute-values', 'public');
                                                            }

                                                            return null;
                                                        };

                                                        $resolvePathFromState = function ($state) use ($storeTemporaryFile) {
                                                            if ($state instanceof TemporaryUploadedFile) {
                                                                return $storeTemporaryFile($state);
                                                            }

                                                            if (is_string($state) && !empty($state)) {
                                                                return $state;
                                                            }

                                                            if (is_array($state) && !empty($state)) {
                                                                $firstItem = isset($state[0]) ? $state[0] : (reset($state) ?: null);
                                                                if ($firstItem instanceof TemporaryUploadedFile) {
                                                                    return $storeTemporaryFile($firstItem);
                                                                }

                                                                if (is_array($firstItem)) {
                                                                    return $firstItem['path'] ?? $firstItem['name'] ?? $firstItem['url'] ?? null;
                                                                }

                                                                if (is_string($firstItem) && !empty($firstItem)) {
                                                                    return $firstItem;
                                                                }
                                                            }

                                                            return null;
                                                        };

                                                        $path = $resolvePathFromState($state);

                                                        if (!$path) {
                                                            return;
                                                        }

                                                        $name = $get('image_name');
                                                        if (empty($name)) {
                                                            $name = pathinfo($path, PATHINFO_FILENAME);
                                                            $set('image_name', $name);
                                                        }

                                                        $set('value', json_encode([
                                                            'name' => $name,
                                                            'image_path' => $path,
                                                        ]));

                                                        $set('image_value', [$path]);
                                                    })
                                                    ->dehydrateStateUsing(function ($state, callable $get) {
                                                        if ($get('type') !== 'image') {
                                                            return null;
                                                        }

                                                        if (empty($state)) {
                                                            return null;
                                                        }

                                                        $stateItems = is_array($state) ? $state : [$state];
                                                        $firstItem = $stateItems[0] ?? null;

                                                        if ($firstItem instanceof TemporaryUploadedFile) {
                                                            return $firstItem->store('attribute-values', 'public');
                                                        }

                                                        if (is_array($firstItem)) {
                                                            return $firstItem['path'] ?? $firstItem['name'] ?? $firstItem['url'] ?? null;
                                                        }

                                                        if (is_string($firstItem) && !empty($firstItem)) {
                                                            return $firstItem;
                                                        }

                                                        return is_string($state) && !empty($state) ? $state : null;
                                                    })
                                                    ->columnSpan(1)
                                                    ->helperText('Upload an image for this attribute value'),

                                            ])
                                            ->itemLabel(function (array $state): ?string {
                                                try {
                                                    $attributeName = '';
                                                    if (isset($state['attribute_id'])) {
                                                        $attribute = Attribute::find($state['attribute_id']);
                                                        $attributeName = $attribute ? $attribute->name : '';
                                                    }

                                                    $value = '';
                                                    if (isset($state['type']) && $state['type'] === 'image') {
                                                        $imageValue = $state['image_value'] ?? $state['value'] ?? null;
                                                        if (is_array($imageValue) && !empty($imageValue)) {
                                                            $firstItem = isset($imageValue[0]) ? $imageValue[0] : (reset($imageValue) ?: null);
                                                            if (is_array($firstItem)) {
                                                                $value = basename($firstItem['name'] ?? $firstItem['path'] ?? 'Image');
                                                            } elseif (is_string($firstItem)) {
                                                                $value = basename($firstItem);
                                                            } else {
                                                                $value = 'Image';
                                                            }
                                                        } else {
                                                            $value = 'Image';
                                                        }
                                                    } else {
                                                        $value = $state['text_value'] ?? $state['value'] ?? 'New Value';
                                                        if (is_array($value)) {
                                                            $filtered = array_filter($value, fn($v) => !empty($v));
                                                            $value = !empty($filtered) ? implode(', ', $filtered) : 'New Value';
                                                        } else {
                                                            $value = is_string($value) && !empty($value) ? $value : 'New Value';
                                                        }
                                                    }

                                                    return $attributeName ? "{$attributeName}: {$value}" : $value;
                                                } catch (\Exception $e) {
                                                    return 'Attribute Value';
                                                }
                                            })
                                            ->defaultItems(0)
                                            ->columnSpanFull()
                                            ->helperText('Add attribute values. Each combination of values (grouped by attribute) will create a SKU.'),

                                        Forms\Components\Placeholder::make('attributes_info')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                                    <p class="text-sm text-blue-800 dark:text-blue-200 font-medium mb-2">💡 How it works:</p>
                                                    <ul class="text-sm text-blue-700 dark:text-blue-300 list-disc list-inside space-y-1">
                                                        <li>Add multiple attribute values (e.g., Color: Red, Color: Blue, Size: Small, Size: Large)</li>
                                                        <li>Values with the same attribute will be grouped together</li>
                                                        <li>All combinations will automatically generate SKUs when you save</li>
                                                        <li>Example: Color (Red, Blue) × Size (S, M) = 4 SKUs (Red-S, Red-M, Blue-S, Blue-M)</li>
                                                    </ul>
                                                </div>
                                            '))
                                            ->columnSpanFull(),

                                        Forms\Components\Actions::make([
                                            Forms\Components\Actions\Action::make('generateSkus')
                                                ->label('Generate SKUs Now')
                                                ->icon('heroicon-o-arrow-path')
                                                ->color('success')
                                                ->requiresConfirmation()
                                                ->modalHeading('Generate SKUs')
                                                ->modalDescription('This will regenerate all SKUs from current attribute values. Continue?')
                                                ->action(function ($livewire) {
                                                    if (method_exists($livewire, 'regenerateSkus')) {
                                                        $livewire->regenerateSkus();
                                                    }
                                                })
                                                ->visible(fn($record) => $record && $record->attributeValues()->count() > 0),
                                        ])
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tabs\Tab::make('SKUs')
                            ->icon('heroicon-o-squares-plus')
                            ->visible(fn(callable $get) => $get('is_variable_product'))
                            ->schema([
                                Forms\Components\Section::make('Product Variations (SKUs)')
                                    ->description('Manage individual product variations. SKUs are automatically generated from attribute combinations.')
                                    ->schema([
                                        Forms\Components\Placeholder::make('skus_info')
                                            ->label('')
                                            ->content(function ($record) {
                                                if (!$record) {
                                                    return new \Illuminate\Support\HtmlString('
                                                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                                            <p class="text-sm text-yellow-800 dark:text-yellow-200">⚠️ Please define attributes first in the Attributes tab, then save the product to generate SKUs.</p>
                                                        </div>
                                                    ');
                                                }

                                                $skuCount = $record->skus()->count();
                                                if ($skuCount === 0) {
                                                    return new \Illuminate\Support\HtmlString('
                                                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                                            <p class="text-sm text-blue-800 dark:text-blue-200">💡 No SKUs found. Add attributes in the Attributes tab and save to generate SKUs automatically.</p>
                                                        </div>
                                                    ');
                                                }

                                                return new \Illuminate\Support\HtmlString('
                                                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                                        <p class="text-sm text-green-800 dark:text-green-200 font-medium">✓ ' . $skuCount . ' SKU(s) generated. You can edit prices, quantities, and titles below.</p>
                                                    </div>
                                                ');
                                            })
                                            ->visible(fn($record) => $record !== null)
                                            ->columnSpanFull(),

                                        Forms\Components\Repeater::make('skus')
                                            ->relationship('skus')
                                            ->label('SKUs')
                                            ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                                                if (isset($data['id'])) {
                                                    $sku = \App\Models\Sku::find($data['id']);
                                                    if ($sku) {
                                                        $data['attribute_value_ids'] = $sku->attributeValues->pluck('id')->toArray();
                                                    }
                                                }
                                                return $data;
                                            })
                                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data, $record): array {
                                                $data['is_manual'] = true;
                                                return $data;
                                            })
                                            ->schema([
                                                Forms\Components\Hidden::make('is_manual')
                                                    ->default(true)
                                                    ->dehydrated(),

                                                Forms\Components\Grid::make(3)
                                                    ->schema([
                                                        TextInput::make('sku')
                                                            ->label('SKU Code')
                                                            ->required()
                                                            ->unique(ignoreRecord: true)
                                                            ->maxLength(255)
                                                            ->columnSpan(1)
                                                            ->helperText('Unique SKU identifier'),

                                                        TextInput::make('title')
                                                            ->label('Title')
                                                            ->maxLength(255)
                                                            ->columnSpan(2)
                                                            ->helperText('Display title for this variation (e.g., "Red - Small")'),
                                                    ]),

                                                Forms\Components\FileUpload::make('image')
                                                    ->label('Variation Image')
                                                    ->image()
                                                    ->directory('sku-images')
                                                    ->disk('public')
                                                    ->imagePreviewHeight('150')
                                                    ->imageCropAspectRatio('1:1')
                                                    ->imageResizeTargetWidth('800')
                                                    ->imageResizeTargetHeight('800')
                                                    ->maxSize(5120)
                                                    ->nullable()
                                                    ->columnSpanFull()
                                                    ->helperText('Upload a specific image for this variation. This will be displayed when the variation is selected.'),

                                                Forms\Components\Grid::make(4)
                                                    ->schema([
                                                        TextInput::make('price')
                                                            ->label('Price')
                                                            ->numeric()
                                                            ->prefix('$')
                                                            ->required()
                                                            ->columnSpan(1)
                                                            ->helperText('Selling price'),

                                                        TextInput::make('compare_at_price')
                                                            ->label('Compare at Price')
                                                            ->numeric()
                                                            ->prefix('$')
                                                            ->nullable()
                                                            ->columnSpan(1)
                                                            ->helperText('Original price (for showing discount)'),

                                                        TextInput::make('quantity')
                                                            ->label('Quantity')
                                                            ->numeric()
                                                            ->default(0)
                                                            ->minValue(0)
                                                            ->required()
                                                            ->columnSpan(1)
                                                            ->helperText('Stock quantity'),

                                                        Forms\Components\Select::make('attribute_value_ids')
                                                            ->label('Attributes')
                                                            ->multiple()
                                                            ->options(function ($get, $livewire) {
                                                                $productId = $livewire->record->id ?? null;
                                                                if (!$productId) {
                                                                    return [];
                                                                }

                                                                $attributeValues = \App\Models\ProductAttribureValue::where('product_id', $productId)
                                                                    ->with('attribute')
                                                                    ->get();

                                                                $options = [];
                                                                foreach ($attributeValues as $attrValue) {
                                                                    $label = ($attrValue->attribute->name ?? 'Unknown') . ': ' . $attrValue->getDisplayName();
                                                                    $options[$attrValue->id] = $label;
                                                                }

                                                                return $options;
                                                            })
                                                            ->searchable()
                                                            ->preload()
                                                            ->dehydrated()
                                                            ->columnSpan(1)
                                                            ->helperText('Select attribute values for this SKU'),
                                                    ]),
                                            ])
                                            ->addActionLabel('Add Manual SKU')
                                            ->deleteAction(fn($action) => $action->label('Remove SKU'))
                                            ->reorderableWithButtons()
                                            ->collapsible()
                                            ->itemLabel(fn(array $state): ?string => ($state['sku'] ?? 'New SKU') . ($state['title'] ? ' - ' . $state['title'] : ''))
                                            ->defaultItems(0)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->size(60)
                    ->defaultImageUrl(url('/assets/img/no-image.png')),

                TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->weight(FontWeight::Medium)
                    ->limit(30)
                    ->wrap(),

                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->icon('heroicon-o-hashtag')
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->icon('heroicon-o-cube')
                    ->color(fn(string $state): string => match ($state) {
                        'simple' => 'success',
                        'variable' => 'warning',
                        'grouped' => 'info',
                        'external' => 'danger',
                        'digital' => 'primary',
                        default => 'gray',
                    })
                    ->toggleable(),

                // Simplified category display to prevent memory issues
                TextColumn::make('prodcats_count')
                    ->label('Categories')
                    ->getStateUsing(function (FilamentProduct $record): string {
                        try {
                            $count = $record->prodcats()->count();
                            return $count > 0 ? "{$count} categories" : 'No categories';
                        } catch (\Exception $e) {
                            return 'Error loading';
                        }
                    })
                    ->badge()
                    ->color('secondary')
                    ->icon('heroicon-o-tag')
                    ->toggleable(),

                TextColumn::make('price')
                    ->label('Regular Price')
                    ->money('USD')
                    ->color('success')
                    ->sortable()
                    ->weight(FontWeight::SemiBold),

                TextColumn::make('sale_price')
                    ->label('Sale Price')
                    ->money('USD')
                    ->color('warning')
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('quantity')
                    ->label('Stock')
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => match (true) {
                        $state === null => 'gray',
                        $state > 50 => 'success',
                        $state > 10 => 'warning',
                        $state > 0 => 'danger',
                        default => 'gray'
                    })
                    ->formatStateUsing(fn($state) => $state ?? 'N/A')
                    ->toggleable(),

                TextColumn::make('views')
                    ->label('Views')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-eye')
                    ->toggleable(isToggledHiddenByDefault: true),

                BooleanColumn::make('status')
                    ->label('Active')
                    ->icon('heroicon-o-check-circle')
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                BooleanColumn::make('featured')
                    ->label('Featured')
                    ->icon('heroicon-o-star')
                    ->sortable()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->toggleable(),

                BooleanColumn::make('manage_stock')
                    ->label('Stock Managed')
                    ->icon('heroicon-o-archive-box')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('total_sale')
                    ->label('Sales')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-shopping-cart')
                    ->sortable()
                    ->default(0)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('shipping_cost')
                    ->label('Shipping')
                    ->money('USD')
                    ->color('secondary')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('weight')
                    ->label('Weight (kg)')
                    ->icon('heroicon-o-scale')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('M j, Y g:i A')
                    ->icon('heroicon-o-calendar-days')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime('M j, Y g:i A')
                    ->icon('heroicon-o-arrow-path')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Product Type')
                    ->options([
                        'simple' => 'Simple Product',
                        'variable' => 'Variable Product',
                        'grouped' => 'Grouped Product',
                        'external' => 'External Product',
                        'digital' => 'Digital Product',
                    ])
                    ->multiple(),

                Filter::make('featured')
                    ->query(fn(Builder $query): Builder => $query->where('featured', true))
                    ->label('Featured Products'),

                Filter::make('active')
                    ->query(fn(Builder $query): Builder => $query->where('status', true))
                    ->label('Active Products'),

                Filter::make('inactive')
                    ->query(fn(Builder $query): Builder => $query->where('status', false))
                    ->label('Inactive Products'),

                Filter::make('out_of_stock')
                    ->query(fn(Builder $query): Builder => $query->where('quantity', '<=', 0))
                    ->label('Out of Stock'),

                Filter::make('low_stock')
                    ->query(fn(Builder $query): Builder => $query->whereBetween('quantity', [1, 10]))
                    ->label('Low Stock (1-10)'),

                Filter::make('has_sale_price')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('sale_price')->where('sale_price', '>', 0))
                    ->label('On Sale'),

                Filter::make('variable_products')
                    ->query(fn(Builder $query): Builder => $query->where('is_variable_product', true))
                    ->label('Variable Products'),

                Filter::make('offers')
                    ->query(fn(Builder $query): Builder => $query->where('is_offer', true))
                    ->label('Special Offers'),
                SelectFilter::make('parent_id')
                    ->label('Product Type')
                    ->options([
                        'parent' => 'Parent Products',
                        'child' => 'Child Products (Variations)',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value'] ?? null) {
                            'parent' => $query->whereNull('parent_id'),
                            'child' => $query->whereNotNull('parent_id'),
                            default => $query,
                        };
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->icon('heroicon-o-eye'),
                    Tables\Actions\EditAction::make()
                        ->icon('heroicon-o-pencil'),
                    Tables\Actions\ReplicateAction::make()
                        ->icon('heroicon-o-document-duplicate')
                        ->excludeAttributes(['slug', 'sku'])
                        ->beforeReplicaSaved(function (Product $replica): void {
                            // Modify name and generate new slug
                            $replica->name = $replica->name . ' (Copy)';
                            $replica->slug = Str::slug($replica->name);
                            $replica->sku = null; // Clear SKU to avoid conflicts

                            // Ensure shop_id is set to current user's shop
                            $user = Auth::user();
                            if ($user && $user->shop) {
                                $replica->shop_id = $user->shop->id;
                            }
                        })
                        ->afterReplicaSaved(function (Product $replica, Product $original): void {
                            // Copy the many-to-many relationship (categories)
                            if ($original->prodcats()->exists()) {
                                $categoryIds = $original->prodcats()->pluck('prodcats.id')->toArray();
                                $replica->prodcats()->sync($categoryIds);
                            }
                        }),
                    Tables\Actions\DeleteAction::make()
                        ->icon('heroicon-o-trash'),
                ])
                    ->iconButton()
                    ->tooltip('Actions')
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->icon('heroicon-o-trash'),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn($records) => $records->each(fn($record) => $record->update(['status' => true])))
                        ->color('success')
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn($records) => $records->each(fn($record) => $record->update(['status' => false])))
                        ->color('danger')
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('mark_featured')
                        ->label('Mark as Featured')
                        ->icon('heroicon-o-star')
                        ->action(fn($records) => $records->each(fn($record) => $record->update(['featured' => true])))
                        ->color('warning')
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('unmark_featured')
                        ->label('Remove from Featured')
                        ->icon('heroicon-o-star')
                        ->action(fn($records) => $records->each(fn($record) => $record->update(['featured' => false])))
                        ->color('gray')
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(25)
            ->paginationPageOptions([10, 25, 50, 100])
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
    public static function getLabel(): string
    {
        return 'Product';
    }

    public static function getPluralLabel(): string
    {
        return 'Products';
    }
    public static function getNavigationBadge(): ?string
    {
        try {
            $user = Auth::user();
            if (!$user || !$user->shop) {
                return null;
            }

            // DIRECT QUERY - DON'T USE getEloquentQuery()
            $count = Product::where('shop_id', $user->shop->id)
                ->whereNull('parent_id')
                ->count();
            return $count > 0 ? (string) $count : null;
        } catch (\Exception $e) {
            Log::error('Navigation badge error: ' . $e->getMessage());
            return null;
        }
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->check()) {
            $shop = auth()->user()->shop;
            return $shop && $shop->status == 1;
        }
        return false;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        try {
            $user = Auth::user();
            if (!$user || !$user->shop) {
                return 'primary';
            }

            // SIMPLIFIED: Use direct query instead of static::getModel()
            $lowStockCount = Product::where('shop_id', $user->shop->id)
                ->where('quantity', '<=', 10)
                ->count();
            return $lowStockCount > 0 ? 'warning' : 'primary';
        } catch (\Exception $e) {
            return 'primary';
        }
    }
}