<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Employee;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestEmployees extends TableWidget
{

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Employee::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('team.name'),
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
