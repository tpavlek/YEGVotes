<?php

namespace Depotwarehouse\YEGVotes\Model;

use Illuminate\Database\Eloquent\Model;

class AgendaItem extends Model
{

    public $table = "agenda_items";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [ 'id', 'meeting_id', 'title' ];

    public function __toString()
    {
        return $this->title;
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
        return $this->hasMany(Motion::class, 'item_id', 'id');
    }

    public function vote($council_member)
    {
        return $this->motions->first()->vote($council_member);
    }

}
