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
        return $this->votes()
            ->getQuery()
            ->where('voter', 'like', $council_member)
            ->first();
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
