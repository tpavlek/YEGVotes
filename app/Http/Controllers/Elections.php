<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Carbon\Carbon;
use Depotwarehouse\YEGVotes\Model\Election\Candidate;

class Elections extends Controller
{


    public function show($name)
    {
        $candidates = new Candidate();

        $running = $candidates->orderBy('last_name')->get();

        return view('election.show')
            ->with('candidates', $running)
            ->with('election_date', Carbon::create(2016, 2, 22));
    }

}
