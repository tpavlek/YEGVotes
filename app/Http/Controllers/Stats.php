<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Model\Attendance;
use App\Model\AttendanceRecord;
use App\Model\StatisticsService;
use Laracasts\Utilities\JavaScript\PHPToJavaScriptTransformer;

class Stats extends Controller
{

    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function show()
    {
        return view('stats');
    }

    public function attendance()
    {
        $attendance = (new Attendance())->getRecordsForCouncil();
        $attendance_records = $attendance->sortBy(function (AttendanceRecord $attendanceRecord) {
            return $attendanceRecord->sortValue();
        });

        $skipped_meetings = $this->statisticsService->skippedMeetings();

        $skipped_meetings = $skipped_meetings->sortByDesc(function ($skipped) {
            return $skipped['skipped'];
        })->slice(0,5);

        return view('stats.attendance')
            ->with('attendance_records', $attendance_records)
            ->with('skipped_meetings', $skipped_meetings);
    }

    public function movers()
    {
        $movers = $this->statisticsService->motionsByCouncillor();
        $seconders = $this->statisticsService->secondsByCouncillor();

        $pairings = $this->statisticsService->motionPairings();

        return view('stats.movers')
            ->with('movers', $movers)
            ->with('seconders', $seconders)
            ->with('pairings', $pairings);
    }

    public function inPrivate(PHPToJavaScriptTransformer $javascript)
    {
        $privateMotions = $this->statisticsService->privateMotions();

        $labels = $privateMotions['per_month']->keys()->map(function ($key) {
            $date = new Carbon($key);

            return $date->format('M (y)');
        });

        $fills = [];
        $borders = [];

        foreach ($privateMotions['per_month'] as $month) {
            $r = random_int(0, 255);
            $g = random_int(0, 255);
            $b = random_int(0, 255);

            $fills[] = "rgba($r,$g,$b,0.2)";
            $borders[] = "rgba($r,$g,$b,1)";
        }

        $javascript->put('labels', $labels);
        $javascript->put('data', $privateMotions['per_month']->values());
        $javascript->put('fills', $fills);
        $javascript->put('borders', $borders);
        $javascript->put('section_labels', $privateMotions['sections']->keys()->map(function($key) { return "$key"; }));
        $javascript->put('section_data', $privateMotions['sections']->values());
        $javascript->put('section_fills', array_slice($fills, 0, $privateMotions['sections']->count()));
        $javascript->put('section_borders', array_slice($borders, 0, $privateMotions['sections']->count()));

        return view('stats.private', $privateMotions);
    }

}
