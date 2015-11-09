<?php

namespace Depotwarehouse\YEGVotes\Tests\Model;

use Depotwarehouse\YEGVotes\Model\Motion;

class MotionTest extends \TestCase
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
     * @group integration
     */
    public function it_displays_correct_motion_indicator_string_for_particular_motion()
    {
        $motion = Motion::find("61652abf-5cdd-4f5a-85fe-f66a25c0ece6");

        $this->assertEquals("Unanimous", $motion->getIndicatorString());
    }

}
