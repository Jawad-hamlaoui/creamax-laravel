<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ImagesDuSite extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Images du site';

    protected static ?int $navigationSort = 7;

    protected static ?string $title = 'Images du site';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::current()->only([
            'logo_path',
            'hero_image_path',
            'apropos_image_1_path',
            'apropos_image_2_path',
            'facebook_url',
            'instagram_url',
        ]));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo_path')
                    ->label('Logo')
                    ->helperText('Affiché dans le menu et le pied de page du site.')
                    ->image()
                    ->disk('public')
                    ->directory('site')
                    ->imageEditor(),
                TextInput::make('facebook_url')
                    ->label('Lien Facebook')
                    ->url()
                    ->maxLength(255),
                TextInput::make('instagram_url')
                    ->label('Lien Instagram')
                    ->url()
                    ->maxLength(255),
                FileUpload::make('hero_image_path')
                    ->label('Photo de la section d\'accueil (Hero)')
                    ->helperText('Grande photo affichée à droite du titre principal, en haut du site.')
                    ->image()
                    ->disk('public')
                    ->directory('site')
                    ->imageEditor(),
                FileUpload::make('apropos_image_1_path')
                    ->label('Photo 1 — section "À propos"')
                    ->image()
                    ->disk('public')
                    ->directory('site')
                    ->imageEditor(),
                FileUpload::make('apropos_image_2_path')
                    ->label('Photo 2 — section "À propos"')
                    ->image()
                    ->disk('public')
                    ->directory('site')
                    ->imageEditor(),
            ])
            ->statePath('data');
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Enregistrer')
                                ->submit('save'),
                        ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        Setting::current()->update($this->form->getState());

        Notification::make()
            ->title('Images mises à jour')
            ->success()
            ->send();
    }
}
