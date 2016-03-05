<?php

namespace Depotwarehouse\YEGVotes\Console\Commands;

use Depotwarehouse\YEGVotes\Jobs\UpdateCouncillors;
use Illuminate\Console\Command;

class UpdateCouncillorsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:update_councillors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all councillors in the system';
    /**
     * @var UpdateCouncillors
     */
    private $updateCouncillors;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UpdateCouncillors $updateCouncillors)
    {
        parent::__construct();
        $this->updateCouncillors = $updateCouncillors;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->updateCouncillors->execute();

        $this->info("Updated all local councillor references");
    }
}
