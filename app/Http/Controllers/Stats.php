<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\StatisticsService;

class Stats extends Controller
{

    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function show()
    {
        $groups = $this->statisticsService->motionStatuses();


        dd($groups);
        dd($groups);
    }

}
