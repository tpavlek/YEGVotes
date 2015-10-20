<?php

namespace Depotwarehouse\YEGVotes\Console\Commands;

use Depotwarehouse\YEGVotes\Jobs\UpdateVotes;
use Illuminate\Console\Command;


class UpdateVotesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:update_votes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Updates the set of votes";


    /**
     * Create a new command instance.
     *
     * @param \Depotwarehouse\YEGVotes\Jobs\UpdateVotes $internalCommand
     */
    public function __construct(UpdateVotes $internalCommand)
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
