<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\Meeting;

class Meetings extends Controller
{

    public function __construct(Meeting $model)
    {
        $this->model = $model;
    }

    public function listMeetings()
    {
        $meetings = $this->model->with('agenda_items')->orderBy('date', 'desc')->get();

        $meetings = $meetings->groupBy(function(Meeting $meeting) {
            return $meeting->date->format("Y-m");
        });

        return view('meetings.list')->with('meetings', $meetings);
    }

    public function show($meeting_id)
    {
        $meeting = $this->model->with('agenda_items.motions.votes')->findOrFail($meeting_id);
        $attendance = $meeting->getAttendance()->groupBy('present');

        return view('meetings.show')
            ->with('meeting', $meeting)
            ->with('attendance', $attendance);
    }
}
