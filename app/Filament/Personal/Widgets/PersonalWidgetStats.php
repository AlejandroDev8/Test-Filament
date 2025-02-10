<?php

namespace App\Filament\Personal\Widgets;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Holiday;

use App\Models\Timesheet;

use function Pest\Laravel\get;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PersonalWidgetStats extends BaseWidget
{
    protected function getPendingHolidays(User $user)
    {
        $totalPendingHolidays = Holiday::where('user_id', $user->id)
            ->where('type', 'pending')->get()->count();
        return $totalPendingHolidays;
    }

    protected function getApprovedHolidays(User $user)
    {
        $totalApprovedHolidays = Holiday::where('user_id', $user->id)
            ->where('type', 'approved')->get()->count();
        return $totalApprovedHolidays;
    }

    protected function getTotalWork(User $user)
    {
        $timeSheets  = Timesheet::where('user_id', $user->id)
            ->where('type', 'work')->get();
        $sumHours = 0;

        foreach ($timeSheets as $timeSheet) {
            $startTime = Carbon::parse($timeSheet->day_in);
            $endTime = Carbon::parse($timeSheet->day_out);

            $hours = $startTime->diffInSeconds($endTime);
            $sumHours += $hours;
        }

        $timeFormat = gmdate('H:i:s', $sumHours);

        return $timeFormat;
    }

    protected function getTotalPause()
    {
        $timeSheets  = Timesheet::where('user_id', Auth::user()->id)
            ->where('type', 'pause')->get();
        $sumHours = 0;

        foreach ($timeSheets as $timeSheet) {
            $startTime = Carbon::parse($timeSheet->day_in);
            $endTime = Carbon::parse($timeSheet->day_out);

            $hours = $startTime->diffInSeconds($endTime);
            $sumHours += $hours;
        }

        $timeFormat = gmdate('H:i:s', $sumHours);

        return $timeFormat;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Pending Holidays', $this->getPendingHolidays(Auth::user()))
                ->icon('heroicon-o-clock'),
            Stat::make('Approved Holidays', $this->getApprovedHolidays(Auth::user()))
                ->icon('heroicon-o-check-circle'),
            Stat::make('Total Work', $this->getTotalWork(Auth::user()))
                ->icon('heroicon-o-calendar'),
            Stat::make('Total Pause', $this->getTotalPause())
                ->icon('heroicon-o-pause'),
        ];
    }
}
