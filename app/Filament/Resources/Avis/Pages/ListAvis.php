<?php

namespace App\Filament\Resources\Avis\Pages;

use App\Filament\Resources\Avis\AvisResource;
use App\Services\GooglePlacesService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Throwable;

class ListAvis extends ListRecords
{
    protected static string $resource = AvisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('syncGoogleAvis')
                ->label('Synchroniser depuis Google')
                ->icon(Heroicon::OutlinedArrowPath)
                ->color('gray')
                ->action(function (GooglePlacesService $places) {
                    try {
                        $synced = $places->syncReviews();

                        Notification::make()
                            ->title($synced.' avis Google synchronisés')
                            ->success()
                            ->send();
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('Synchronisation impossible')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
            CreateAction::make(),
        ];
    }
}
