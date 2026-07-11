<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use App\Enums\ContactMessageStatus;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('status')
                    ->label('Statut')
                    ->options(ContactMessageStatus::class)
                    ->native(false)
                    ->required(),
            ]);
    }
}
