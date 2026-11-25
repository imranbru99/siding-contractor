<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ProjectsChart extends ChartWidget
{
    protected static ?string $heading = 'Jobs by Status';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $rows = Project::query()
            ->select('status', DB::raw('count(*) as aggregate'))
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $labels = ['lead', 'quoted', 'scheduled', 'in_progress', 'completed', 'cancelled'];

        return [
            'datasets' => [
                [
                    'label' => 'Projects',
                    'data' => collect($labels)->map(fn ($status) => (int) ($rows[$status] ?? 0))->all(),
                    'backgroundColor' => ['#6B7F76', '#3D7A65', '#C06A2F', '#1A3D32', '#22c55e', '#ef4444'],
                ],
            ],
            'labels' => collect($labels)->map(fn ($s) => str_replace('_', ' ', ucfirst($s)))->all(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
