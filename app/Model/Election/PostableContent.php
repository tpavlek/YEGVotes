<?php

namespace Depotwarehouse\YEGVotes\Model\Election;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Query\Builder;

abstract class PostableContent extends Model
{

    public $fillable = [ 'content' ];

    public abstract function render();

    /**
     * @return MorphToMany
     */
    public function candidates()
    {
        return $this->morphToMany(Candidate::class, 'postable', 'election_postable_content', 'postable_id', 'candidate_id')->withPivot('approved_at', 'rejected_at');
    }

    public function unapproved()
    {
        return $this->newQuery()->whereExists(function(Builder $query) {
            $query->from('election_postable_content')
                ->where('election_postable_content.postable_id', '=', \DB::raw("{$this->table}.id"))
                ->where('election_postable_content.postable_type', '=', \DB::raw("\"" .addslashes(get_class($this)) . "\""))
                ->whereNull('election_postable_content.approved_at')
                ->whereNull('election_postable_content.rejected_at');
        })
            ->get();
    }

    public function approved()
    {
        return $this->newQuery()->whereExists(function(Builder $query) {
            $query->from('election_postable_content')
            ->where('election_postable_content.postable_id', '=', \DB::raw("{$this->table}.id"))
            ->where('election_postable_content.postable_type', '=', \DB::raw("\"" .addslashes(get_class($this)) . "\""))
            ->whereNotNull('election_postable_content.approved_at')
            ->whereNull('election_postable_content.rejected_at');
        })
            ->get();
    }
}
