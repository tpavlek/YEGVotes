<?php

namespace Depotwarehouse\YEGVotes\Model;

use Carbon\Carbon;

class Election
{

    /** @var Carbon */
    public $date;

    public $name;

    public function __construct($name, $date)
    {
        $this->name = $name;
        $this->date = $date;
    }

    public function daysLeft()
    {
        return Carbon::now()->diffInDays($this->date);
    }

    public function isFinished()
    {
        return Carbon::now()->gt($this->date);
    }

}
