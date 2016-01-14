<?php

namespace Depotwarehouse\YEGVotes\Model\Election;

class Tweet extends PostableContent
{

    public $fillable = [ 'content' ];

    public $table = "election_tweets";

    public function render()
    {
        return $this->content;
    }

    public function candidates()
    {
        return $this->morphToMany(Candidate::class, 'postable', 'election_postable_content', 'postable_id', 'candidate_id');
    }
}
