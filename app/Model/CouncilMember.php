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
