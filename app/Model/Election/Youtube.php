<?php

namespace Depotwarehouse\YEGVotes\Model\Election;

class Youtube extends PostableContent
{

    public $table = "election_youtube";

    public function render()
    {
        return "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/{$this->content}\" frameborder=\"0\" allowfullscreen></iframe>";
    }
}
