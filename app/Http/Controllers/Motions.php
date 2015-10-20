<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\Motion;

class Motions extends Controller
{

    public function __construct(Motion $motionModel)
    {
        $this->motionModel = $motionModel;
    }

    public function show($motion_id)
    {
        $motion = $this->motionModel->find($motion_id);

        return view('motion.show')
            ->with('motion', $motion)
            ->with('votes', $motion->votes->groupBy('vote'));
    }

}
