<?php

namespace Depotwarehouse\YEGVotes\Model;

use Illuminate\Database\Eloquent\Model;

class Councillor extends Model
{

    public $table = "councillors";
    public $incrementing = false;
    public $primaryKey = "name";

    public $fillable = [ 'name', 'term' ];

    public static function fromName($name)
    {
        return self::create([ 'name' => $name ]);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function toString()
    {
        return $this->name;
    }
}
