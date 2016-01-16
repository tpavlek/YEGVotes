<?php

namespace Depotwarehouse\YEGVotes\Model\Election;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{

    public $table = "election_candidates";

    public function getRunningNameAttribute()
    {
        $last_name = strtoupper($this->last_name);
        return "$last_name, {$this->first_name}";
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getImgUrlAttribute($value)
    {
        if ($value === null) {
            return "/img/election/ward12/none.png";
        }

        return $value;
    }

    public function getSlugAttribute()
    {
        return strtolower($this->first_name) . strtolower($this->last_name);
    }

    public function election()
    {
        return $this->belongsTo(Election::class, 'election_id', 'id');
    }

    public function postable_content()
    {
        $getPostable = new GetPostable();

        return $getPostable->sort(
            $this->tweets()->get(),
            $this->facebook_posts()->get(),
            $this->youtube_videos()->get(),
            $this->arbitrary_posts()->get()
        );
    }

    public function tweets()
    {
        return $this->morphedByMany(Tweet::class, 'postable', 'election_postable_content', 'candidate_id', 'postable_id')->withPivot('approved_at')->whereNotNull('election_postable_content.approved_at');
    }

    public function facebook_posts()
    {
        return $this->morphedByMany(FacebookPost::class, 'postable', 'election_postable_content', 'candidate_id', 'postable_id')->withPivot('approved_at')->whereNotNull('election_postable_content.approved_at');
    }

    public function youtube_videos()
    {
        return $this->morphedByMany(Youtube::class, 'postable', 'election_postable_content', 'candidate_id', 'postable_id')->withPivot('approved_at')->whereNotNull('election_postable_content.approved_at');
    }

    public function arbitrary_posts()
    {
        return $this->morphedByMany(ArbitraryPostable::class, 'postable', 'election_postable_content', 'candidate_id', 'postable_id')->withPivot('approved_at')->whereNotNull('election_postable_content.approved_at');
    }

}
