<?php

namespace Depotwarehouse\YEGVotes\Model\Election;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{

    public $table = "election_candidates";

    public function getRunningNameAttribute()
    {
        $last_name = strtoupper($this->last_name);
        return "$last_name, {$this->first_name}";
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function election()
    {
        return $this->belongsTo(Election::class, 'election_id', 'id');
    }

}
