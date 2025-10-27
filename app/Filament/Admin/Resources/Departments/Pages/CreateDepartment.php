<?php

namespace App\Filament\Admin\Resources\Departments\Pages;

use App\Filament\Admin\Resources\Departments\DepartmentResource;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use WpOrg\Requests\Auth;

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
