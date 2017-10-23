<?php

namespace App\Jobs;

use App\Model\AgendaItem;
use App\Model\Motion;
use Illuminate\Support\Collection;
use socrata\soda\Client;

class UpdateMotions extends SocrataSync
{

    protected $itemModel;

    public function __construct(Client $socrataClient, Motion $model, AgendaItem $itemModel)
    {
        parent::__construct($socrataClient, $model);
        $this->itemModel = $itemModel;
    }

    public function getResourceUri()
    {
        return "/resource/smk2-dtnx.json";
    }

    public function resourceId($entry)
    {
        return $entry['motion_id'];
    }

    public function getIdsToSkip(Collection $data)
    {
        $itemIds = $data->map(function ($dataItem) {
            return $dataItem[$this->getIdToSkipKey()];
        })
            ->unique();

        /** @var \Illuminate\Database\Eloquent\Collection $localAgendaItems */
        $localAgendaItems = $this->itemModel->find($itemIds->all());

        $localItemIds = $localAgendaItems->map(function (AgendaItem $agendaItem) {
            return $agendaItem->id;
        })
            ->toBase()
            ->unique();

        return $itemIds->diff($localItemIds)->all();
    }

    public function getIdToSkipKey()
    {
        return 'item_id';
    }

    public function mapRecord(array $entry)
    {
        return [
            'id' => $this->resourceId($entry),
            'item_id' => $entry['item_id'],
            'mover' => (isset($entry['motion_mover'])) ? $entry['motion_mover'] : null,
            'seconder' => (isset($entry['motion_seconder'])) ? $entry['motion_seconder'] : null,
            'description' => (isset($entry['motion_description'])) ? $entry['motion_description'] : "",
            'status' => $entry['motion_status']
        ];
    }


}
