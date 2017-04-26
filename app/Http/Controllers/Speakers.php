<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Depotwarehouse\YEGVotes\Model\Motion;
use Depotwarehouse\YEGVotes\Model\SpeakerService;

class Speakers extends Controller
{

    public function index(SpeakerService $speakerService)
    {

        dd($speakerService->topSpeakers());

        $item_ids = AgendaItem::requestsToSpeak()->get()->pluck('id');

        $motions = Motion::query()->with('agenda_item.meeting')
            ->whereIn('item_id', $item_ids)->get();


        /*
        $pub_hearing = $motions->filter(function ($motion) {
            return $motion->meeting->meeting_type == Meeting::TYPE_PUBLIC_HEARING;
        })
            ->map(function ($motion) {
                return $motion->parseSpeakers();
            });

        dd($pub_hearing);*/


        $speakersByYear = $motions->groupBy('year')
            ->map(function ($year) {
                return $year->groupBy(function ($motion) {
                    return $motion->meeting->meeting_type;
                })
                    ->flatMap(function ($groupedByMeeting) {

                        return $groupedByMeeting->flatMap(function ($motion) {
                            return $motion->parseSpeakers();
                        });

                    })
                    ->map(function ($speaker) {
                        return explode('  ', $speaker)[0];
                    })
                    ->map(function ($speaker) {
                        return explode(',', $speaker)[0];
                    })
                    ->map(function ($speaker) {
                        return trim(explode(' and', $speaker)[0]);
                    })
                    ->reject(function ($speaker) {
                        return (str_contains(strtolower($speaker), '(to answer question'));
                    })
                    ->unique();
            });

        dd($speakersByYear);

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
