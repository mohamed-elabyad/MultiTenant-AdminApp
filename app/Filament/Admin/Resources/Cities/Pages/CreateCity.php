<?php

namespace App\Filament\Admin\Resources\Cities\Pages;

use App\Filament\Admin\Resources\Cities\CityResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('City Created')
            ->body('City Created Successfully!');
    }
}
