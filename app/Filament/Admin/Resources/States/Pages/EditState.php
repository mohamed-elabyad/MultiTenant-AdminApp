<?php

namespace App\Filament\Admin\Resources\States\Pages;

use App\Filament\Admin\Resources\States\StateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditState extends EditRecord
{
    protected static string $resource = StateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }


    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
        ->success()
        ->title('State Updated')
        ->body('State Updated Successfully!');
    }
}
