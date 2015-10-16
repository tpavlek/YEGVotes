<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\Attendance;

class Councillors extends Controller
{

    public function __construct(Attendance $attendanceModel)
    {
        $this->attendanceModel = $attendanceModel;
    }

    public function index()
    {
        $records = $this->attendanceModel->getRecordsForCouncil();
        return view('councillor_list')->with('attendance', $records);
    }

}
