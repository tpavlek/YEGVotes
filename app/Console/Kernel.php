<?php

namespace App\Console;

use App\Console\Commands\CrawlAgendaCommand;
use App\Console\Commands\UpdateAgendaCommand;
use App\Console\Commands\UpdateAllData;
use App\Console\Commands\UpdateAttendanceCommand;
use App\Console\Commands\UpdateCouncillorsCommand;
use App\Console\Commands\UpdateMeetingsCommand;
use App\Console\Commands\UpdateMotionsCommand;
use App\Console\Commands\UpdateVotesCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdateMeetingsCommand::class,
        UpdateAttendanceCommand::class,
        UpdateAgendaCommand::class,
        UpdateMotionsCommand::class,
        UpdateVotesCommand::class,
        UpdateAllData::class,
        UpdateCouncillorsCommand::class,
        CrawlAgendaCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    }
}
