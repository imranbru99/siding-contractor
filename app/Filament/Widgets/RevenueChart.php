<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Payments (Last 6 Months)';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $labels = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M Y');
            $data[] = (float) Payment::query()
                ->whereYear('paid_at', $month->year)
                ->whereMonth('paid_at', $month->month)
                ->sum('amount');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Collected ($)',
                    'data' => $data,
                    'borderColor' => '#1E4D3C',
                    'backgroundColor' => 'rgba(42, 157, 143, 0.25)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
