<?php

namespace Depotwarehouse\YEGVotes\Model\Election;

class Tweet extends PostableContent
{

    public $table = "election_tweets";

    public function render()
    {
        return $this->content;
    }
}
