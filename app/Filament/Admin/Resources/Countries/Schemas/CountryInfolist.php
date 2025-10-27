<?php

namespace App\Filament\Admin\Resources\Countries\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CountryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Country Info')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Country Name'),
                        TextEntry::make('code'),
                        TextEntry::make('phonecode'),
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
