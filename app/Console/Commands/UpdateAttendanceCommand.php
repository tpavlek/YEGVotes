<?php

namespace Depotwarehouse\YEGVotes\Console\Commands;

use Depotwarehouse\YEGVotes\Model\Attendance;
use Depotwarehouse\YEGVotes\Model\Meeting;
use Illuminate\Console\Command;
use socrata\soda\Client;

class UpdateAttendanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yegvotes:update_attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Attendance records for all meetings in the database';

    protected $model;
    protected $meetings;
    protected $sodaClient;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Meeting $meetings, Attendance $model, Client $sodaClient)
    {
        parent::__construct();

        $this->model = $model;
        $this->meetings = $meetings;
        $this->sodaClient = $sodaClient;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $searchParams = [
            '$limit' => 50000
        ];
        $data = $this->sodaClient->get("/resource/prdj-dgnz.json", $searchParams);

        $createdRecords = 0;
        $totalRecords = count($data);
        foreach ($data as $attendanceData) {
            $meeting = $this->meetings->find($attendanceData['meeting_id']);

            if ($meeting == null) {
                $this->output->writeln("There was no meeting with minutes with ID: {$attendanceData['meeting_id']}");
                continue;
            }

            $existingRecord = $this->model->attendeeAtMeeting($attendanceData['attendee'], $attendanceData['meeting_id']);

            if ($existingRecord === null) {
                // We need to create a new record.
                $this->model->create([
                    'meeting_id' => $attendanceData['meeting_id'],
                    'item_id' => $attendanceData['item_id'],
                    'attendee' => $attendanceData['attendee'],
                    'present' => ($attendanceData['status'] == 'Present')
                ]);
                $createdRecords++;
            }

        }

        $this->output->writeln("Processed {$totalRecords}, created {$createdRecords} records");
    }
}
