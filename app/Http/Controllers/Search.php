<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Search extends Controller
{
    protected $agendaModel;

    public function __construct(AgendaItem $agendaModel)
    {
        $this->agendaModel = $agendaModel;
    }

    public function search($term, Request $request)
    {
        $query = $this->agendaModel->newQuery();

        if ($request->has('meeting_type')) {
            $query = $query->join('meetings', 'meetings.id', '=', 'agenda_items.meeting_id');
            foreach (explode(',', $request->get('meeting_type')) as $meeting_type) {
                $query = $query->where('meetings.meeting_type', '=', $meeting_type);
            }
        }

        $query = $query->where(function(Builder $query) use ($term) {
            foreach (explode(',', $term) as $search_term) {
                $query = $query->orWhere('title', 'like', "%$search_term%");
            }
        });


        $query = $query->orderBy('meeting_id', 'DESC');

        return view('search_results')->with('results', $query->select('agenda_items.*')->get())->with('term', $term);
    }

}
