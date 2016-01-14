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

    public function getImgUrlAttribute($value)
    {
        if ($value === null) {
            return "/img/election/ward12/none.png";
        }

        return $value;
    }

    public function election()
    {
        return $this->belongsTo(Election::class, 'election_id', 'id');
    }

    public function postable_content()
    {
        return $this->tweets();
    }

    public function tweets()
    {
        return $this->morphedByMany(Tweet::class, 'postable', 'election_postable_content', 'candidate_id', 'postable_id');
    }

}
