<?php

namespace App\Filament\App\Widgets;

use App\Models\Employee;
use Filament\Actions\BulkActionGroup;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestEmployeesApp extends TableWidget
{

    protected static ?int $sort = 3;


    public function table(Table $table): Table
    {
        return $table
            ->query(Employee::query()->whereBelongsTo(Filament::getTenant()))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('country.name'),
                TextColumn::make('first_name'),
                TextColumn::make('last_name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
