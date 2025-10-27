<?php

namespace App\Filament\App\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAppOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $tenant = Filament::getTenant();

        return [
            Stat::make('Users', $tenant->members()->count())
                ->description($this->getGrowthDescription($tenant, 'members'))
                ->descriptionIcon($this->getGrowthIcon($tenant, 'members'))
                ->color($this->getGrowthColor($tenant, 'members'))
                ->chart($this->getChartData($tenant, 'members')),

            Stat::make('Departments', $tenant->departments()->count())
                ->description($this->getGrowthDescription($tenant, 'departments'))
                ->descriptionIcon($this->getGrowthIcon($tenant, 'departments'))
                ->color($this->getGrowthColor($tenant, 'departments'))
                ->chart($this->getChartData($tenant, 'departments')),

            Stat::make('Employees', $tenant->employees()->count())
                ->description($this->getGrowthDescription($tenant, 'employees'))
                ->descriptionIcon($this->getGrowthIcon($tenant, 'employees'))
                ->color($this->getGrowthColor($tenant, 'employees'))
                ->chart($this->getChartData($tenant, 'employees')),
        ];
    }

    protected function getGrowthDescription($tenant, string $relation): string
    {
        // للـ members (many-to-many) نستخدم wherePivot
        if ($relation === 'members') {
            $currentMonthCount = $tenant->$relation()
                ->wherePivot('created_at', '>=', now()->startOfMonth())
                ->count();

            $lastMonthCount = $tenant->$relation()
                ->wherePivot('created_at', '>=', now()->subMonth()->startOfMonth())
                ->wherePivot('created_at', '<', now()->startOfMonth())
                ->count();
        } else {
            // للـ departments & employees (hasMany) نستخدم whereMonth
            $currentMonthCount = $tenant->$relation()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            $lastMonthCount = $tenant->$relation()
                ->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)
                ->count();
        }

        if ($lastMonthCount == 0) {
            return $currentMonthCount . ' new this month';
        }

        $percentageChange = (($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100;
        $percentageChange = round(abs($percentageChange), 1);

        if ($currentMonthCount > $lastMonthCount) {
            return $percentageChange . '% increase';
        } elseif ($currentMonthCount < $lastMonthCount) {
            return $percentageChange . '% decrease';
        }

        return 'No change';
    }

    protected function getGrowthIcon($tenant, string $relation): string
    {
        if ($relation === 'members') {
            $currentMonthCount = $tenant->$relation()
                ->wherePivot('created_at', '>=', now()->startOfMonth())
                ->count();

            $lastMonthCount = $tenant->$relation()
                ->wherePivot('created_at', '>=', now()->subMonth()->startOfMonth())
                ->wherePivot('created_at', '<', now()->startOfMonth())
                ->count();
        } else {
            $currentMonthCount = $tenant->$relation()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            $lastMonthCount = $tenant->$relation()
                ->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)
                ->count();
        }

        return $currentMonthCount >= $lastMonthCount
            ? 'heroicon-m-arrow-trending-up'
            : 'heroicon-m-arrow-trending-down';
    }

    protected function getGrowthColor($tenant, string $relation): string
    {
        if ($relation === 'members') {
            $currentMonthCount = $tenant->$relation()
                ->wherePivot('created_at', '>=', now()->startOfMonth())
                ->count();

            $lastMonthCount = $tenant->$relation()
                ->wherePivot('created_at', '>=', now()->subMonth()->startOfMonth())
                ->wherePivot('created_at', '<', now()->startOfMonth())
                ->count();
        } else {
            $currentMonthCount = $tenant->$relation()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            $lastMonthCount = $tenant->$relation()
                ->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)
                ->count();
        }

        return $currentMonthCount >= $lastMonthCount ? 'success' : 'danger';
    }

    protected function getChartData($tenant, string $relation): array
    {
        $cacheKey = 'team-' . $tenant->id . '-' . $relation . '-chart-data';

        return cache()->remember($cacheKey, now()->addHours(6), function () use ($tenant, $relation) {
            $data = [];
            $currentYear = now()->year;

            for ($month = 1; $month <= 12; $month++) {
                if ($relation === 'members') {
                    // للـ members نستخدم wherePivot
                    $startDate = now()->setYear($currentYear)->setMonth($month)->startOfMonth();
                    $endDate = $startDate->copy()->endOfMonth();

                    $count = $tenant->$relation()
                        ->wherePivot('created_at', '>=', $startDate)
                        ->wherePivot('created_at', '<=', $endDate)
                        ->count();
                } else {
                    // للـ departments & employees نستخدم whereMonth
                    $count = $tenant->$relation()
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $currentYear)
                        ->count();
                }

                $data[] = $count;
            }

            return $data;
        });
    }
}
