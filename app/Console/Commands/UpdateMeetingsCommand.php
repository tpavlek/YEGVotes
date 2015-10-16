<?php

namespace Depotwarehouse\YEGVotes\Console\Commands;

use Carbon\Carbon;
use Depotwarehouse\YEGVotes\Model\Meeting;
use Illuminate\Console\Command;
use socrata\soda\Client;

class UpdateMeetingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:update_meetings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the internal representation of all council meetings';

    protected $model;
    protected $socrataClient;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Meeting $model, Client $socrataClient)
    {
        parent::__construct();
        $this->model = $model;
        $this->socrataClient = $socrataClient;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $searchParameters = [
            '$order' => 'meeting_date DESC',
            '$where' => "record_type = 'Minutes'"
        ];
        $data = $this->socrataClient->get('/resource/mner-asqn.json', $searchParameters);

        $createdRecords = 0;
        $totalRecords = count($data);

        foreach ($data as $meetingData) {
            $meeting_time = $this->mergeMeetingDateAndTime($meetingData['meeting_date'], $meetingData['meeting_time']);

            $meeting = $this->model->find($meetingData['meeting_id']);
            if ($meeting === null) {
                // We need to create a new meeting.
                $this->model->create([
                    'id' => $meetingData['meeting_id'],
                    'date' => $meeting_time,
                    'meeting_type' => $meetingData['meeting_type'],
                    'record_type' => $meetingData['record_type'],
                    'location' => $meetingData['meeting_location']
                ]);
                $createdRecords++;
            }
        }

        $this->output->writeln("Updated. Created: {$createdRecords}, Total: {$totalRecords}");

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
