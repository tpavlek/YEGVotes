<?php

namespace Depotwarehouse\YEGVotes\Model\Election;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon date
 */
class Election extends Model
{

    public $table = "elections";
    public $incrementing = false;

    protected $casts = [
        'date' => 'dateTime'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'election_id', 'id');
    }

    public function isFinished()
    {
        return $this->date->lt(Carbon::now());
    }

    public function daysLeft()
    {
        return $this->date->diffInDays(Carbon::now());
    }
}
