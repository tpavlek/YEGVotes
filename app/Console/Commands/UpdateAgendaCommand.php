<?php

namespace App\Console\Commands;

use App\Jobs\UpdateAgenda;
use App\Model\AgendaItem;
use App\Model\Meeting;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use socrata\soda\Client;

class UpdateAgendaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:update_agenda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the list of agenda items from Socrata';

    /**
     * Create a new command instance.
     *
     * @param \App\Jobs\UpdateAgenda $internalCommand
     */
    public function __construct(UpdateAgenda $internalCommand)
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
