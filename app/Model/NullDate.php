<?php

namespace Depotwarehouse\YEGVotes\Model;

class NullDate
{

    private $text;

    public function __construct($text = "")
    {
        $this->text = $text;
    }

    public function format($format)
    {
        return $this->text;
    }

    public function toDateString()
    {
        return "";
    }

}
