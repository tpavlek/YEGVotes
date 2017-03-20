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
 * @property string meeting_type
 */
class Meeting extends Model
{

    const TYPE_CITY_COUNCIL = "City Council";
    const TYPE_PUBLIC_HEARING = "City Council Public Hearing";

    public $table = "meetings";
    public $timestamps = false;
    public $incrementing = false;
    public $dates = [ "date" ];
    protected $fillable = [ "id", "meeting_type", 'record_type', "date", "location" ];

    public function getTitleAttribute()
    {
        return $this->date->toDateString() . " " . $this->meeting_type;
    }

    public function __toString()
    {
        return $this->title;
    }

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
            ->orderBy('date', 'DESC')
            ->firstOrFail();
    }

    /**
     * City Council meetings typicallly go over two days, and if they do the first day is more interesting.
     *
     * We'll return that.
     * @return self
     */
    public function latestBigCouncilMeeting()
    {
        $meetings = $this->newQuery()
            ->where('date', '<=', Carbon::now()->addDay()->toDateTimeString())
            ->orderBy('date', 'DESC')
            ->take(2)
            ->get();

        if ($meetings->first()->meeting_type == Meeting::TYPE_CITY_COUNCIL && $meetings->last()->meeting_type == Meeting::TYPE_CITY_COUNCIL) {
            return $meetings->last();
        }

        return $meetings->first();
    }

    public function hasVotes()
    {
        return $this->agenda_items->contains(function ($key, AgendaItem $agenda_item) {
            return $agenda_item->hasVotes();
        });
    }

    public function motions()
    {
        return $this->hasManyThrough(Motion::class, AgendaItem::class, 'meeting_id', 'item_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agenda_items()
    {
        return $this->hasMany(AgendaItem::class, "meeting_id", "id")->orderBy('agenda_items.id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'meeting_id', 'id');
    }

    public function getAttendance()
    {
        $records = $this->attendance;

        $records = $records->sortBy(function (Attendance $attendance) {
            return $attendance->getAttendee()->getWardNumber();
        });

        return $records;
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

    public function speakers()
    {
        if ($this->meeting_type == self::TYPE_PUBLIC_HEARING) {
            $result = $this->agenda_items->filter(function (AgendaItem $item) {
                    return $item->title == "Call for Persons to Speak" && $item->hasMotions();
                })
                ->flatMap(function (AgendaItem $item) {

                    return $item->motions->flatMap(function (Motion $motion) {
                        return (new PublicHearingSpeakerParser($motion->description))->parse();
                    });
                })
                ->reject(function ($speaker) {
                    return str_contains(strtolower($speaker), '(to answer question'));
                })
                ->unique();

            return $result->all();
        }

        return $this->agenda_items()->requestsToSpeak()->get()->flatMap(function (AgendaItem $item) {
            return $item->motions->flatMap(function (Motion $motion) {
                return $motion->parseSpeakers();
            });
        });
    }

}
