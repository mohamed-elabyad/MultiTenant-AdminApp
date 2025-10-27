<?php

namespace App\Filament\App\Resources\Departments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class DepartmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Department Info')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Department Name'),
                        TextEntry::make('employees_count')
                            ->state(function (Model $record): int {
                                return $record->employees()->count();
                            }),
                    ])
                    ->columns(2),
                // TextEntry::make('created_at')
                //     ->dateTime()
                //     ->placeholder('-'),
                // TextEntry::make('updated_at')
                //     ->dateTime()
                //     ->placeholder('-'),
            ])->columns(1);
    }
}
