<?php

namespace Depotwarehouse\YEGVotes\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class AgendaItem
 * @property Collection motions
 * @package Depotwarehouse\YEGVotes\Model
 *
 * @method Builder bylaws()
 */
class AgendaItem extends Model
{

    const CATEGORY_IGNORE = "ignore";
    const CATEGORY_OTHER = "uncategorized";
    const CATEGORY_BYLAW = "bylaw";
    const CATEGORY_PASSED_WITHOUT_DEBATE = "passed-without-debate";
    const CATEGORY_INQUIRY = "councillor-inquiry";
    const CATEGORY_PRIVATE = "private";
    const CATEGORY_REVISED_DUE_DATE = "revised-due-date";


    const BYLAW_REGEX_MATCHER = '/^Bylaw \d+/';
    /*
     * Councillor inquiries and protocol items take the same form. A councillor inquiry is an agenda item that matches
     * the protocol item regex, and includes a motion.
     */
    const PROTOCOL_REGEX_MATCHER = '/\([A-Za-z]. [A-Za-z]+\)$/';

    use FiltersProtocolItems;

    public $table = "agenda_items";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [ 'id', 'meeting_id', 'title' ];
    protected $interestingMotions = null;

    public function __toString()
    {
        return $this->title;
    }

    public function getTitleAttribute()
    {
        $title = trim($this->attributes['title']);
        $title = str_replace('<br>', '', $title);
        return str_replace('<BR>', '', $title);
    }

    public function scopeWithoutProtocolItems(Builder $query)
    {
        return $this->filterProtocolItems($query);
    }

    public function getFormattedTitleAttribute()
    {
        $title = preg_replace('/(^<br>)|(^<BR>)|(<BR>$)|(<br>$)/', "", trim($this->title));
        if ($this->isBylaw()) {
            return preg_replace(self::BYLAW_REGEX_MATCHER, "<strong>$0</strong>", $title);
        }

        return $title;
    }

    /**
     * Get a scope that only contains agenda items relating to the passing of Bylaws. An agenda item must have
     * at least one motion that has at least one vote taken (future bylaw votes will not appear)
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeBylaws($query)
    {
        return $query->where('title', 'RLIKE', 'Bylaw [0-9](.*)')
            ->hasVotes()
            ->orderedByMeetingDate()
            ->with('motions.votes');
    }

    public function scopeRecent($query)
    {
        $recentThreshold = Carbon::now()->subDays(45)->toDateTimeString();
        return $query->join("meetings", "agenda_items.meeting_id", '=', 'meetings.id')
            ->select("agenda_items.*")
            ->where('meetings.date', '>', $recentThreshold);
    }

    /**
     * @param Builder $query
     */
    public function scopeOrderedByMeetingDate($query)
    {
        return $query->join("meetings", "agenda_items.meeting_id", '=', 'meetings.id')
            ->select("agenda_items.*")
            ->orderBy('meetings.date', 'DESC');
    }

    /**
     * Filters the current scope to only include items that have motions with votes on them.
     * @param Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasVotes($query)
    {
        return $query->whereHas('motions', function (Builder $query) {
            $query->has('votes');
        });
    }

    public function scopeHasMotions($query)
    {
        return $query->has('motions');
    }

    public function votes()
    {
        return $this->hasManyThrough(Vote::class, Motion::class, 'item_id');
    }

    /**
     * @param Builder $query
     */
    public function scopeInteresting($query)
    {
        return $query->whereNotIn($this->getConnection()->raw('upper(trim(title))'), config('uninteresting.agenda_items'));
    }

    public function scopeInterestingItems($query)
    {
        $query->bylaws()->whereHas('motions', function (Builder $query) {
            $query->whereHas('votes', function (Builder $query) {
                $query->whereNotIn('vote', [ 'Yes', 'Absent' ]);
            });
        });
    }

    public function scopeVoteAgainst($query, $council_member)
    {
        return $query->whereHas('motions.votes', function ($query) use ($council_member) {
            $query->where('vote', '=', "No")->where('voter', '=', $council_member);
        });
    }

    public function hasVotes()
    {
        $containsVotes = $this->motions->contains(function ($key, Motion $motion) {
            return $motion->votes->count();
        });
        return $containsVotes;
    }

    public function getVoteGroupsForCouncillor($council_member)
    {
        if ($this->votes == null) {
            throw new \Exception("Tried to get a vote group on a null vote for councillor: {$council_member}");
        }
        return $this->votes->filter(function (Vote $vote) use ($council_member) {
            return $vote->voter == $council_member;
        })->groupBy(function (Vote $vote) {
            return $vote->vote;
        })->sortBy(function (Collection $voteGroup) {
            return $voteGroup->first()->vote;
        });
    }

    /**
     * An agenda item contains dissent if any of its component motions have dissent
     * @return bool
     */
    public function hasDissent()
    {
        return $this->motions->contains(function ($key, Motion $motion) {
            return $motion->hasDissent();
        });
    }

    public function isUnanimous()
    {
        return !$this->hasDissent();
    }

    public function isProtocolItem()
    {
        return preg_match(self::PROTOCOL_REGEX_MATCHER, $this->title) === 1;
    }

    public function isCouncillorInquiry()
    {
         return $this->isProtocolItem() && $this->hasMotions();
    }

