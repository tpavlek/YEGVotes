<?php

namespace Depotwarehouse\YEGVotes\Console\Commands;

use Depotwarehouse\YEGVotes\Model\Motion;
use Depotwarehouse\YEGVotes\Model\Vote;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use socrata\soda\Client;

class UpdateVotesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:update_votes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Updates the set of votes";

    protected $socrataClient;
    protected $motionModel;
    protected $model;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $socrataClient, Motion $motionModel, Vote $model)
    {
        parent::__construct();
        $this->socrataClient = $socrataClient;
        $this->motionModel = $motionModel;
        $this->model = $model;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $resourceUri = "/resource/fwq5-ux79.json";
        $createdRecords = 0;
        $totalRecords = 0;
        $noMotionRecords = 0;
        $skippedRecords = 0;

        $currentOffset = 0;

        $searchParams = [
            '$limit' => 5000,
            '$offset' => $currentOffset
        ];

        $data = $this->socrataClient->get($resourceUri, $searchParams);
        $recordsToInsert = [ ];

        while (!empty($data)) {
            $this->output->writeln("Querying {$searchParams['$limit']} records, offset {$searchParams['$offset']}");

            $totalRecords += count($data);

            $motionIds = collect($data)->map(function ($dataItem) {
                return $dataItem['motion_id'];
            })
                ->unique();

            $localMotions = $this->motionModel->find($motionIds->all());

            $localMotionIds = $localMotions->map(function (Motion $motion) {
                return $motion->id;
            })
                ->toBase()
                ->unique();

            $itemsToSkip = $motionIds->diff($localMotionIds)->all();


            foreach ($data as $voteData) {

                if (in_array($voteData['motion_id'], $itemsToSkip)) {
                    $noMotionRecords++;
                    continue;
                }

                $recordsToInsert[] = [
                    'id' => $voteData['motion_id'] . "({$voteData['voter']})",
                    'motion_id' => $voteData['motion_id'],
                    'voter' => $voteData['voter'],
                    'vote' => $voteData['vote']
                ];

                $createdRecords++;
            }

            $searchParams['$offset'] = $searchParams['$offset'] + $searchParams['$limit'];
            $data = $this->socrataClient->get($resourceUri, $searchParams);
        }

        $this->output->writeln("Finished querying socrata, retrieved {$totalRecords} records");

        if (count($recordsToInsert)) {

            // We want to ensure that all voting records are unique, so we'll remove any duplicates.
            $insertCollection = collect($recordsToInsert);

            $this->output->writeln("Beginning uniqueness check on {$insertCollection->count()} records");
            $insertCollection = $insertCollection->unique(function ($recordToInsert) {
                return $recordToInsert['id'];
            });

            $this->output->writeln("Uniqueness verified, {$insertCollection->count()} records remaining");

            $this->slicedInsert($insertCollection);
        }

        $this->output->writeln("Finished. Created: {$createdRecords}, Skipped: {$skippedRecords}, AgendaItem Missing: {$noMotionRecords}, Total: {$totalRecords}");
    }

    /**
     * @param Collection $data
     */
    protected function slicedInsert($data)
    {
        $slice_size = 10000;
        $num_slices = ceil($data->count() / $slice_size);
        for ($i = 0; $i < $num_slices; $i++) {
            $current_slice = $data->slice($i * $slice_size, $slice_size);

            $this->model->getConnection()->table($this->model->table)->insert($current_slice->all());

            $this->output->writeln("Wrote {$slice_size} records to database");
        }
    }
}
