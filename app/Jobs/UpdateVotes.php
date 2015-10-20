<?php

namespace Depotwarehouse\YEGVotes\Jobs;

use Depotwarehouse\YEGVotes\Model\Motion;
use Depotwarehouse\YEGVotes\Model\Vote;
use Illuminate\Support\Collection;
use socrata\soda\Client;

class UpdateVotes extends SocrataSync
{

    public function __construct(Client $socrataClient, Vote $model, Motion $motionModel)
    {
        parent::__construct($socrataClient, $model);
        $this->motionModel = $motionModel;
    }

    public function getResourceUri()
    {
        return "/resource/fwq5-ux79.json";
    }

    public function resourceId($entry)
    {
        return $entry['motion_id'] . "({$entry['voter']})";
    }

    public function getIdsToSkip(Collection $data)
    {
        $motionIds = $data->map(function ($dataItem) {
            return $dataItem[$this->getIdToSkipKey()];
        })
            ->unique();

        /** @var \Illuminate\Database\Eloquent\Collection $localMotions */
        $localMotions = $this->motionModel->find($motionIds->all());

        $localMotionIds = $localMotions->map(function (Motion $motion) {
            return $motion->id;
        })
            ->toBase()
            ->unique();

        return $motionIds->diff($localMotionIds)->all();
    }

    public function getIdToSkipKey()
    {
        return "motion_id";
    }

    public function mapRecord(array $entry)
    {
        return [
            'id' => $this->resourceId($entry),
            'motion_id' => $entry['motion_id'],
            'voter' => $entry['voter'],
            'vote' => $entry['vote']
        ];
    }
}
