<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\Potato\PotatoVote;
use Illuminate\Http\Request;

class Potato extends Controller
{

    public function show()
    {
        return view('potato.show');
    }
    
}
