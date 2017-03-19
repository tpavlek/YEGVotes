<?php

namespace Depotwarehouse\YEGVotes\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string description
 */
class Motion extends Model
{

    use FiltersProtocolItems;

    public $timestamps = false;

    public $table = "motions";
    public $incrementing = false;
    protected $fillable = [ "id", "item_id", "mover", "seconder", "description", "status" ];

    public function scopeWithoutProtocolItems(Builder $query)
    {
        return $query->whereHas('agenda_item', function ($query) {
            return $this->filterProtocolItems($query);
        });
    }

    public function vote($council_member)
    {
        $vote = $this->votes->first(function ($key, Vote $vote) use ($council_member) {
            return $vote->voter == $council_member;
        });

        if ($vote == null) {
            return new Vote([ 'vote' => 'No-Vote' ]);
        }

        return $vote;
    }

    /**
     * A motion has dissent if any of its votes are not "Yes" or "Absent"
     * @return bool
     */
    public function hasDissent()
    {
        return $this->votes->contains(function ($key, Vote $vote) {
            return ((string)$vote == "No" || (string)$vote == "Abstain");
        });
    }

    public function isRevisedDueDate()
    {
        return str_contains(strtolower($this->description), 'revised due date') && ! str_contains(strtolower($this->description), 'motion be reconsidered');
    }

    public function getMoverAttribute()
    {
        if ($this->attributes['mover'] == null) {
            return null;
        }

        return new CouncilMember($this->attributes['mover']);
    }

    public function getYearAttribute()
    {
        return $this->meeting->date->year;
    }

    public function getSeconderAttribute()
    {
        if (!isset($this->attributes['seconder'])) {
            return null;
        }

        return new CouncilMember($this->attributes['seconder']);
    }

    public function getDescriptionAttribute($value)
    {
        // We don't want a blank title attribute here.
        return str_replace('Title:<BR><BR>', '', $value);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'motion_id', 'id');
    }

    public function hasVotes()
    {
        return $this->votes->count();
    }

    public function agenda_item()
    {
        return $this->hasOne(AgendaItem::class, 'id', 'item_id');
    }

    public function meeting()
    {
        return $this->agenda_item->meeting();
    }

    public function getIndicatorString()
    {
        if ($this->status == "None" || $this->status == "Failed") {
            return $this->status;
        }

        $yes_votes = $this->votes->filter(function (Vote $vote) {
            return $vote->vote == "Yes";
        })->count();

        // If a voter is absent or recused, we don't want to count their vote as "dissenting"
        $total_votes = $this->votes->reject(function (Vote $vote) {
            return ($vote->vote == "Absent" || $vote->vote == "Recused");
        })->count();

        if ($yes_votes == $total_votes) {
            return "Unanimous";
        }

        if ($yes_votes < $total_votes) {
            return "Disagreement";
        }

        return "Unknown";
    }

    public function parseSpeakers()
    {
        return (new MotionSpeakerParser($this->description))->parse();
    }

    public function __toString()
    {
        return $this->description;
    }

    public function isConsiderationForThirdReading()
    {
        // TODO ensure it also mentions bylaw name.
        return str_contains($this->description, "be considered for third reading");
    }

    public function isThirdReading()
    {
        // TODO ensure it also mentions bylaw name.
        return str_contains($this->description, "be read a third time");
    }

}
