<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\Election\Candidate;

class Candidates extends Controller
{

    public function show($id)
    {
        $candiateModel = new Candidate();

        $candidate = $candiateModel->findOrFail($id);

        $postable_content = $candidate->postable_content;

        return view('candidate.show')
            ->with('candidate', $candidate)
            ->with('postable_content', $postable_content);
    }

}
