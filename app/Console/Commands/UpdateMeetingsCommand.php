<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Jobs\UpdateMeetings;
use App\Model\Meeting;
use Illuminate\Console\Command;
use socrata\soda\Client;

class UpdateMeetingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:update_meetings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the internal representation of all council meetings';
    protected $internalCommand;

    /**
     * Create a new command instance.
     * @param \App\Jobs\UpdateMeetings $internalCommand
     */
    public function __construct(UpdateMeetings $internalCommand)
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
