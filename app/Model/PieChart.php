<?php

namespace Depotwarehouse\YEGVotes\Model;

use Illuminate\Support\Collection;

class PieChart
{

    public function __construct(Collection $pieItems)
    {
        $this->items = $pieItems;
    }

    public static function fromGroups(Collection $collectedGroups)
    {
    }

}
