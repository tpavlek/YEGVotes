<?php

namespace App\Model;

class PieItem
{

    public function __construct($label, $percentage)
    {
        if (!is_numeric($percentage) || $percentage > 100) {
            throw new \InvalidArgumentException("Invalid Percentage Given");
        }

        $this->label = $label;
        $this->percentage = $percentage;
    }

}
