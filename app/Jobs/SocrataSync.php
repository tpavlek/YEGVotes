<?php

namespace App\Jobs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use socrata\soda\Client;
use Symfony\Component\Console\Output\OutputInterface;

abstract class SocrataSync
{

    public $socrataClient;
    public $model;
    public $databaseInsertSliceSize = 10000;

    /** @var OutputInterface  */
    protected $outputHandler = null;

    public function __construct(Client $socrataClient, Model $model)
    {
        $this->socrataClient = $socrataClient;
        $this->model = $model;
    }

    public abstract function getResourceUri();

    /**
     * Given a particular entry, compose a unique string ID.
     *
     * @param $entry
     * @return string
     */
    public abstract function resourceId($entry);

    /**
     * Get an array of resource IDs to skip from processing
     *
     * @param \Illuminate\Support\Collection $data
     * @return array
     */
    public abstract function getIdsToSkip(Collection $data);

    /**
     * Get the search parameters that will be passed to the Socrata API.
     *
     * @return array
     */
    public function getSearchParams()
    {
        return [];
    }

    /**
     * Get the key of the foreign relationship, which will map to an entry in the IdsToSkip array.
     *
     * @return string
     */
    public abstract function getIdToSkipKey();

    /**
     * Given an entry, map it's properties to a key => value array that represents a record to insert into the database
     *
     * @param array $entry
     * @return array
     */
    public abstract function mapRecord(array $entry);

    public function setOutputHandler(OutputInterface $ouput)
    {
        $this->outputHandler = $ouput;
    }

    protected function output($message)
    {
        if (is_null($this->outputHandler)) {
            return;
        }

        $this->outputHandler->writeln($message);
    }

    public function execute()
    {
        $createdRecords = 0;
        $totalRecords = 0;
        $missingRelationshipRecords = 0;
        $skippedRecords = 0;

        $searchParams = [
            '$limit' => 5000,
            '$offset' => 0
        ];

        $searchParams = $searchParams + $this->getSearchParams();

        $data = $this->socrataClient->get($this->getResourceUri(), $searchParams);
        $recordsToInsert = [];

        $localModelIds = $this->model->lists('id')->all();

        while (!empty($data)) {
            $this->output("Querying {$searchParams['$limit']} records, offset {$searchParams['$offset']}");

            // Our data might have duplicate entries with the same ID, we want to remove those.
            $data = collect($data)->unique(function ($dataItem) {
                return $this->resourceId($dataItem);
            });

            $totalRecords += count($data);

            $itemsToSkip = $this->getIdsToSkip($data);

            foreach ($data as $entry) {

                if (!is_null($this->getIdToSkipKey()) && in_array($entry[$this->getIdToSkipKey()], $itemsToSkip)) {
                    $missingRelationshipRecords++;
                    continue;
                }

                if (in_array($this->resourceId($entry), $localModelIds)) {
                    $skippedRecords++;
                    continue;
                }

                $recordsToInsert[] = $this->mapRecord($entry);

                $createdRecords++;
            }

            $searchParams['$offset'] = $searchParams['$offset'] + $searchParams['$limit'];
            $data = $this->socrataClient->get($this->getResourceUri(), $searchParams);
        }

        $this->output("Finished querying socrata, retrieved {$totalRecords} records");

        if (count($recordsToInsert)) {

            // We want to ensure that all records we're about to insert are unique, in case the dataset had any
            // duplicates
            $insertCollection = collect($recordsToInsert);

            $this->output("Beginning uniqueness check on {$insertCollection->count()} records");
            $insertCollection = $insertCollection->unique('id');

            $this->output("Uniqueness verified, {$insertCollection->count()} records remaining");

            $this->slicedInsert($insertCollection);
        }

        $this->output("Finished. Created: {$createdRecords}, Skipped: {$skippedRecords}, ForeignKey Missing: {$missingRelationshipRecords}, Total: {$totalRecords}");
    }

    /**
     * @param Collection $data
     */
    protected function slicedInsert($data)
    {
        $num_slices = ceil($data->count() / $this->databaseInsertSliceSize);
        for ($i = 0; $i < $num_slices; $i++) {
            $current_slice = $data->slice($i * $this->databaseInsertSliceSize, $this->databaseInsertSliceSize);

            $this->model->getConnection()->table($this->model->table)->insert($current_slice->all());

            $this->output("Wrote {$this->databaseInsertSliceSize} records to database");
        }
    }

}
