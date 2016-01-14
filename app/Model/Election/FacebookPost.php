<?php

namespace Depotwarehouse\YEGVotes\Model\Election;

class FacebookPost extends PostableContent
{

    public $table = "election_facebook_posts";

    public function render()
    {
        return "<div class=\"fb-post\" data-href=\"{$this->content}\"></div>";
    }
}
