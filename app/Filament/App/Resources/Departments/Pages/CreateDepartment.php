<?php

namespace App\Filament\App\Resources\Departments\Pages;

use App\Filament\App\Resources\Departments\DepartmentResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Department Created')
            ->body('Department Created Successfully!');
    }
}
