<?php

namespace Depotwarehouse\YEGVotes\Console\Commands;

use Depotwarehouse\YEGVotes\Jobs\AgendaCrawler;
use Illuminate\Console\Command;

class CrawlAgendaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:crawl_agenda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawls an agenda page for attachments';
    /**
     * @var AgendaCrawler
     */
    private $agendaCrawler;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AgendaCrawler $agendaCrawler)
    {
        parent::__construct();
        $this->agendaCrawler = $agendaCrawler;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dd($this->agendaCrawler->crawl(1547));
    }
}
