<?php

namespace App\Http\Controllers;

use App\Model\Motion;
use App\Model\SpeakerService;

class Speakers extends Controller
{

    public function index(SpeakerService $speakerService)
    {
        return view('stats.speakers')
            ->with('speakersByYear', $speakerService->speakersByYear())
            ->with('speakersByCommittee', $speakerService->speakersByCommittee())
            ->with('topSpeakers', $speakerService->topSpeakers());
    }

    public function fullList(SpeakerService $speakerService)
    {
        return view('speakers.list')
            ->with('speakers', $speakerService->allSpeakers());
    }

    public function show($speaker)
    {
        $motions = Motion::query()->with('agenda_item.meeting')->where('description', 'like', "%$speaker%")->get();

        $meetings = $motions->map(function ($motion) {
            return $motion->meeting;
        })
            ->unique(function ($meeting) {
                return $meeting->id;
            });
        return view('speakers.show')
            ->with('speaker', $speaker)
            ->with('meetings', $meetings);
    }

}
