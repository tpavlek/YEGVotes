<?php

namespace Depotwarehouse\YEGVotes\Model;

use Illuminate\Database\Eloquent\Collection;

class SpeakerService
{

    /** @var  Collection */
    private $motions;

    public function __construct()
    {
        $item_ids = AgendaItem::requestsToSpeak()->get()->pluck('id');

        $motions = Motion::query()->with('agenda_item.meeting')
            ->whereIn('item_id', $item_ids)->get();

        $this->motions = $motions;
    }

    public function speakersByCommittee()
    {
        return $this->motions->groupBy(function (Motion $motion) {
            return $motion->meeting->meeting_type;
        })
            ->map(function (Collection $groupedByType) {
                return $groupedByType->flatMap(function (Motion $motion) {
                    return $motion->parseSpeakers();
                })
                    ->map(function ($speaker) {
                        $speaker = explode('  ', $speaker)[0];
                        $speaker = explode(',', $speaker)[0];
                        $speaker = trim(explode(' and', $speaker)[0]);
                        return $speaker;
                    })
                    ->reject(function ($speaker) {
                        return (str_contains(strtolower($speaker), '(to answer question'));
                    })
                    ->unique();
            })
                ->map(function ($group) {
                    return $group->count();
                })
                ->sortByDesc(function ($count) {
                    return $count;
                });

    }

    public function speakersByYear()
    {
        $grouped = $this->motions->groupBy('year')
            ->map(function (Collection $year) {
                return $year
                    ->flatMap(function (Motion $motion) {
                        return $motion->parseSpeakers();

                    })
                    ->map(function ($speaker) {
                        $speaker = explode('  ', $speaker)[0];
                        $speaker = explode(',', $speaker)[0];
                        $speaker = trim(explode(' and', $speaker)[0]);
                        return $speaker;
                    })
                    ->reject(function ($speaker) {
                        return (str_contains(strtolower($speaker), '(to answer question'));
                    })
                    ->unique();
            });

        $overview = $grouped->sortBy(function ($value, $key) {
            return $key;
        })
            ->map(function ($group) {
                return $group->count();
            });

        $grouped->put('overview', $overview->all());

        return $grouped;
    }

    public function topSpeakers()
    {
        return $this->motions
            ->flatMap(function ($motion) {
                return $motion->parseSpeakers();
            })
            ->map(function ($speaker) {
                $speaker = explode('  ', $speaker)[0];
                $speaker = explode(',', $speaker)[0];
                $speaker = trim(explode(' and', $speaker)[0]);
                return $speaker;
            })
            ->reject(function ($speaker) {
                return (str_contains(strtolower($speaker), '(to answer question'));
            })
            ->groupBy(function ($speaker) {
                return $speaker;
            })
            ->map(function ($group) {
                return $group->count();
            })
            ->sortByDesc(function ($group) {
                return $group;
            })
            ->slice(0, 10);
    }

}
