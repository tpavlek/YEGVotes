<?php

namespace Depotwarehouse\YEGVotes\Tests\Model;

use App\Model\Motion;
use App\Model\PublicHearingSpeakerParser;

class PublicHearingSpeakerParserTest extends \TestCase
{

    /**
     * @test
     */
    public function it_can_match_call_for_persons_to_speak()
    {
        $text = "Mayor D. Iveson explained the public hearing process.

S. Kaffo, Office of the City Clerk, asked whether there were any persons present to speak to the following bylaws:

Bylaw 17830
In favour: N. Kilmartin, Kennedy Create (to answer questions only).

Bylaw 17834
In favour: S. Cole, Stantec Consulting Ltd. (to answer questions only).

Bylaw 17835
There were no persons present to speak to the passing of Bylaw 17835.

Bylaw 17837
In favour: C. Nicholas, MLC Land; and S. Cole, Stantec Consulting Ltd. (to answer questions only).

Bylaw 17839
In favour: R. Dauk, Rohit Group (to answer questions only).

Bylaw 17840
In favour: B. Dibben, IBI Group (to answer questions only).

Bylaw 17845
In favour: R. Feniak, Qualico Communities (to answer questions only).


Bylaws 17828 and 17829
There were no persons present to the passing of Bylaws 17828 and 17829.

Bylaw 17836
In favour: K. Smyth, Costco Wholesale Canada Ltd.  
K. Cantor, Primavera (to answer questions only).

Opposed: I. Martinez, Alberta Liquor Store Association; 
D. Owens, Sherbrooke Liquor; S. Baisley, Abbottsfield Project Limited Partnership; R. Noce; Alberta Liquor Store Association; M. Burgess; and A. Koziak, Chateau Louis Liquor Store.";

        $speakers = (new PublicHearingSpeakerParser($text))->parse();

        $this->assertEquals([
            'N. Kilmartin, Kennedy Create (to answer questions only)',
            'S. Cole, Stantec Consulting Ltd. (to answer questions only)',
            'C. Nicholas, MLC Land',
            'S. Cole, Stantec Consulting Ltd. (to answer questions only)',
            'R. Dauk, Rohit Group (to answer questions only)',
            'B. Dibben, IBI Group (to answer questions only)',
            'R. Feniak, Qualico Communities (to answer questions only)',
            'K. Smyth, Costco Wholesale Canada Ltd.',
            'K. Cantor, Primavera (to answer questions only)',
            'I. Martinez, Alberta Liquor Store Association',
            'D. Owens, Sherbrooke Liquor',
            'S. Baisley, Abbottsfield Project Limited Partnership',
            'R. Noce',
            'Alberta Liquor Store Association',
            'M. Burgess',
            'A. Koziak, Chateau Louis Liquor Store'
        ], $speakers);
    }

    /**
     * @test
     */
    public function it_does_not_include_the_clerk()
    {
        $motion = Motion::find('d875cc13-1a30-4190-865f-ece3fe4c0496');
    }

}
