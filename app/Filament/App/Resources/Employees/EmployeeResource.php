<?php

namespace App\Filament\App\Resources\Employees;

use App\Filament\App\Resources\Employees\Pages\CreateEmployee;
use App\Filament\App\Resources\Employees\Pages\EditEmployee;
use App\Filament\App\Resources\Employees\Pages\ListEmployees;
use App\Filament\App\Resources\Employees\Pages\ViewEmployee;
use App\Filament\App\Resources\Employees\Schemas\EmployeeForm;
use App\Filament\App\Resources\Employees\Schemas\EmployeeInfolist;
use App\Filament\App\Resources\Employees\Tables\EmployeesTable;
use App\Models\Employee;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;


    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static ?string $recordTitleAttribute = 'first_name';

    public static function form(Schema $schema): Schema
    {
        return EmployeeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EmployeeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmployeesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmployees::route('/'),
            'create' => CreateEmployee::route('/create'),
            'view' => ViewEmployee::route('/{record}'),
            'edit' => EditEmployee::route('/{record}/edit'),
        ];
    }
}
