<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\Attendance;
use Depotwarehouse\YEGVotes\Model\Meeting;

class Councillors extends Controller
{

    public function __construct(Attendance $attendanceModel, Meeting $meetingModel)
    {
        $this->attendanceModel = $attendanceModel;
        $this->meetingModel = $meetingModel;
    }

    public function index()
    {
        $last_meeting = $this->meetingModel->findLatestMeeting();


        $records = $this->attendanceModel->getRecordsForCouncil();
        return view('councillor_list')
            ->with('attendance', $records)
            ->with('voting_items', $last_meeting->getVotingItems());
    }

}
