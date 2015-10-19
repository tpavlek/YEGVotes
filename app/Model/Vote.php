<?php

namespace Depotwarehouse\YEGVotes\Model;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{

    public $table = "votes";
    public $incrementing = false;

    public $fillable = [ "id", "motion_id", "voter", "vote" ];

    public function __toString()
    {
        return $this->vote;
    }
}
