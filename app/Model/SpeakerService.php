<?php

namespace Depotwarehouse\YEGVotes\Model;

class SpeakerService
{

    private $motions;

    public function __construct()
    {
        $item_ids = AgendaItem::requestsToSpeak()->get()->pluck('id');

        $motions = Motion::query()->with('agenda_item.meeting')
            ->whereIn('item_id', $item_ids)->get();

        $this->motions = $motions;
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
