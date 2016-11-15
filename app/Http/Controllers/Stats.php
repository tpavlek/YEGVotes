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
        return view('stats');
    }

    public function movers()
    {
        $movers = $this->statisticsService->motionsByCouncillor();
        $seconders = $this->statisticsService->secondsByCouncillor();

        $pairings = $this->statisticsService->motionPairings();

        return view('stats.movers')
            ->with('movers', $movers)
            ->with('seconders', $seconders)
            ->with('pairings', $pairings);
    }

    public function inPrivate()
    {
        $privateMotions = $this->statisticsService->privateMotions();
    }

}
