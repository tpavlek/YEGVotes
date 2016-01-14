<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\Election\Candidate;

class Candidates extends Controller
{

    public function show($name)
    {
        $candiateModel = new Candidate();

        $candidate = $candiateModel->newQuery()->where(\DB::raw('concat(lower(first_name),lower(last_name))'), '=', $name)->firstOrFail();

        $postable_content = $candidate->postable_content();

        return view('candidate.show')
            ->with('candidate', $candidate)
            ->with('postable_content', $postable_content);
    }

}
