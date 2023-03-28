<?php

namespace App\Filament\Resources\ThirteenthmonthResource\Pages;

use App\Filament\Resources\ThirteenthmonthResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditThirteenthmonth extends EditRecord
{
    protected static string $resource = ThirteenthmonthResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('index');
    }
}
