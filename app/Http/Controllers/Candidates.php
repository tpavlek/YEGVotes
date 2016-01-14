<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\Election\Candidate;

class Candidates extends Controller
{

    public function show($id)
    {
        $candiateModel = new Candidate();

        $candidate = $candiateModel->findOrFail($id);

        return view('candidate.show')
            ->with('candidate', $candidate);
    }

}
