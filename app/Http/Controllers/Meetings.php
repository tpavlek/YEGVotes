<?php

namespace App\Http\Controllers;

use Barryvdh\Reflection\DocBlock\Type\Collection;
use App\Model\AgendaItem;
use App\Model\Meeting;

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

        $speakers = $meeting->speakers();

        $groupedAgendaItems = $meeting->agenda_items()->interesting()->get()->groupBy(function (AgendaItem $agendaItem) {
            return $agendaItem->groupKey();
        })->map(function($group, $key) {
            if ($key == AgendaItem::CATEGORY_REVISED_DUE_DATE) {
                return $group->sortBy('revised_due_date');
            }
            return $group;
        });

        $futureMeetings = new Collection();

        if ($groupedAgendaItems->has(AgendaItem::CATEGORY_REVISED_DUE_DATE)) {
            $dates = $groupedAgendaItems->get(AgendaItem::CATEGORY_REVISED_DUE_DATE)->map(function (AgendaItem $agendaItem) { return $agendaItem->revised_due_date->toDateString(); });

            $futureMeetings = Meeting::query()->whereIn(\DB::raw('date(date)'), $dates)->get()->keyBy(function (Meeting $meeting) { return $meeting->date->toDateString(); });
        }

        $attendance = $meeting->getAttendance()->groupBy('present');

        return view('meetings.show')
            ->with('meeting', $meeting)
            ->with('groupedAgendaItems', $groupedAgendaItems)
            ->with('attendance', $attendance)
            ->with('future_meetings', $futureMeetings)
            ->with('speakers', $speakers);
    }
}
