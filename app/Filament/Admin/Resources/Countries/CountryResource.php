<?php

namespace App\Filament\Admin\Resources\Countries;

use App\Filament\Admin\Resources\Countries\Pages\CreateCountry;
use App\Filament\Admin\Resources\Countries\Pages\EditCountry;
use App\Filament\Admin\Resources\Countries\Pages\ListCountries;
use App\Filament\Admin\Resources\Countries\Pages\ViewCountry;
use App\Filament\Admin\Resources\Countries\RelationManagers\EmployeesRelationManager;
use App\Filament\Admin\Resources\Countries\RelationManagers\StatesRelationManager;
use App\Filament\Admin\Resources\Countries\Schemas\CountryForm;
use App\Filament\Admin\Resources\Countries\Schemas\CountryInfolist;
use App\Filament\Admin\Resources\Countries\Tables\CountriesTable;
use App\Models\Country;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;


class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Flag;

    protected static ?string $navigationLabel = 'Country';

    protected static string | UnitEnum | null $navigationGroup = 'System Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Country';

    protected static ?string $recordTitleAttribute = 'name';

    public static bool $isScopedToTenant = false;

    public static function form(Schema $schema): Schema
    {
        return CountryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CountryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CountriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            StatesRelationManager::class,
            EmployeesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCountries::route('/'),
            'create' => CreateCountry::route('/create'),
            'view' => ViewCountry::route('/{record}'),
            'edit' => EditCountry::route('/{record}/edit'),
        ];
    }
}
