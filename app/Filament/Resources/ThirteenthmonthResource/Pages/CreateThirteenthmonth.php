<?php

namespace App\Filament\Resources\ThirteenthmonthResource\Pages;

use App\Filament\Resources\ThirteenthmonthResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateThirteenthmonth extends CreateRecord
{
    protected static string $resource = ThirteenthmonthResource::class;

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();

        return $resource::getUrl('index');
    }
}
