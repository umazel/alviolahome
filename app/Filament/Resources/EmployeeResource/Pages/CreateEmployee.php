<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();

        // if ($resource::hasPage('view') && $resource::canView($this->record)) {
        //     return $resource::getUrl('view', ['record' => $this->record]);
        // }

        // if ($resource::hasPage('edit') && $resource::canEdit($this->record)) {
        //     return $resource::getUrl('edit', ['record' => $this->record]);
        // }

        return $resource::getUrl('index');
    }
}
