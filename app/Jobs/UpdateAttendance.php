<?php

namespace App\Jobs;

use App\Model\Attendance;
use App\Model\Meeting;
use Illuminate\Support\Collection;
use socrata\soda\Client;

class UpdateAttendance extends SocrataSync
{

    private $meetingModel;

    public function __construct(Client $socrataClient, Attendance $model, Meeting $meetingModel)
    {
        parent::__construct($socrataClient, $model);
        $this->meetingModel = $meetingModel;
    }

    public function getResourceUri()
    {
        //return "/resource/7en4-rwfd.json";
        return "/resource/vmzv-h5uh.json";
    }

    public function resourceId($entry)
    {
        return $entry['meeting_id'] . $entry['attendee'];
    }

    public function getSearchParams()
    {
        // We don't want committee or board members.
        return [
            '$where' => "attendee like '%Coun%' or attendee like '%Mayor%'"
        ];
    }


    public function getIdsToSkip(Collection $data)
    {
        $meetingIds = $data->map(function ($dataItem) {
            return $dataItem[$this->getIdToSkipKey()];
        })
            ->unique();

        /** @var \Illuminate\Database\Eloquent\Collection $localAgendaItems */
        $localMeetings = $this->meetingModel->find($meetingIds->all());

        $localMeetingIds = $localMeetings->map(function (Meeting $meeting) {
            return $meeting->id;
        })
            ->toBase()
            ->unique();

        return $meetingIds->diff($localMeetingIds)->all();
    }

    public function getIdToSkipKey()
    {
        return "meeting_id";
    }

    public function mapRecord(array $entry)
    {
        return [
            'id' => $this->resourceId($entry),
            'meeting_id' => $entry['meeting_id'],
            'item_id' => $entry['item_id'],
            'attendee' => $entry['attendee'],
            'present' => ($entry['status'] == 'Present')
        ];
    }
}
