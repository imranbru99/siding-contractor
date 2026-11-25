<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $openJobs = Project::query()->whereIn('status', ['lead', 'quoted', 'scheduled', 'in_progress'])->count();
        $pipeline = (float) Project::query()->whereIn('status', ['quoted', 'scheduled', 'in_progress'])->sum('estimated_value');
        $collected = (float) Invoice::query()->sum('amount_paid');
        $upcoming = Appointment::query()->where('starts_at', '>=', now())->where('status', '!=', 'cancelled')->count();

        return [
            Stat::make('Active Jobs', (string) $openJobs)
                ->description('Leads through in-progress finishes')
                ->descriptionIcon('heroicon-m-home-modern')
                ->color('success'),
            Stat::make('Pipeline Value', '$'.number_format($pipeline, 0))
                ->description('Quoted & active project estimates')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),
            Stat::make('Payments Collected', '$'.number_format($collected, 0))
                ->description('All-time invoice receipts')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
            Stat::make('Customers', (string) Customer::query()->count())
                ->description($upcoming.' upcoming appointments')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
        ];
    }
}
