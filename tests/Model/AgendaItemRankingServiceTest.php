<?php

namespace Depotwarehouse\YEGVotes\Tests\Model;

use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Depotwarehouse\YEGVotes\Model\AgendaItemRankingService;
use Depotwarehouse\YEGVotes\Model\Meeting;
use Depotwarehouse\YEGVotes\Model\Motion;
use Depotwarehouse\YEGVotes\Model\Vote;
use Illuminate\Support\Collection;
use Mockery as m;

class AgendaItemRankingServiceTest extends \TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_returns_lowest_ranking_if_item_is_private_reports()
    {
        $ranker = new AgendaItemRankingService();
        $item = new AgendaItem([ 'title' => "PRIVATE REPORTS" ]);

        $rank = $ranker->rank($item);

        $this->assertSame(0, $rank);
    }

    /**
     * @test
     */
    public function it_returns_lowest_ranking_if_item_is_adoption_of_agenda_or_minutes()
    {
        $ranker = new AgendaItemRankingService();

        $adoptionOfMinutes = new AgendaItem([ 'title' => 'Adoption of Minutes' ]);

        $rank = $ranker->rank($adoptionOfMinutes);

        $this->assertSame(0, $rank);

        $adoptionOfAgenda = new AgendaItem([ 'title' => 'Adoption of Agenda' ]);

        $rank = $ranker->rank($adoptionOfAgenda);

        $this->assertSame(0, $rank);
    }

    /**
     * @test
     */
    public function it_can_rank_items_in_the_context_of_the_latest_meeting()
    {
        $ranker = new AgendaItemRankingService();
        $unanimousMotions = new Collection([
            (new Motion())->setRelation('votes', new Collection([
                new Vote([ 'voter' => 'Coun1', 'vote' => 'Yes' ]),
                new Vote([ 'voter' => 'Coun2', 'vote' => 'Yes' ]),
                new Vote([ 'voter' => 'Coun3', 'vote' => 'Yes' ]),
            ]))
        ]);

        $dissentingVotes = new Collection([
            new Vote([ 'voter' => 'Coun1', 'vote' => 'Yes' ]),
            new Vote([ 'voter' => 'Coun2', 'vote' => 'No' ]),
            new Vote([ 'voter' => 'Coun3', 'vote' => 'Yes' ])
        ]);
        $meeting = new Meeting([ 'date' => '2015-10-20' ]);

        // This theoretical item has many motions that are all unanimous
        $hasManyUnanimousMotions =
            (new AgendaItem([ 'title' => "LRT Funding" ]))
                ->setRelation('motions', $unanimousMotions)
                ->setRelation('meeting', $meeting);

        $hasOneDissentingMotion =
            (new AgendaItem([ 'title' => "Art gallery" ]))
                ->setRelation('motions', new Collection([
                    (new Motion())->setRelation('votes', $dissentingVotes)
                ]))
                ->setRelation('meeting', $meeting);

        $isUnanimousBylaw =
            (new AgendaItem([ 'title' => "Bylaw 12345 - A bylaw" ]))
                ->setRelation('motions', $unanimousMotions)
                ->setRelation('meeting', $meeting);

        $items = new Collection([
            (new AgendaItem([ 'title' => 'Private Reports' ]))->setRelation('motions', $unanimousMotions),
            (new AgendaItem([ 'title' => 'Adoption of Minutes' ]))->setRelation('motions', $unanimousMotions),
            $hasManyUnanimousMotions,
            $hasOneDissentingMotion,
            $isUnanimousBylaw
        ]);

        $latestMeetingItems = $ranker->forLatestMeeting($items);

        $this->assertInstanceOf(Collection::class, $latestMeetingItems);
        $this->assertEquals(3, $latestMeetingItems->count());

        // The items should be ordered dissenting -> bylaw -> unanimous
        // The Private Reports and Adoption of Minutes items will be excluded, as those items are uninteresting
        $this->assertEquals($hasOneDissentingMotion, $latestMeetingItems->get(0));
        $this->assertEquals($isUnanimousBylaw, $latestMeetingItems->get(1));
        $this->assertEquals($hasManyUnanimousMotions, $latestMeetingItems->get(2));
    }

}
