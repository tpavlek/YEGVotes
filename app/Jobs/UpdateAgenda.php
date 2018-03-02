<?php

namespace App\Jobs;

use App\Model\AgendaItem;
use App\Model\Meeting;
use Illuminate\Support\Collection;
use socrata\soda\Client;

class UpdateAgenda extends SocrataSync
{

    private $meetingModel;

    public function __construct(Client $socrataClient, AgendaItem $model, Meeting $meetingModel)
    {
        parent::__construct($socrataClient, $model);
        $this->meetingModel = $meetingModel;
    }

    public function getResourceUri()
    {
        //return "/resource/y4rx-kdcn.json";
        return "/resource/58rx-sm6i.json";
    }

    public function resourceId($entry)
    {
        return $entry['item_id'];
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
            'title' => $entry['item_title']
        ];
    }
}
