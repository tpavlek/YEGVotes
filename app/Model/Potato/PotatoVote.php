<?php

namespace App\Model\Potato;

use Illuminate\Database\Eloquent\Model;

class PotatoVote extends Model
{

    public $table = "potato_selections";
    public $fillable = [ 'vote', 'ip' ];

    public function sum($vote)
    {
        return $this->newQuery()->where('vote', $vote)->count();
    }
}
