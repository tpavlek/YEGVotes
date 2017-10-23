<?php

namespace App\Jobs;

use App\Model\Councillor;
use socrata\soda\Client;

class UpdateCouncillors
{

    /**
     * @var Client
     */
    private $socrataClient;
    /**
     * @var Councillor
     */
    private $councillorModel;

    public function __construct(Client $socrataClient, Councillor $councillorModel)
    {

        $this->socrataClient = $socrataClient;
        $this->councillorModel = $councillorModel;
    }

    public function execute()
    {
        $allCouncillors = $this->councillorModel->all();
        $query = [
            '$where' => "attendee like '%Coun%' or attendee like '%Mayor%'",
            '$select' => 'attendee',
            '$group' => 'attendee',
        ];
        $results = $this->socrataClient->get("/resource/7en4-rwfd.json", $query);

        collect($results)->each(function ($attendee) use ($allCouncillors) {

            $councillorExists = $allCouncillors->contains(function (Councillor $councillor) use ($attendee) {
                return $councillor->id == $attendee['attendee'];
            });

            if (!$councillorExists) {
                $allCouncillors->push($this->councillorModel->fromName($attendee['attendee']));
            }
        });
    }

}
