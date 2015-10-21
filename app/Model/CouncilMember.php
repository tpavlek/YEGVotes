<?php

namespace Depotwarehouse\YEGVotes\Model;

class CouncilMember
{

    public function __construct($council_member)
    {
        $this->name = $council_member;
        $this->ward = Ward::getWardFor($council_member);
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getWardNumber()
    {
        if ($this->ward == "Mayor") return 0;
        return intval($this->ward);
    }


    public function getShortWard()
    {
        return "ward{$this->ward}";
    }

    public function getWard()
    {
        if ($this->ward == "Mayor") {
            return $this->ward;
        }

        return "Ward {$this->ward}";
    }

}
