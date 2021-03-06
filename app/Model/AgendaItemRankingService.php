<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class AgendaItemRankingService
{

    /**
     * Ranks the agenda items for the latest meeting, and returns a slice of the collection.
     *
     * This has special considerations compared to general ranking, as when computing the results for the latest meeting,
     * we want to return a maximum of five results, and we want to ensure that there are no zero-interest items present
     * in the result.
     *
     * @param \Illuminate\Support\Collection $latestMeetingItems
     * @return \Illuminate\Support\Collection
     */
    public function forLatestMeeting(Collection $latestMeetingItems)
    {
        $recentItems = $latestMeetingItems
            // Items without votes cannot be ranked.
            ->filter(function (AgendaItem $agendaItem) {
                return $agendaItem->hasVotes();
            })
            // We use sortBy and not sortByDesc because this will get reversed in the foreach below
            ->sortByDesc(function (AgendaItem $agendaItem) {
                return $this->rank($agendaItem);
            })
            // We want a maximum of five results
            ->slice(0, 5)
            // Any zero-ranking elements should not be included. We do this after the slice, to reduce the number of
            // elements that require a second `->rank()` call
            ->filter(function (AgendaItem $agendaItem) {
                return $this->rank($agendaItem) > 0;
            });

        return $recentItems;
    }

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
     * @param \App\Model\AgendaItem $agendaItem
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
