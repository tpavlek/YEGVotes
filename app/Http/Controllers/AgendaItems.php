<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\AgendaItem;

class AgendaItems extends Controller
{

    public function __construct(AgendaItem $model)
    {
        $this->model = $model;
    }

    public function show($agenda_item_id)
    {
        $agenda_item = $this->model->find($agenda_item_id);

        return view('agenda_items.show')->with('agenda_item', $agenda_item);
    }

}
