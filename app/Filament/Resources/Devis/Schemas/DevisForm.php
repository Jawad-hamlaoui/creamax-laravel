<?php

namespace App\Filament\Resources\Devis\Schemas;

use App\Enums\DevisStatus;
use App\Models\Prestation;
use App\Models\Setting;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class DevisForm
{
    const VALIDITES = [
        15 => '15 jours',
        30 => '30 jours',
        60 => '60 jours',
        90 => '90 jours',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations générales')
                    ->columns(2)
                    ->components([
                        Select::make('client_id')
                            ->label('Client')
                            ->relationship('client', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->prenom} {$record->nom} — {$record->email}")
                            ->searchable(['prenom', 'nom', 'email'])
                            ->preload()
                            ->required(),
                        DatePicker::make('date_creation')
                            ->label('Date du devis')
                            ->default(now())
                            ->required(),
                        Select::make('validite_jours')
                            ->label('Validité')
                            ->options(self::VALIDITES)
                            ->default(30)
                            ->native(false)
                            ->required(),
                        Select::make('status')
                            ->label('Statut')
                            ->options(DevisStatus::class)
                            ->default(DevisStatus::Brouillon)
                            ->native(false)
                            ->required(),
                        Textarea::make('notes')
                            ->label('Notes / Conditions particulières')
                            ->columnSpanFull(),
                    ]),

                Section::make('Lignes de prestation')
                    ->components([
                        Repeater::make('lignes')
                            ->relationship('lignes')
                            ->label('')
                            ->orderColumn('ordre')
                            ->reorderable()
                            ->live()
                            ->addActionLabel('+ Ajouter une ligne')
                            ->schema([
                                Select::make('prestation_id')
                                    ->label('Depuis le catalogue (optionnel)')
                                    ->options(fn () => Prestation::query()->pluck('titre', 'id'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        if (! $presta = Prestation::find($state)) {
                                            return;
                                        }

                                        $set('description', "{$presta->titre} (par {$presta->unite->getLabel()})");
                                        $set('prix_unitaire', (string) $presta->prix);
                                    })
                                    ->columnSpanFull(),
                                TextInput::make('description')
                                    ->label('Description')
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('quantite')
                                    ->label('Qté')
                                    ->numeric()
                                    ->step(0.5)
                                    ->default(1)
                                    ->live(onBlur: true)
                                    ->required(),
                                TextInput::make('prix_unitaire')
                                    ->label('Prix unit. €')
                                    ->numeric()
                                    ->step(0.01)
                                    ->default(0)
                                    ->live(onBlur: true)
                                    ->required(),
                                Placeholder::make('ligne_total')
                                    ->label('Total HT')
                                    ->content(function (Get $get) {
                                        $total = (float) ($get('quantite') ?? 0) * (float) ($get('prix_unitaire') ?? 0);

                                        return number_format($total, 2, ',', ' ').' €';
                                    }),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->minItems(1)
                            ->required(),

                        Placeholder::make('totaux')
                            ->label('')
                            ->content(function (Get $get) {
                                $lignes = collect($get('lignes') ?? []);
                                $sousTotal = $lignes->sum(fn ($l) => (float) ($l['quantite'] ?? 0) * (float) ($l['prix_unitaire'] ?? 0));
                                $tvaTaux = (float) Setting::current()->taux_tva;
                                $tvaMontant = $sousTotal * $tvaTaux / 100;
                                $total = $sousTotal + $tvaMontant;
                                $tvaTauxLabel = rtrim(rtrim(number_format($tvaTaux, 2), '0'), '.');

                                return new HtmlString(sprintf(
                                    '<div class="text-sm space-y-1 text-right"><div>Sous-total : <strong>%s €</strong></div><div>TVA (%s%%) : <strong>%s €</strong></div><div class="text-base">Total TTC : <strong>%s €</strong></div></div>',
                                    number_format($sousTotal, 2, ',', ' '),
                                    $tvaTauxLabel,
                                    number_format($tvaMontant, 2, ',', ' '),
                                    number_format($total, 2, ',', ' '),
                                ));
                            }),
                    ]),
            ]);
    }
}
