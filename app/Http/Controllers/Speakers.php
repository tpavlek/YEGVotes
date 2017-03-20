<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Depotwarehouse\YEGVotes\Model\Motion;

class Speakers extends Controller
{

    public function index()
    {

        $item_ids = AgendaItem::requestsToSpeak()->get()->pluck('id');

        $motions = Motion::query()->with('agenda_item.meeting')
            ->whereIn('item_id', $item_ids)->get();


        $speakersByYear = $motions->groupBy('year')
            ->map(function ($year) {
                return $year->groupBy(function ($motion) {
                    return $motion->meeting->meeting_type;
                })
                    ->map(function ($groupedByMeeting) {
                        return $groupedByMeeting->sum(function ($motion) {
                            return count($motion->parseSpeakers());
                        });
                    });
            });

        $speakersByEngagement = $motions->flatMap(function ($motion) {
            return $motion->parseSpeakers();
        })
            ->map(function ($speaker) {
                $parts = explode('  ', $speaker);
                return [
                    'speaker' => $parts[0],
                    'group' => (isset($parts[1])) ? $parts[1] : ""
                ];
            })
            ->groupBy('speaker')
            ->map(function ($group) {
                return $group->count();
            })
            ->sortByDesc(function ($group) {
                return $group;
            });

        dd($speakersByEngagement);

        dd($speakersByYear);

        return view('stats.speakers')->with('speakersByYear', $speakersByYear);

        dd($speakersByYear);

        $motions->flatMap(function ($motion) {
            return $motion->parseSpeakers();
        })
            ->map(function ($speaker) {
                $parts = explode('  ', $speaker);
                return [
                    'speaker' => $parts[0],
                    'group' => (isset($parts[1])) ? $parts[1] : ""
                ];
            })
            ->groupBy('speaker')
            ->map(function ($group) {
                return $group->count();
            })
            ->sortByDesc(function ($group) {
                return $group;
            });

        dd($speakers);


        $speakers = Motion::query()->whereIn('item_id', $item_ids)->get()
            ->groupBy('year')
            ->map(function ($year) {
                return $year->flatMap(function ($motion) {
                    return $motion->parseSpeakers();
                })
                    ->map(function ($speaker) {
                        $parts = explode('  ', $speaker);
                        return [
                            'speaker' => $parts[0],
                            'group' => (isset($parts[1])) ? $parts[1] : ""
                        ];
                    })
                    ->groupBy('speaker')
                    ->map(function ($group) {
                        return $group->count();
                    });
            });

        dd($speakers);


    }

}
