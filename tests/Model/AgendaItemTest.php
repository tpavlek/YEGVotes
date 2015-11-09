<?php

namespace Depotwarehouse\YEGVotes\Tests\Model;

use Depotwarehouse\YEGVotes\Model\AgendaItem;

class AgendaItemTest extends \PHPUnit_Framework_TestCase
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
    public function it_can_represent_itself_as_a_string()
    {
        $agendaItem = new AgendaItem([ 'title' => 'Mock Item', 'other_field' => 'other_value' ]);

        $this->assertEquals("Mock Item", (string)$agendaItem);
    }


}
