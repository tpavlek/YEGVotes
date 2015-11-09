<?php

namespace Depotwarehouse\YEGVotes\Model;

use Carbon\Carbon;

class AgendaItemRankingService
{

    /**
     *
     * The interesting algorithm is:
     *
     * (unanimous (0) | has_dissent (1)) * 0.5 = dissent_ranking
     * (45 - num_days_since_occurrence) * 0.3 = days_ranking
     * (any_item (0) | is_bylaw (1)) * 0.2 = bylaw_ranking
     *
     * Therefore, the "most interesting item possible" will be a 1, and the least interesting item a 0, with most items
     * falling as a floating point number between 0 and 1.
     *
     * Certain items are simply never interesting, so we guard against those.
     *
     * @param \Depotwarehouse\YEGVotes\Model\AgendaItem $agendaItem
     * @return float
     */
    public function rank(AgendaItem $agendaItem)
    {
        // Private reports are not interesting, so we'll give them a rank of zero.
        if (strtolower($agendaItem->title) == "private reports" ) {
            return 0;
        }

        if (strtolower($agendaItem->title) == "adoption of agenda") {
            return 0;
        }

        if (strtolower($agendaItem->title) == "adoption of minutes") {
            return 0;
        }

        $ranking = 0;
        $ranking += (int)$agendaItem->hasDissent() * 0.5;
        $ranking += Carbon::now()->diffInDays($agendaItem->date) * 0.3;
        $ranking += (int)$agendaItem->isBylaw() * 0.2;

        return $ranking;
    }

}
