<?php

namespace App\Filament\Admin\Resources\States\RelationManagers;

use App\Filament\Admin\Resources\Cities\CityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class CitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'cities';

    protected static ?string $relatedResource = CityResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
