<?php

namespace Depotwarehouse\YEGVotes\Console\Commands;

use Depotwarehouse\YEGVotes\Jobs\UpdateAgenda;
use Depotwarehouse\YEGVotes\Jobs\UpdateAttendance;
use Depotwarehouse\YEGVotes\Jobs\UpdateMeetings;
use Depotwarehouse\YEGVotes\Jobs\UpdateMotions;
use Depotwarehouse\YEGVotes\Jobs\UpdateVotes;
use Depotwarehouse\YEGVotes\Model\Motion;
use Illuminate\Console\Command;

class UpdateAllData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:update_all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @param \Depotwarehouse\YEGVotes\Jobs\UpdateMeetings $updateMeetings
     * @param \Depotwarehouse\YEGVotes\Jobs\UpdateAttendance $updateAttendance
     * @param \Depotwarehouse\YEGVotes\Jobs\UpdateAgenda $updateAgenda
     * @param \Depotwarehouse\YEGVotes\Jobs\UpdateMotions $updateMotions
     * @param \Depotwarehouse\YEGVotes\Jobs\UpdateVotes $updateVotes
     */
    public function __construct(
        UpdateMeetings $updateMeetings,
        UpdateAttendance $updateAttendance,
        UpdateAgenda $updateAgenda,
        UpdateMotions $updateMotions,
        UpdateVotes $updateVotes
    ) {
        parent::__construct();
        $this->updateMeetings = $updateMeetings;
        $this->updateAttendance = $updateAttendance;
        $this->updateAgenda = $updateAgenda;
        $this->updateMotions = $updateMotions;
        $this->updateVotes = $updateVotes;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->updateMeetings->setOutputHandler($this->output);
        $this->updateAttendance->setOutputHandler($this->output);
        $this->updateAgenda->setOutputHandler($this->output);
        $this->updateMotions->setOutputHandler($this->output);
        $this->updateVotes->setOutputHandler($this->output);

        $this->output->writeln("--- Updating Meetings ---");
        $this->updateMeetings->execute();
        $this->output->writeln("--- Updating Attendance ---");
        $this->updateAttendance->execute();
        $this->output->writeln("--- Updating Agenda ---");
        $this->updateAgenda->execute();
        $this->output->writeln("--- Updating Motions ---");
        $this->updateMotions->execute();
        $this->output->writeln("--- Updating Votes ---");
        $this->updateVotes->execute();
    }
}
