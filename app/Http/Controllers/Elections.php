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

        $view = ($election->id == "ward12") ? view('election.ward12')->with('candidates', $election->candidates) : view('election.2017');
        $mayoralCandidates = $election->candidates->filter(function (Candidate $candidate) { return $candidate->ward == "mayor"; });
        $undeclaredCandidates = $election->candidates->filter(function (Candidate $candidate) { return empty($candidate->ward); });

        return $view
            ->with('election', $election)
            ->with('mayoral_candidates', $mayoralCandidates)
            ->with('undeclared', $undeclaredCandidates)
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

    public function wardFinder()
    {
        return view('election.wardfinder');
    }

}
