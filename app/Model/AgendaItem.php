<?php

namespace Depotwarehouse\YEGVotes\Model;

use Illuminate\Database\Eloquent\Model;

class AgendaItem extends Model
{

    public $table = "agenda_items";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [ 'id', 'meeting_id', 'title' ];

}
