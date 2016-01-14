<?php

namespace Depotwarehouse\YEGVotes\Model\Election;

use Illuminate\Database\Eloquent\Model;

abstract class PostableContent extends Model
{

    public abstract function render();

}
