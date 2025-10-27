<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Employee;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class EmployeeAdminChart extends ChartWidget
{
    protected ?string $heading = 'Employees Chart';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Trend::model(Employee::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Employees Start',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
