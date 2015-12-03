<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\AgendaItem;

class Search extends Controller
{
    protected $agendaModel;

    public function __construct(AgendaItem $agendaModel)
    {
        $this->agendaModel = $agendaModel;
    }

    public function search($term)
    {
        $exact_matches = $this->agendaModel->newQuery()->where('title', 'like', "%{$term}%");
        if ($exact_matches->count()) {
            return view('search_results')->with('results', $exact_matches->get())->with('term', $term);
        }
        dd('No match');
    }

}
