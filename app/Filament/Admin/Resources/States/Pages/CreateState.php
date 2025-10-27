<?php

namespace App\Filament\Admin\Resources\States\Pages;

use App\Filament\Admin\Resources\States\StateResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateState extends CreateRecord
{
    protected static string $resource = StateResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('State Created')
            ->body('State Created Successfully!');
    }
}
