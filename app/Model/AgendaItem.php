<?php

namespace Depotwarehouse\YEGVotes\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AgendaItem
 * @package Depotwarehouse\YEGVotes\Model
 *
 * @method Builder bylaws()
 */
class AgendaItem extends Model
{

    public $table = "agenda_items";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [ 'id', 'meeting_id', 'title' ];
    protected $interestingMotions = null;

    public function __toString()
    {
        return $this->title;
    }

    /**
     * Get a scope that only contains agenda items relating to the passing of Bylaws. An agenda item must have
     * at least one motion that has at least one vote taken (future bylaw votes will not appear)
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeBylaws($query)
    {
        return $query->where('title', 'RLIKE', 'Bylaw [0-9](.*)')
            ->whereHas('motions', function (Builder $query) {
                $query->has('votes');
            })
            ->join("meetings", "agenda_items.meeting_id", '=', 'meetings.id')
            ->select("agenda_items.*")
            ->orderBy('meetings.date', 'DESC')
            ->with('motions.votes');
    }

    public function scopeVoteAgainst($query, $council_member)
    {
        return $query->whereHas('motions.votes', function ($query) use ($council_member) {
            $query->where('vote', '=', "No")->where('voter', '=', $council_member);
        });
    }

    public function hasVotes()
    {
        $containsVotes = $this->motions->contains(function ($key, Motion $motion) {
            return $motion->votes->count();
        });
        return $containsVotes;
    }

    public function meeting()
    {
        return $this->hasOne(Meeting::class, 'id', 'meeting_id');
    }

    public function motion()
    {
        return $this->hasOne(Motion::class, 'item_id', 'id');
    }

    public function motions()
    {
        return $this->hasMany(Motion::class, 'item_id', 'id')
            ->orderBy('item_id', 'desc');
    }

    /**
     * Gets a collection of (up-to) five interesting motions.
     *
     * These motions exclude any "no-vote" motions, and in a large set will include the first two and the final three.
     *
     * For efficiency reasons the result will be "cached" in `$this->interestingMotions`
     */
    public function interestingMotions()
    {
        if ($this->interestingMotions != null) {
            return $this->interestingMotions;
        }

        /** @var \Illuminate\Database\Eloquent\Collection $motions */
        $motions = $this->motions;

        $motions = $motions->reject(function ($motion) {
            return $motion->status == "No Vote";
        });

        // If this is true, all the motions are no-votes, in which case we want to return up to five of them
        if ($motions->count() == 0) {
            return $this->motions->slice(0, 5);
        }

        $interestingMotions = $motions->slice(0, 2)->merge($motions->slice($motions->count() - 3, 3));

        $this->interestingMotions = $interestingMotions;
        return $interestingMotions;
    }

    public function vote($council_member)
    {
        return $this->motions->first()->vote($council_member);
    }

}
