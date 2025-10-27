<?php

namespace App\Filament\Admin\Resources\States;

use App\Filament\Admin\Resources\States\Pages\CreateState;
use App\Filament\Admin\Resources\States\Pages\EditState;
use App\Filament\Admin\Resources\States\Pages\ListStates;
use App\Filament\Admin\Resources\States\Pages\ViewState;
use App\Filament\Admin\Resources\States\RelationManagers\CitiesRelationManager;
use App\Filament\Admin\Resources\States\RelationManagers\EmployeesRelationManager;
use App\Filament\Admin\Resources\States\Schemas\StateForm;
use App\Filament\Admin\Resources\States\Schemas\StateInfolist;
use App\Filament\Admin\Resources\States\Tables\StatesTable;
use App\Models\State;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingLibrary;

    protected static ?string $navigationLabel = 'State';

    protected static string | UnitEnum | null $navigationGroup = 'System Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'State';

    protected static ?string $recordTitleAttribute = 'name';

    public static bool $isScopedToTenant = false;

    public static function form(Schema $schema): Schema
    {
        return StateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CitiesRelationManager::class,
            EmployeesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStates::route('/'),
            'create' => CreateState::route('/create'),
            'view' => ViewState::route('/{record}'),
            'edit' => EditState::route('/{record}/edit'),
        ];
    }
}
