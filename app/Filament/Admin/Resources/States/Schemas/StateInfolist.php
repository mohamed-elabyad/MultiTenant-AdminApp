<?php

namespace App\Filament\Admin\Resources\States\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('State Info')
                    ->schema([
                        TextEntry::make('country.name')
                            ->label('Country Name'),
                        TextEntry::make('name')
                            ->label('State Name'),
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
