<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\Election\Candidate;
use Depotwarehouse\YEGVotes\Model\Election\Election;

class Ward extends Controller
{

    public function show($election_id, $ward_number)
    {
        $election = Election::query()->find($election_id);

        $candidates = $election->candidates->filter(function (Candidate $candidate) use ($ward_number) {
            return $candidate->ward == $ward_number;
        });

        return view('election.ward.show')->with('election', $election)->with('candidates', $candidates)->with('ward_number', $ward_number);
    }

}