    public function isBylaw()
    {
        return preg_match(self::BYLAW_REGEX_MATCHER, $this->title) === 1;
    }

    public function passedWithoutDebate()
    {
        return ($this->motions->count() > 3) &&
            $this->motions->contains(function ($key, Motion $motion) {
                return $motion->isConsiderationForThirdReading();
            }) &&
            $this->motions->contains(function ($key, Motion $motion) {
                return $motion->isThirdReading();
            }) &&

            // If any of the motions have dissent, then they did not pass without debate.
            $this->motions->first(function ($key, Motion $motion) {
                return $this->hasDissent();
            }) == null;
    }

    public function isPrivate()
    {
        return $this->motions->contains(function ($_, Motion $motion) {
            return str_contains(strtolower($motion->description), 'meet in private') ||
                str_contains(strtolower($motion->description), 'remain private');
        });
    }

    public function isDueDateRevision()
    {
        return $this->motions->contains(function ($_, Motion $motion) {
            return $motion->isRevisedDueDate();
        });
    }


    public function hasMotions()
    {
        return $this->motions()->count() > 0;
    }

    public function isPrivateReport()
    {
        return str_contains(strtolower($this->title), "private reports");
    }

    public function meeting()
    {
        return $this->hasOne(Meeting::class, 'id', 'meeting_id');
    }

    public function motion()
    {
        return $this->hasOne(Motion::class, 'item_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function motions()
    {
        return $this->hasMany(Motion::class, 'item_id', 'id')
            ->orderBy('item_id', 'desc');
    }

    public function getRevisedDueDateAttribute()
    {
        return (new DueDateRevision($this))->revisedDueDate();
    }

    /**
     * Interesting agenda items are organized as following:
     *
     * The first set of items will always be from the latest meeting, to a maximum of five items. They are ordered by
     * their "interesting" factor.
     *
     * The next selection of items will be from the previous 45 days.
     * @param \Depotwarehouse\YEGVotes\Model\Meeting $last_meeting
     * @return static
     */
    public function getInterestingAgendaItems(Meeting $last_meeting)
    {

        $ranker = new AgendaItemRankingService();
        $recentItems = $ranker->forLatestMeeting($last_meeting->agenda_items);

        $recentItemIds = $recentItems->map(function (AgendaItem $agendaItem) {
            return $agendaItem->id;
        })->all();

        $allItems = $this->recent()->hasVotes()->with('motion.votes')->get();

        $allItems = $allItems->reject(function (AgendaItem $agendaItem) use ($recentItemIds) {
            return in_array($agendaItem->id, $recentItemIds);
        })
            ->sortByDesc(function (AgendaItem $agendaItem) {
                return $agendaItem->rankInteresting();
            })
            ->slice(0, 20);


        return $recentItems->merge($allItems);
    }

    /**
     *
     * The interesting algorithm is:
     *
     * (unanimous (0) | has_dissent (1)) * 0.5 = dissent_ranking
     * (45 - num_days_since_occurrence) * 0.3 = days_ranking
     * (any_item (0) | is_bylaw (1)) * 0.2 = bylaw_ranking
     *
     * Therefore, the "most interesting item possible" will be a 1, and the least interesting item a 0, with most items
     * falling as a floating point number between 0 and 1.
     *
     * @return float
     */
    protected function rankInteresting()
    {
        $ranker = new AgendaItemRankingService();
        return $ranker->rank($this);
    }

    /**
     * Gets a collection of (up-to) five interesting motions.
     *
     * These motions exclude any "no-vote" motions, and in a large set will include the first two and the final three.
     *
     * For efficiency reasons the result will be "cached" in `$this->interestingMotions`
     */
    public function interestingMotions()
    {
        if ($this->interestingMotions != null) {
            return $this->interestingMotions;
        }

        /** @var \Illuminate\Database\Eloquent\Collection $motions */
        $motions = $this->motions;

        $motions = $motions->reject(function ($motion) {
            return $motion->status == "No Vote";
        });

        // If this is true, all the motions are no-votes, in which case we want to return up to five of them
        if ($motions->count() == 0) {
            return $this->motions->slice(0, 5);
        }

        $interestingMotions = $motions->slice(0, 2)->merge($motions->slice($motions->count() - 3, 3));

        $this->interestingMotions = $interestingMotions;
        return $interestingMotions;
    }

    public function vote($council_member)
    {
        return $this->motions->first()->vote($council_member);
    }

    public function getDateAttribute()
    {
        return $this->meeting->date;
    }

    public function groupKey()
    {
        if ($this->isCouncillorInquiry()) {
            return self::CATEGORY_INQUIRY;
        }

        if ($this->isProtocolItem()) {
            return self::CATEGORY_IGNORE;
        }

        if ($this->isDueDateRevision()) {
            return self::CATEGORY_REVISED_DUE_DATE;
        }

        if ($this->isBylaw()) {
            if ($this->passedWithoutDebate()) {
                return self::CATEGORY_PASSED_WITHOUT_DEBATE;
            }

            return self::CATEGORY_BYLAW;
        }

        if ($this->isPrivate()) {
            return self::CATEGORY_PRIVATE;
        }

        return self::CATEGORY_OTHER;
    }

}
