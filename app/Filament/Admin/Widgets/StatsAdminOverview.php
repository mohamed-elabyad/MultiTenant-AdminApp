<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Employee;
use App\Models\Team;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::query()->count())
                ->description($this->getGrowthDescription(User::class))
                ->descriptionIcon($this->getGrowthIcon(User::class))
                ->color($this->getGrowthColor(User::class))
                ->chart($this->getChartData(User::class)),

            Stat::make('Employees', Employee::query()->count())
                ->description($this->getGrowthDescription(Employee::class))
                ->descriptionIcon($this->getGrowthIcon(Employee::class))
                ->color($this->getGrowthColor(Employee::class))
                ->chart($this->getChartData(Employee::class)),

            Stat::make('Teams', Team::query()->count())
                ->description($this->getGrowthDescription(Team::class))
                ->descriptionIcon($this->getGrowthIcon(Team::class))
                ->color($this->getGrowthColor(Team::class))
                ->chart($this->getChartData(Team::class)),
        ];
    }

    protected function getGrowthDescription(string $model): string
    {
        $currentMonthCount = $model::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthCount = $model::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        if ($lastMonthCount == 0) {
            return $currentMonthCount . ' new this month';
        }

        $percentageChange = (($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100;
        $percentageChange = round(abs($percentageChange), 1);

        if ($currentMonthCount > $lastMonthCount) {
            return $percentageChange . '% increase';
        } elseif ($currentMonthCount < $lastMonthCount) {
            return $percentageChange . '% decrease';
        } else {
            return 'No change';
        }
    }

    protected function getGrowthIcon(string $model): string
    {
        $currentMonthCount = $model::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthCount = $model::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        return $currentMonthCount >= $lastMonthCount
            ? 'heroicon-m-arrow-trending-up'
            : 'heroicon-m-arrow-trending-down';
    }

    protected function getGrowthColor(string $model): string
    {
        $currentMonthCount = $model::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthCount = $model::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        return $currentMonthCount >= $lastMonthCount ? 'success' : 'danger';
    }

    protected function getChartData(string $model): array
    {
        $cacheKey = strtolower(class_basename($model)) . '-chart-data';

        return cache()->remember($cacheKey, now()->addHours(6), function () use ($model) {
            $data = [];
            $currentYear = now()->year;

            // من شهر 1 لشهر 12 للسنة الحالية
            for ($month = 1; $month <= 12; $month++) {
                $count = $model::whereMonth('created_at', $month)
                    ->whereYear('created_at', $currentYear)
                    ->count();

                $data[] = $count;
            }

            return $data;
        });
    }
}
