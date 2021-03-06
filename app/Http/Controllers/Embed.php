<?php

namespace App\Http\Controllers;

use App\Model\AgendaItem;
use App\Model\Attendance;
use App\Model\AttendanceRecord;

class Embed extends Controller
{

    public function attendanceInfo(Attendance $attendanceModel)
    {
        $attendance_records = $attendanceModel->getRecordsForCouncil();
        $attendance_records = $attendance_records->sortBy(function (AttendanceRecord $attendanceRecord) {
            return $attendanceRecord->sortValue();
        });

        // We only want the top attender and the bottom attender
        $attendance_records = collect([ $attendance_records->first(), $attendance_records->last() ]);

        return view('embed')
            ->with('view', view('about.attendance')->with('attendance_records', $attendance_records));
    }

    public function agendaItem(AgendaItem $agendaItem)
    {
        return view('embed')
            ->with('view', view('agendaItemPartial')->with('agenda_item', $agendaItem)->with('checkFirst', true));
    }

}
