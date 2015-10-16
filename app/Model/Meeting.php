<?php

namespace Depotwarehouse\YEGVotes\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{

    public $table = "meetings";
    public $timestamps = false;
    public $incrementing = false;
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
            ->orderBy('date', 'DESC')
            ->firstOrFail();
    }

}
