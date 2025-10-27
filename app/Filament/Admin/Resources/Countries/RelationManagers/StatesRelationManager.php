<?php

namespace App\Filament\Admin\Resources\Countries\RelationManagers;

use App\Filament\Admin\Resources\States\StateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class StatesRelationManager extends RelationManager
{
    protected static string $relationship = 'states';

    protected static ?string $relatedResource = StateResource::class;

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
