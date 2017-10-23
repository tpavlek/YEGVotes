<?php

namespace App\Model;

trait FiltersProtocolItems
{

    protected $protocolItemTitles = [
        'adoption of minutes',
        'adoption of agenda',
        'call to order',
        'items for discussion and related business',
        'adjournment',
        'protocol items',
        'select items for debate'
    ];

    protected function generateProtocolFilterRlikeQuery()
    {
        $rlike = implode("|", $this->protocolItemTitles);
        return "`agenda_items`.`title` not rlike '{$rlike}'";
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @return mixed
     */
    protected function filterProtocolItems($query)
    {
        return $query->where('agenda_items.title', 'not like', '%adoption of minutes%')
            ->where('agenda_items.title', 'not like', '%adoption of agenda%')
            ->where('agenda_items.title', 'not like', '%call to order and related business%')
            ->where('agenda_items.title', 'not like', '%call to order%')
            ->where('agenda_items.title', 'not like', '%items for discussion and related business%')
            ->where('agenda_items.title', 'not like', '%adjournment%')
            ->where('agenda_items.title', 'not like', '%protocol items%')
            ->where('agenda_items.title', 'not like', '%select items for debate%');
    }
}
