<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Model\Meeting;
use Illuminate\Support\Collection;
use socrata\soda\Client;

class UpdateMeetings extends SocrataSync
{

    public function __construct(Client $socrataClient, Meeting $model)
    {
        parent::__construct($socrataClient, $model);
    }

    public function getResourceUri()
    {
        //return '/resource/p738-nr6i.json';
        return "/resource/nzwt-pmh6.json";
    }

    public function resourceId($entry)
    {
        return $entry['meeting_id'];
    }

    public function getIdsToSkip(Collection $data)
    {
        return [];
    }

    public function getIdToSkipKey()
    {
        return null;
    }

    public function getSearchParams()
    {
        $now = Carbon::now()->toDateString();
        return [
            "\$where" => "meeting_date < '{$now}' AND record_type = 'Minutes'"
        ];
    }


    public function mapRecord(array $entry)
    {
        return [
            'id' => $this->resourceId($entry),
            'date' => $this->mergeMeetingDateAndTime($entry['meeting_date'], $entry['meeting_time']),
            'meeting_type' => $entry['meeting_type'],
            'record_type' => $entry['record_type'],
            'location' => $entry['meeting_location']
        ];
    }

    protected function mergeMeetingDateAndTime($meeting_date, $meeting_time)
    {
        $carbon = new Carbon($meeting_date);
        // We expect $meeting_time in either 4:30 PM or 9:40 am, so we cast it to uppercase and then convert
        $time = Carbon::createFromFormat("g:i A", strtoupper($meeting_time));

        $carbon->addHours($time->hour);
        $carbon->addMinutes($time->minute);

        return $carbon;
    }
}
