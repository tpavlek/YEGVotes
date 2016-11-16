<?php

namespace Depotwarehouse\YEGVotes\Model;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

class StatisticsService
{

    use FiltersProtocolItems;

    protected $agendaModel;
    protected $motionModel;

    public function __construct(AgendaItem $agendaModel, Motion $motionModel)
    {
        $this->agendaModel = $agendaModel;
        $this->motionModel = $motionModel;
    }

    public function privateMotions()
    {
        $privateMotions = collect(DB::table('motions')
            ->join('agenda_items', 'agenda_items.id', '=', 'motions.item_id')
            ->join('meetings', 'meetings.id', '=', 'agenda_items.meeting_id')
            ->where(function($query) {
                $query->orWhere('description', 'like', '%meet in private%')
                    ->orWhere('description', 'like', '%remain private%');
            })
            ->where('mover', 'not like', '%Board Member%')
            ->where('mover', 'not like', '%Committee Member%')
            ->where('meeting_type', 'not like', '%LRT Governance%')
            ->select([
                'item_id',
                'mover',
                'seconder',
                'description',
                'meeting_id',
                'date'
            ])
            ->get());

        $movers = $privateMotions->groupBy('mover')->map(function ($moverGroup) {
            return $moverGroup->count();
        })->sortByDesc(function ($motions) {
            return $motions + (1 / random_int(2, 255));
        });

        $sections = $privateMotions->flatMap(function ($motion) {
            $match = preg_match('/(?<=sections|section|sectons) [\d (and)]+/', $motion->description, $matches);
            if (!$match) {
                return ['none'];
            }

            $result = [];
            foreach (explode(' ', $matches[0]) as $section) {
                if (!is_numeric(trim($section))) {
                    continue;
                }
                $result[] = trim($section);
            }

            return $result;
        })
            ->groupBy(function ($section) {
                return $section;
            })->map(function ($sectionGroup) {
                return $sectionGroup->count();
            })
            ->sort()->reverse();

        $meetingsInPrivate = $privateMotions->pluck('meeting_id')->unique();
        $totalMeetings = DB::table('meetings')->where('meeting_type', 'not like', '%LRT Governance%')->count();

        $perMonth = $privateMotions->groupBy(function ($privateMotion) {
            $date = (new Carbon($privateMotion->date, new \DateTimeZone('America/Edmonton')));

            return $date->year . "-" . $date->month;
        })
            ->map(function ($perMonth) {
                return $perMonth->pluck('meeting_id')->unique()->count();
            })
            ->sortBy(function ($value, $key) {
                $pieces = explode('-', $key);
                return $pieces[0] * 1000 + $pieces[1];
            });

        $start = new Carbon('2013-11-01');
        while ($start->addMonth()->lt(Carbon::now()))
        {
            if (!$perMonth->has($start->year . '-' . $start->month)) {
                $perMonth->put($start->year . '-' . $start->month, 0);
            }
        }

        return [ 'movers' => $movers, 'sections' => $sections, 'private_meetings' => $meetingsInPrivate, 'total_meetings' => $totalMeetings, 'per_month' => $perMonth ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function voteTypeInformation()
    {
        return $this->agendaModel->withoutProtocolItems()->get()->groupBy(function (AgendaItem $agendaItem) {
            if ($agendaItem->isPrivateReport()) {
                return "private_reports";
            }

            if ($agendaItem->isBylaw()) {
                return "bylaw";
            }
            return "notbylaw";
        })->toBase();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function motionStatuses()
    {
        $query = "SELECT count(*) as amount from `motions`
                  WHERE
	                (select count(*) from `agenda_items`
	                                 where `agenda_items`.`id` = `motions`.`item_id`
	                                 and {$this->generateProtocolFilterRlikeQuery()}
                    ) >= 1
                    and `motions`.`status` = 'Carried'
                    and (select count(*) from `votes`
                                         where `votes`.`motion_id` = `motions`.`id`
                                         and (`votes`.`vote` = 'No' or `votes`.`vote` = 'Abstain')
                        ) >= 1";
        $motionsWithDissent = DB::getPdo()->query($query)->fetch()['amount'];

        $query = "SELECT count(*) as amount, status as label from `motions`
                  WHERE
	                (select count(*) from `agenda_items`
	                                 where `agenda_items`.`id` = `motions`.`item_id`
	                                 and {$this->generateProtocolFilterRlikeQuery()}
                    ) >= 1
                    and status in ('Carried', 'None', 'No Vote', 'Failed')
                    group by status
                    ";
        $motionGroups = \DB::getPdo()->query($query)->fetchAll();

        $result = [];

        foreach ($motionGroups as $group) {
            $result[$group['label']] = $group['amount'];
        }

        $result['Unanimous'] = $result['Carried'] - $motionsWithDissent;
        $result['Non-Unanimous'] = $motionsWithDissent;
        unset($result['Carried']);

        $pie = PieChart::fromItemList(collect($result));

        return $pie;
    }

    public function motionsByCouncillor()
    {
        $query = "SELECT count(*) as motions, mover
                  FROM motions
                  WHERE mover like '%Coun%' or mover like '%Mayor%'
                  GROUP BY mover
                  ORDER BY motions DESC";

        $result = DB::getPdo()->query($query)->fetchAll();

        $result = collect($result)->map(function ($entry) {
            return [ 'mover' => new CouncilMember($entry['mover']), 'motions' => $entry['motions'] ];
        });

        return $result;
    }

    public function secondsByCouncillor()
    {
        $query = "SELECT count(*) as motions, seconder
                  FROM motions
                  WHERE seconder like '%Coun%' or seconder like '%Mayor%'
                  GROUP BY seconder
                  ORDER BY motions DESC";

        $result = DB::getPdo()->query($query)->fetchAll();

        $result = collect($result)->map(function ($entry) {
            return [ 'seconder' => new CouncilMember($entry['seconder']), 'motions' => $entry['motions'] ];
        });

        return $result;
    }

    public function motionPairings()
    {
        $query = "SELECT count(*) as motions, mover, seconder
                  FROM motions
                  WHERE description rlike 'be read a|be considered for third'
                  AND mover is not null AND seconder is not null
                  GROUP BY mover, seconder
                  ORDER BY motions DESC";

        $result = DB::getPdo()->query($query)->fetchAll();

        $result = collect($result)->map(function ($entry) {
            return [
                'mover' => new CouncilMember($entry['mover']),
                'seconder' => new CouncilMember($entry['seconder']),
                'motions' => $entry['motions']
            ];
        });

        return $result;
    }


}
