<?php

namespace Depotwarehouse\YEGVotes\Model;

use Illuminate\Database\Eloquent\Model;

class Motion extends Model
{

    public $table = "motions";
    public $incrementing = false;
    protected $fillable = [ "id", "item_id", "mover", "seconder", "description", "status" ];

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

    public function getMoverAttribute()
    {
        if ($this->attributes['mover'] == null) {
            return null;
        }

        return new CouncilMember($this->attributes['mover']);
    }

    public function getSeconderAttribute()
    {
        if (!isset($this->attributes['seconder'])) {
            return null;
        }

        return new CouncilMember($this->attributes['seconder']);
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

    public function __toString()
    {
        return $this->description;
    }

}
