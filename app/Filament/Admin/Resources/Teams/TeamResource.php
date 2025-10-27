<?php

namespace App\Filament\Admin\Resources\Teams;

use App\Filament\Admin\Resources\Teams\Pages\CreateTeam;
use App\Filament\Admin\Resources\Teams\Pages\EditTeam;
use App\Filament\Admin\Resources\Teams\Pages\ListTeams;
use App\Filament\Admin\Resources\Teams\Pages\ViewTeam;
use App\Filament\Admin\Resources\Teams\RelationManagers\MembersRelationManager;
use App\Filament\Admin\Resources\Teams\Schemas\TeamForm;
use App\Filament\Admin\Resources\Teams\Schemas\TeamInfolist;
use App\Filament\Admin\Resources\Teams\Tables\TeamsTable;
use App\Models\Team;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;


    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static string | UnitEnum | null $navigationGroup = 'User Management';

    protected static ?string $recordTitleAttribute = 'name';

    public static bool $isScopedToTenant = false;

    public static function form(Schema $schema): Schema
    {
        return TeamForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TeamInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeamsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeams::route('/'),
            'create' => CreateTeam::route('/create'),
            'view' => ViewTeam::route('/{record}'),
            'edit' => EditTeam::route('/{record}/edit'),
        ];
    }
}
