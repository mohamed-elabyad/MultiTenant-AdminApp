<?php

namespace App\Filament\Admin\Resources\Employees\Schemas;

use App\Models\City;
use App\Models\Department;
use App\Models\State;
use App\Models\Team;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Relations')
                    ->schema([
                        Select::make('country_id')
                            ->relationship('country', titleAttribute: 'name')
                            ->searchable()
                            ->preload()
                            ->label('Country')
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('state_id', null);
                                $set('city_id', null);
                            })
                            ->required(),
                        Select::make('state_id')
                            ->options(fn(Get $get): Collection => State::query()
                                ->where('country_id', $get('country_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->label('State')
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn(Set $set) => $set('city_id', null))
                            ->label('State')
                            ->required(),
                        Select::make('city_id')
                            ->options(fn(Get $get): Collection => City::query()
                                ->where('state_id', $get('state_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->label('City')
                            ->live()
                            ->label('City')
                            ->required(),
                        Select::make('team_id')
                            ->relationship('team', titleAttribute: 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn(Set $set) => $set('department_id', null))
                            ->required(),
                        Select::make('department_id')
                            ->options(fn(Get $get): Collection => Department::query()
                                ->where('team_id', $get('team_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->label('Department')
                            ->required(),
                    ])
                    ->columns(2),
                Section::make('Employee Name')
                    ->description('Put the Employee name in.')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('middle_name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(3),
                Section::make('Address')
                    ->schema([
                        TextInput::make('address')
                            ->required(),
                        TextInput::make('zip-code')
                            ->required(),
                    ])
                    ->columns(2),
                Section::make('Dates')
                    ->schema([
                        DatePicker::make('date_of_birth')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('date_hired')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                    ])->columns(2),
            ])->columns(1);
    }
}
