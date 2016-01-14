<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Carbon\Carbon;
use Depotwarehouse\YEGVotes\Model\Election\Candidate;
use Depotwarehouse\YEGVotes\Model\Election\Election;
use Depotwarehouse\YEGVotes\Model\Election\GetPostable;
use Depotwarehouse\YEGVotes\Model\Election\Tweet;

class Elections extends Controller
{


    public function show($id, Election $elections)
    {
        $election = $elections->findOrFail($id);
        $candidates = new Candidate();

        $running = $candidates->orderBy('last_name')->get();

        return view('election.show')
            ->with('election', $election)
            ->with('candidates', $running)
            ->with('election_date', Carbon::create(2016, 2, 22));
    }

    public function feed($id, Election $elections, GetPostable $getPostable)
    {
        $election = $elections->findOrFail($id);

        $postable_content = $getPostable->getApproved();

        return view('election.feed')
            ->with('postable_content', $postable_content)
            ->with('election', $election);
    }

}
