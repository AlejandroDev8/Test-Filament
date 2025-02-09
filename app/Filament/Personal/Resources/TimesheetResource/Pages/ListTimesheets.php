<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Personal\Resources\TimesheetResource;
use App\Models\Timesheet;
use Carbon\Carbon;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('In Work')
                ->color('success')
                ->label('Entrar a trabajar')
                ->requiresConfirmation()
                ->action(function () {
                    $user = Auth::user();
                    $timeSheet = new Timesheet();
                    $timeSheet->user_id = $user->id;
                    $timeSheet->calendar_id = 1;
                    $timeSheet->type = 'work';
                    $timeSheet->day_in = Carbon::now();
                    $timeSheet->day_out = Carbon::now();
                    $timeSheet->save();
                }),
            Action::make('In Pause')
                ->color('info')
                ->label('Tomar un descanso')
                ->requiresConfirmation(),
            Actions\CreateAction::make(),
        ];
    }
}
