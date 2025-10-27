<?php

namespace App\Filament\App\Resources\Employees\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmployeeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Relations Info')
                    ->schema([
                        TextEntry::make('country.name')
                            ->label('Country Name'),
                        TextEntry::make('state.name')
                            ->label('State Name'),
                        TextEntry::make('city.name')
                            ->label('City Name'),
                        TextEntry::make('department.name')
                            ->label('Department Name'),
                    ])
                    ->columns(2),
                Section::make('Name')
                    ->schema([
                        TextEntry::make('first_name'),
                        TextEntry::make('middle_name'),
                        TextEntry::make('last_name'),
                    ])
                    ->columns(3),
                Section::make('Address Info')
                    ->schema([
                        TextEntry::make('address'),
                        TextEntry::make('zip-code'),
                    ])
                    ->columns(2),
                Section::make('Dates Info')
                    ->schema([
                        TextEntry::make('date_of_birth')
                            ->date(),
                        TextEntry::make('date_hired')
                            ->date(),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2),
            ])
            ->columns(1);
    }
}
