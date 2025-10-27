<?php

namespace App\Filament\App\Resources\Employees\Schemas;

use App\Models\City;
use App\Models\State;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
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
                            ->required(),
                        Select::make('city_id')
                            ->options(fn(Get $get): Collection => City::query()
                                ->where('state_id', $get('state_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->label('City')
                            ->live()
                            ->required(),
                        Select::make('department_id')
                            ->relationship(
                                'department',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn(Builder $query) => $query->whereBelongsTo(Filament::getTenant())
                            )
                            ->searchable()
                            ->preload()
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
