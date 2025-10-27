<?php

namespace App\Filament\Admin\Resources\Cities\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('City Info')
                    ->schema([
                        TextEntry::make('state.name')
                            ->label('State Name'),
                        TextEntry::make('name')
                            ->label('City Name'),
                    ])
                    ->columns(2),
                // TextEntry::make('created_at')
                //     ->dateTime()
                //     ->placeholder('-'),
                // TextEntry::make('updated_at')
                //     ->dateTime()
                //     ->placeholder('-'),
            ])
            ->columns(1);
    }
}
