<?php

namespace Depotwarehouse\YEGVotes\Tests\Model;


use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Depotwarehouse\YEGVotes\Model\Meeting;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeetingTest extends \TestCase
{

    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_can_parse_speakers_from_multi_motion_public_hearing()
    {
        $meeting = Meeting::create([ 'id' => 86942, 'meeting_type' => Meeting::TYPE_PUBLIC_HEARING ]);

        $agenda_item = AgendaItem::create([ 'id' => 892624, 'title' => 'Call for Persons to Speak', 'meeting_id' => $meeting->id ]);

        $agenda_item->addMotion("Mayor D. Iveson explained the public hearing process.

I. MacLean, Office of the City Clerk, asked whether there were any persons present to speak to the following bylaws:

Bylaw 17724
In favour:  T. McCargar, City of Edmonton (to answer questions only).

Bylaw 17712
In favour: K. Ng, Task Management Corp. (to answer questions only).

Bylaws 17714, 17715 and 17716
In favour: G. MacKenzie, Greg Mackenzie & Associates Consulting Ltd.; and R. Watkins and L. Semeniuk, G3 Development Services (to answer questions only).

Bylaw 17726
In favour: C. Dulaba, Callidus Development (to answer questions only).

Bylaw 17709
In favour: B. Dibben, IBI Group; and K. Davis, Melcor Development (to answer questions only).

Bylaw 17705
In favour: Y. Lew, Stantec Consulting Ltd. (to answer questions only).

Bylaws 17706 and 17707
In favour: T. Young, Stantec Consulting Ltd.; and 
J. Marchese, United Communities (to answer questions only).

Bylaw 17708
There were no persons present to speak to the passing of Bylaw 17708.

Bylaw 17640
There were no persons present to speak to the passing of Bylaw 17640.

Bylaw 17711
In favour: S. Wahab (to answer questions only).

Opposed: T. McGrandle.

Bylaw 17720
In favour: B. Ross, Qualico Commercial (to answer questions only).

Bylaw 17725
In favour: R. Wady (to answer questions only).

Bylaw 17727
In favour: S. Kamp, Belgravia Community League.");

        $agenda_item = AgendaItem::create([ 'id' => 892625, 'title' => 'Call for Persons to Speak', 'meeting_id' => $meeting->id ]);

        $agenda_item->addMotion("Mayor D. Iveson explained the public hearing process.

I. MacLean, Office of the City Clerk, asked whether there were any persons present to speak to the following bylaws:

Bylaws 17735 and 17736
In favour:  N. McDonald, Stantec Consulting Ltd.; J. Rumer, Mattamy Homes; C. Davis, Walton Development and Management L.P.; and M. Gourley, Sunwapta Holdings Corp. (to answer questions only)

Bylaws 17696 and 17697
In favour: N. Kilmartin and B. Kennedy, Kennedy Create.  
J. Murphy, Ogilvie Law (to answer questions only).

Opposed: A. M. Lizaire-Szostak; C. Nissen; C. Richmond, Sierra Club Canada - Edmonton Region; D. Stein Hasinoff, H. Namesechi, J. Shelly, M. E. Haggarty, L. Redfern, 
V. Desa, C. Greir, J. Calvert, W. Kelly, J. MacGillivrary, 
G. Milne, B. Koenig, C. Pun, M. MacGillivray, R. Ponech, 
D. Hasinoff, S. McNaughton, on behalf of H. Herchen and C. Marple and W. Gupta, Brander Gardens Rezoning Action Committee; and W. Kaminski.");


        $speakers = $meeting->speakers();

        dd($speakers);
        $this->assertContains('T. McGrandle', $speakers);
        $this->assertContains('T. Young, Stantec Consulting Ltd.', $speakers);
        $this->assertContains('A. M. Lizaire-Szostak', $speakers);
        $this->assertContains('S. McNaughton, on behalf of H. Herchen and C. Marple and W. Gupta, Brander Gardens Rezoning Action Committee', $speakers);
    }

}
