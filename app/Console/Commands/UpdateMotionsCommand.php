<?php

namespace Depotwarehouse\YEGVotes\Console\Commands;

use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Depotwarehouse\YEGVotes\Model\Motion;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use socrata\soda\Client;

class UpdateMotionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:update_motions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs internal motions database with remote dataset';

    protected $socrataClient;
    protected $itemModel;
    protected $model;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $socrataClient, AgendaItem $itemModel, Motion $model)
    {
        parent::__construct();
        $this->socrataClient = $socrataClient;
        $this->itemModel = $itemModel;
        $this->model = $model;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $resourceUri = "/resource/smk2-dtnx.json";
        $createdRecords = 0;
        $totalRecords = 0;
        $noItemRecords = 0;
        $skippedRecords = 0;

        $currentOffset = 0;

        $searchParams = [
            '$limit' => 5000,
            '$offset' => $currentOffset
        ];

        $data = $this->socrataClient->get($resourceUri, $searchParams);
        $recordsToInsert = [];

        while (!empty($data)) {
            $this->output->writeln("Querying {$searchParams['$limit']} records, offset {$searchParams['$offset']}");

            // Our data might have duplicate entries with the same ID, we want to remove those.
            $data = collect($data)->unique(function ($dataItem) {
                return $dataItem['motion_id'];
            });

            $totalRecords += count($data);
            // We want to collect all the meetings referenced in this agenda items, so that we can query for them all
            // at once.

            $itemIds = $data->map(function ($dataItem) {
                return $dataItem['item_id'];
            })
                ->unique();

            /** @var \Illuminate\Database\Eloquent\Collection $localAgendaItems */
            $localAgendaItems = $this->itemModel->find($itemIds->all());

            $localItemIds = $localAgendaItems->map(function (AgendaItem $agendaItem) {
                return $agendaItem->id;
            })
                ->toBase()
                ->unique();

            $itemsToSkip = $itemIds->diff($localItemIds)->all();


            foreach ($data as $motionData) {

                if (in_array($motionData['item_id'], $itemsToSkip)) {
                    $noItemRecords++;
                    continue;
                }

                $recordsToInsert[] = [
                    'id' => $motionData['motion_id'],
                    'item_id' => $motionData['item_id'],
                    'mover' => (isset($motionData['motion_mover'])) ? $motionData['motion_mover'] : null,
                    'seconder' => (isset($motionData['motion_seconder'])) ? $motionData['motion_seconder'] : null,
                    'description' => $motionData['motion_description'],
                    'status' => $motionData['motion_status']
                ];

                $createdRecords++;
            }

            $searchParams['$offset'] = $searchParams['$offset'] + $searchParams['$limit'];
            $data = $this->socrataClient->get($resourceUri, $searchParams);
        }

        $this->output->writeln("Finished querying socrata, retrieved {$totalRecords} records");

        if (count($recordsToInsert)) {
            $this->model->getConnection()
                ->table($this->model->table)
                ->insert($recordsToInsert);
        }

        $this->output->writeln("Finished. Created: {$createdRecords}, Skipped: {$skippedRecords}, AgendaItem Missing: {$noItemRecords}, Total: {$totalRecords}");
    }

}
