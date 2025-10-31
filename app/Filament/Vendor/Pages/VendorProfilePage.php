<?php

namespace App\Filament\Vendor\Pages;

use App\Models\Shop;
use Closure;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Filament\Forms\Form;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\text;

class VendorProfilePage extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static string $view = 'filament.vendor.pages.vendor-profile-page';
    protected static ?string $title = 'Profile Settings';

    public array $data = [];
    public array $shopData = [];

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make('Profile')
                ->url(fn() => route('filament.vendor.pages.vendor-profile-page'))
                ->icon('heroicon-o-user-circle')
                ->group('Profile')
                ->sort(1),
        ];
    }

    public function mount(): void
    {
        $user = Auth::user();
        $shop = $user->shop;
        // Fill shop data
        $this->form->fill([
            'shopData' => [
                'name' => $shop->name ?? '',
                'slug' => $shop->slug ?? '',
                'company_name' => $shop->company_name ?? '',
                'short_description' => $shop->short_description ?? '',
                'description' => $shop->description ?? '',
                'phone' => $shop->phone ?? '',
                'company_registration' => $shop->company_registration ?? '',
                'email' => $shop->email ?? '',
                'country' => $shop->country ?? '',
                'post_code' => $shop->post_code ?? '',
                'city' => $shop->city ?? '',
                'state' => $shop->state ?? '',
                'social_links' => $shop->social_links ?? []
            ]
        ]);
    }


    public function form(Form $form): Form
    {

        return $form
            ->schema([

                Grid::make(2)
                    ->schema([
                        TextInput::make('shopData.name')
                            ->label('Shop Name')
                            ->required()
                            ->live(true)
                            ->afterStateUpdated(fn(string $context, $state, callable $set) => $set('shopData.slug', Str::slug($state)))
                            ->maxLength(255),

                        TextInput::make('shopData.slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Shop::class, 'slug', ignoreRecord: true)
                            ->rules(['alpha_dash']),

                        TextInput::make('shopData.company_name')
                            ->label('Company name')
                            ->nullable()
                            ->maxLength(255),
                        TextInput::make('shopData.phone')
                            ->label('Shop Phone')
                            ->tel()
                            ->maxLength(20),
                        TextInput::make('shopData.company_registration')
                            ->label('Company Registration')
                            ->nullable()

                            ->maxLength(255),
                        TextInput::make('shopData.email')
                            ->label('Shop Email')
                            ->email()
                            // ->readOnly()
                            ->maxLength(255),
                        Select::make('shopData.country')
                            ->label('Shop Country')
                            ->options([
                                'Afghanistan' => 'Afghanistan',
                                'Albania' => 'Albania',
                                'Algeria' => 'Algeria',
                                'Andorra' => 'Andorra',
                                'Angola' => 'Angola',
                                'Argentina' => 'Argentina',
                                'Armenia' => 'Armenia',
                                'Australia' => 'Australia',
                                'Austria' => 'Austria',
                                'Azerbaijan' => 'Azerbaijan',
                                'Bahamas' => 'Bahamas',
                                'Bahrain' => 'Bahrain',
                                'Bangladesh' => 'Bangladesh',
                                'Belarus' => 'Belarus',
                                'Belgium' => 'Belgium',
                                'Belize' => 'Belize',
                                'Benin' => 'Benin',
                                'Bhutan' => 'Bhutan',
                                'Bolivia' => 'Bolivia',
                                'Bosnia and Herzegovina' => 'Bosnia and Herzegovina',
                                'Botswana' => 'Botswana',
                                'Brazil' => 'Brazil',
                                'Brunei' => 'Brunei',
                                'Bulgaria' => 'Bulgaria',
                                'Burkina Faso' => 'Burkina Faso',
                                'Burundi' => 'Burundi',
                                'Cambodia' => 'Cambodia',
                                'Cameroon' => 'Cameroon',
                                'Canada' => 'Canada',
                                'Cape Verde' => 'Cape Verde',
                                'Central African Republic' => 'Central African Republic',
                                'Chad' => 'Chad',
                                'Chile' => 'Chile',
                                'China' => 'China',
                                'Colombia' => 'Colombia',
                                'Comoros' => 'Comoros',
                                'Congo' => 'Congo',
                                'Costa Rica' => 'Costa Rica',
                                'Croatia' => 'Croatia',
                                'Cuba' => 'Cuba',
                                'Cyprus' => 'Cyprus',
                                'Czech Republic' => 'Czech Republic',
                                'Denmark' => 'Denmark',
                                'Djibouti' => 'Djibouti',
                                'Dominica' => 'Dominica',
                                'Dominican Republic' => 'Dominican Republic',
                                'Ecuador' => 'Ecuador',
                                'Egypt' => 'Egypt',
                                'El Salvador' => 'El Salvador',
                                'Equatorial Guinea' => 'Equatorial Guinea',
                                'Eritrea' => 'Eritrea',
                                'Estonia' => 'Estonia',
                                'Eswatini' => 'Eswatini',
                                'Ethiopia' => 'Ethiopia',
                                'Fiji' => 'Fiji',
                                'Finland' => 'Finland',
                                'France' => 'France',
                                'Gabon' => 'Gabon',
                                'Gambia' => 'Gambia',
                                'Georgia' => 'Georgia',
                                'Germany' => 'Germany',
                                'Ghana' => 'Ghana',
                                'Greece' => 'Greece',
                                'Grenada' => 'Grenada',
                                'Guatemala' => 'Guatemala',
                                'Guinea' => 'Guinea',
                                'Guinea-Bissau' => 'Guinea-Bissau',
                                'Guyana' => 'Guyana',
                                'Haiti' => 'Haiti',
                                'Honduras' => 'Honduras',
                                'Hungary' => 'Hungary',
                                'Iceland' => 'Iceland',
                                'India' => 'India',
                                'Indonesia' => 'Indonesia',
                                'Iran' => 'Iran',
                                'Iraq' => 'Iraq',
                                'Ireland' => 'Ireland',
                                'Israel' => 'Israel',
                                'Italy' => 'Italy',
                                'Jamaica' => 'Jamaica',
                                'Japan' => 'Japan',
                                'Jordan' => 'Jordan',
                                'Kazakhstan' => 'Kazakhstan',
                                'Kenya' => 'Kenya',
                                'Kiribati' => 'Kiribati',
                                'Kuwait' => 'Kuwait',
                                'Kyrgyzstan' => 'Kyrgyzstan',
                                'Laos' => 'Laos',
                                'Latvia' => 'Latvia',
                                'Lebanon' => 'Lebanon',
                                'Lesotho' => 'Lesotho',
                                'Liberia' => 'Liberia',
                                'Libya' => 'Libya',
                                'Liechtenstein' => 'Liechtenstein',
                                'Lithuania' => 'Lithuania',
                                'Luxembourg' => 'Luxembourg',
                                'Madagascar' => 'Madagascar',
                                'Malawi' => 'Malawi',
                                'Malaysia' => 'Malaysia',
                                'Maldives' => 'Maldives',
                                'Mali' => 'Mali',
                                'Malta' => 'Malta',
                                'Mauritania' => 'Mauritania',
                                'Mauritius' => 'Mauritius',
                                'Mexico' => 'Mexico',
                                'Moldova' => 'Moldova',
                                'Monaco' => 'Monaco',
                                'Mongolia' => 'Mongolia',
                                'Montenegro' => 'Montenegro',
                                'Morocco' => 'Morocco',
                                'Mozambique' => 'Mozambique',
                                'Myanmar' => 'Myanmar',
                                'Namibia' => 'Namibia',
                                'Nepal' => 'Nepal',
                                'Netherlands' => 'Netherlands',
                                'New Zealand' => 'New Zealand',
                                'Nicaragua' => 'Nicaragua',
                                'Niger' => 'Niger',
                                'Nigeria' => 'Nigeria',
                                'North Korea' => 'North Korea',
                                'North Macedonia' => 'North Macedonia',
                                'Norway' => 'Norway',
                                'Oman' => 'Oman',
                                'Pakistan' => 'Pakistan',
                                'Palau' => 'Palau',
                                'Palestine' => 'Palestine',
                                'Panama' => 'Panama',
                                'Papua New Guinea' => 'Papua New Guinea',
                                'Paraguay' => 'Paraguay',
                                'Peru' => 'Peru',
                                'Philippines' => 'Philippines',
                                'Poland' => 'Poland',
                                'Portugal' => 'Portugal',
                                'Qatar' => 'Qatar',
                                'Romania' => 'Romania',
                                'Russia' => 'Russia',
                                'Rwanda' => 'Rwanda',
                                'Saint Kitts and Nevis' => 'Saint Kitts and Nevis',
                                'Saint Lucia' => 'Saint Lucia',
                                'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines',
                                'Samoa' => 'Samoa',
                                'San Marino' => 'San Marino',
                                'Saudi Arabia' => 'Saudi Arabia',
                                'Senegal' => 'Senegal',
                                'Serbia' => 'Serbia',
                                'Seychelles' => 'Seychelles',
                                'Sierra Leone' => 'Sierra Leone',
                                'Singapore' => 'Singapore',
                                'Slovakia' => 'Slovakia',
                                'Slovenia' => 'Slovenia',
                                'Solomon Islands' => 'Solomon Islands',
                                'Somalia' => 'Somalia',
                                'South Africa' => 'South Africa',
                                'South Korea' => 'South Korea',
                                'South Sudan' => 'South Sudan',
                                'Spain' => 'Spain',
                                'Sri Lanka' => 'Sri Lanka',
                                'Sudan' => 'Sudan',
                                'Suriname' => 'Suriname',
                                'Sweden' => 'Sweden',
                                'Switzerland' => 'Switzerland',
                                'Syria' => 'Syria',
                                'Taiwan' => 'Taiwan',
                                'Tajikistan' => 'Tajikistan',
                                'Tanzania' => 'Tanzania',
                                'Thailand' => 'Thailand',
                                'Togo' => 'Togo',
                                'Tonga' => 'Tonga',
                                'Trinidad and Tobago' => 'Trinidad and Tobago',
                                'Tunisia' => 'Tunisia',
                                'Turkey' => 'Turkey',
                                'Turkmenistan' => 'Turkmenistan',
                                'Tuvalu' => 'Tuvalu',
                                'Uganda' => 'Uganda',
                                'Ukraine' => 'Ukraine',
                                'United Arab Emirates' => 'United Arab Emirates',
                                'United Kingdom' => 'United Kingdom',
                                'United States' => 'United States',
                                'Uruguay' => 'Uruguay',
                                'Uzbekistan' => 'Uzbekistan',
                                'Vanuatu' => 'Vanuatu',
                                'Vatican City' => 'Vatican City',
                                'Venezuela' => 'Venezuela',
                                'Vietnam' => 'Vietnam',
                                'Yemen' => 'Yemen',
                                'Zambia' => 'Zambia',
                                'Zimbabwe' => 'Zimbabwe',
                            ])
                            ->searchable(),
                    ]),
                Grid::make(3)
                    ->schema([
                        TextInput::make('shopData.city')
                            ->label('City')
                            ->maxLength(100),
                        TextInput::make('shopData.state')
                            ->label('State/Province')
                            ->maxLength(100),
                        TextInput::make('shopData.post_code')
                            ->label('Postal Code')
                            ->maxLength(20),
                    ]),

                Textarea::make('shopData.short_description')
                    ->label('Short description')
                    ->rows(4)
                    ->maxLength(500),
                RichEditor::make('shopData.description')
                    ->label('Description')
                    ->nullable()
                    ->maxLength(1000),
                Section::make('Social Links')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('shopData.social_links.tiktok')
                                  
                                    ->label('TikTok')
                                    ->url()
                                    ->nullable()
                                    ->maxLength(255),

                                TextInput::make('shopData.social_links.instagram')
                                    ->label('Instagram')
                                    ->url()
                                    ->nullable()
                                    ->maxLength(255),

                            ]),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public function submit()
    {
        $user = Auth::user();
        $shop = $user->shop;

        // Update shop data
        if ($shop) {
            $shop->update([
                'name' => $this->shopData['name'],
                'slug' => $this->shopData['slug'],
                'company_name' => $this->shopData['company_name'],
                'short_description' => $this->shopData['short_description'],
                'description' => $this->shopData['description'],
                'phone' => $this->shopData['phone'],
                'company_registration' => $this->shopData['company_registration'],
                'email' => $this->shopData['email'],
                'post_code' => $this->shopData['post_code'],
                'city' => $this->shopData['city'],
                'state' => $this->shopData['state'],
                'country' => $this->shopData['country'],
                'social_links' => $this->shopData['social_links'] ?? []
            ]);
        }

        Notification::make()
            ->title('Success')
            ->body('Profile updated successfully!')
            ->success()
            ->send();
    }
}
