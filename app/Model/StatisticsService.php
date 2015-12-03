<?php

namespace Depotwarehouse\YEGVotes\Model;

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
