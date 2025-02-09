<?php

namespace App\Filament\Personal\Widgets;

use App\Models\User;
use App\Models\Holiday;
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

    protected function getStats(): array
    {
        return [
            Stat::make('Pending Holidays', $this->getPendingHolidays(Auth::user()))
                ->icon('heroicon-o-clock'),
            Stat::make('Approved Holidays', $this->getApprovedHolidays(Auth::user()))
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
