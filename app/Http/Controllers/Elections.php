<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Carbon\Carbon;
use Depotwarehouse\YEGVotes\Model\Election;

class Elections extends Controller
{

    public function ward12()
    {
        return view('election.ward12');
    }

    public function general2017()
    {
        $election = new Election("2017 General Election", new Carbon('2017-10-16'));

        return view('election.2017')->with('election', $election);
    }

    public function wardFinder()
    {
        return view('election.wardfinder');
    }

}
