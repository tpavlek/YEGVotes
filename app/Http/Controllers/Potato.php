<?php

namespace App\Http\Controllers;

use App\Model\Potato\PotatoVote;
use Illuminate\Http\Request;

class Potato extends Controller
{

    public function show()
    {
        return view('potato.show');
    }
    
}
