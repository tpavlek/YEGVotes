<?php

namespace Depotwarehouse\YEGVotes\Console\Commands;

use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Depotwarehouse\YEGVotes\Model\Meeting;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use socrata\soda\Client;

class UpdateAgendaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:update_agenda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the list of agenda items from Socrata';

    protected $model;
    protected $meetingModel;
    protected $socrataClient;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AgendaItem $model, Meeting $meetingModel, Client $socrataClient)
    {
        parent::__construct();

        $this->model = $model;
        $this->meetingModel = $meetingModel;
        $this->socrataClient = $socrataClient;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $createdRecords = 0;
        $totalRecords = 0;
        $noMeetingRecords = 0;
        $skippedRecords = 0;

        $currentOffset = 0;

        $searchParams = [
            '$limit' => 5000,
            '$offset' => $currentOffset
        ];

        $data = $this->socrataClient->get("/resource/y4rx-kdcn.json", $searchParams);
        $recordsToInsert = [];

        while (!empty($data)) {
            $totalRecords += count($data);
            // We want to collect all the meetings referenced in this agenda items, so that we can query for them all
            // at once.

            $meetingIds = (new Collection($data))->map(function ($dataItem) {
                return $dataItem["meeting_id"];
            })
                ->unique()
                ->all();

            $itemIds = (new Collection($data))->map(function ($dataItem) {
                return $dataItem['item_id'];
            })
                ->unique()
                ->all();

            /** @var \Illuminate\Database\Eloquent\Collection $meetings */
            $meetings = $this->meetingModel->find($meetingIds);

            foreach ($data as $agendaData) {
                $meeting = $this->filterMeetingsById($meetings, $agendaData['meeting_id']);

                if ($meeting == null) {
                    $noMeetingRecords++;
                    continue;
                }

                if (!in_array($agendaData['item_id'], $itemIds)) {
                    $skippedRecords++;
                    continue;
                }

                $recordsToInsert[] = [
                    'id' => $agendaData['item_id'],
                    'meeting_id' => $agendaData['meeting_id'],
                    'title' => $agendaData['item_title']
                ];
                $createdRecords++;
            }

            $searchParams['$offset'] = $searchParams['$offset'] + $searchParams['$limit'];
            $data = $this->socrataClient->get("/resource/y4rx-kdcn.json", $searchParams);
        }

        if (count($recordsToInsert)) {
            $this->model->getConnection()
                ->table($this->model->table)
                ->insert($recordsToInsert);
        }

        $this->output->writeln("Finished. Created: {$createdRecords}, Skipped: {$skippedRecords}, Meeting Missing: {$noMeetingRecords}, Total: {$totalRecords}");
    }

    protected function filterMeetingsById(\Illuminate\Database\Eloquent\Collection $meetings, $id)
    {
        return $meetings->first(function($key, Meeting $meeting) use ($id) {
            return $meeting->id == $id;
        });
    }
}
