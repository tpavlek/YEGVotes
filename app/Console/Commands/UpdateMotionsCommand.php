<?php

namespace App\Console\Commands;

use App\Jobs\UpdateMotions;
use Illuminate\Console\Command;

class UpdateMotionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:update_motions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs internal motions database with remote dataset';

    protected $internalCommand;

    /**
     * Create a new command instance.
     * @param \App\Jobs\UpdateMotions $internalCommand
     */
    public function __construct(UpdateMotions $internalCommand)
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
