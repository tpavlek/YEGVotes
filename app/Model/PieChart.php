<?php

namespace App\Model;

use Illuminate\Support\Collection;

class PieChart
{

    public function __construct(Collection $pieItems)
    {
        $this->items = $pieItems;
    }

    public static function fromItemList(Collection $items)
    {
        $total = $items->sum();

        return new self($items->map(function ($item, $key) use ($total) {
            return new PieItem($key, ($item / $total) * 100);
        }));
    }

}
