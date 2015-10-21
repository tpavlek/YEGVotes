<?php

namespace Depotwarehouse\YEGVotes\Console;

use Depotwarehouse\YEGVotes\Console\Commands\UpdateAgendaCommand;
use Depotwarehouse\YEGVotes\Console\Commands\UpdateAllData;
use Depotwarehouse\YEGVotes\Console\Commands\UpdateAttendanceCommand;
use Depotwarehouse\YEGVotes\Console\Commands\UpdateMeetingsCommand;
use Depotwarehouse\YEGVotes\Console\Commands\UpdateMotionsCommand;
use Depotwarehouse\YEGVotes\Console\Commands\UpdateVotesCommand;
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
