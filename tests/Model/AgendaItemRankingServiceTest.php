<?php

namespace Depotwarehouse\YEGVotes\Tests\Model;

use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Depotwarehouse\YEGVotes\Model\AgendaItemRankingService;

class AgendaItemRankingServiceTest extends \TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
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
}
