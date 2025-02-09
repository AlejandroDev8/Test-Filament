<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Holiday;
use App\Models\Timesheet;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalUsers = User::all()->count();
        $totalHolidays = Holiday::all()->count();
        $totalTimesheets = Timesheet::all()->count();

        return [
            Stat::make('Users', $totalUsers),
            Stat::make('Holidays', $totalHolidays),
            Stat::make('Timesheets', $totalTimesheets),
        ];
    }
}
