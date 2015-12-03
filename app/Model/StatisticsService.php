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
        $query = "SELECT count(*) as count from `motions`
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
        $motionsWithDissent = DB::getPdo()->query($query)->fetch()['count'];

        $query = "SELECT count(*) as count, status from `motions`
                  WHERE
	                (select count(*) from `agenda_items`
	                                 where `agenda_items`.`id` = `motions`.`item_id`
	                                 and {$this->generateProtocolFilterRlikeQuery()}
                    ) >= 1
                    and status in ('Carried', 'None', 'No Vote', 'Failed')
                    group by status
                    ";

        $motionGroups = \DB::getPdo()->query($query)->fetchAll();
        dd($motionGroups);

        dd($this->generateProtocolFilterRlikeQuery());

        dd($motionsWithDissent);

        return $this->motionModel->withoutProtocolItems()->with('votes')->get()->groupBy(function (Motion $motion) {
            if ($motion->status == "Carried" && !$motion->hasDissent()) {
                return "Unanimous";
            }
            return $motion->status;
        });
    }


}
