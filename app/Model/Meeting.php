<?php

namespace Depotwarehouse\YEGVotes\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Meeting
 * @package Depotwarehouse\YEGVotes\Model
 *
 * @property \Illuminate\Database\Eloquent\Collection voting_items
 */
class Meeting extends Model
{

    public $table = "meetings";
    public $timestamps = false;
    public $incrementing = false;
    public $dates = [ "date" ];
    protected $fillable = [ "id", "meeting_type", 'record_type', "date", "location" ];

    /**
     * Find the latest meeting.
     *
     * Will not return any meetings happening later than "tomorrow".
     *
     * @return self
     */
    public function findLatestMeeting()
    {
        $tomorrow = Carbon::now()->addDay();
        return $this->newQuery()
            ->where('date', '<=', $tomorrow->toDateTimeString())
            ->where('meeting_type', 'like', '%city council%')
            ->whereHas('agenda_items', function(Builder $query) {
                $query->whereHas('motions', function (Builder $query) {
                    $query->has('votes');
                });
            })
            ->orderBy('date', 'DESC')
            ->firstOrFail();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agenda_items()
    {
        return $this->hasMany(AgendaItem::class, "meeting_id", "id");
    }

    public function getVotingItems()
    {
        $relation = $this->agenda_items()
            ->getQuery()
            ->whereHas('motions', function (Builder $query) {
                $query->has('votes');
            })
            ->with('motions.votes');

        return $relation->get();
    }

}
