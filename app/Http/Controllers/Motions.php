<?php

namespace App\Http\Controllers;

use App\Model\Motion;

class Motions extends Controller
{

    public function __construct(Motion $motionModel)
    {
        $this->motionModel = $motionModel;
    }

    public function show($motion_id)
    {
        $motions = $this->motionModel->newQuery()->whereIn('id', explode(',', $motion_id))->get();

        return view('motion.show')
            ->with('motions', $motions);
    }

}
