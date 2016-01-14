<?php

namespace Depotwarehouse\YEGVotes\Model\Election;

class ArbitraryPostable extends PostableContent
{

    public $table = "election_arbitrary_postables";

    // TODO this might be unsafe if they post XSS to the approver.
    public function render()
    {
        return $this->content;
    }
}
