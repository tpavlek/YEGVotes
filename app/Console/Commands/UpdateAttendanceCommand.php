<?php

namespace Depotwarehouse\YEGVotes\Console\Commands;

use Depotwarehouse\YEGVotes\Jobs\UpdateAttendance;
use Depotwarehouse\YEGVotes\Model\Attendance;
use Depotwarehouse\YEGVotes\Model\Meeting;
use Illuminate\Console\Command;
use socrata\soda\Client;

class UpdateAttendanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:update_attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Attendance records for all meetings in the database';

    protected $model;
    protected $meetings;
    protected $sodaClient;

    /**
     * Create a new command instance.
     *
     * @param \Depotwarehouse\YEGVotes\Jobs\UpdateAttendance $internalCommand
     */
    public function __construct(UpdateAttendance $internalCommand)
    {
        parent::__construct();
        $this->internalCommand = $internalCommand;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->internalCommand->setOutputHandler($this->output);
        $this->internalCommand->execute();
    }
}
