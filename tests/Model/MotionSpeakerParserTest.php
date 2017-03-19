<?php

namespace Depotwarehouse\YEGVotes\Tests\Model;

use Depotwarehouse\YEGVotes\Model\Motion;
use Depotwarehouse\YEGVotes\Model\MotionSpeakerParser;

class SpeakerParserTest extends \TestCase
{

    /**
     * @test
     */
    public function it_works_with_abbreviated_names_in_paragraphs()
    {
        $text = 'That the Committee hear from the following speakers  in apensl when appropriate: 7.1&nbsp; Elimination of Door to Door Delivery by Canada Post - Effects on the City of Edmonton (B. Henderson/A. Sohi)<BR><BR> <P>B. Ray  Canadian Union of Postal Workers</P> <P>S. Cowtan  Canadian Union of Postal Workers</P>';

        $this->assertEquals([
            'B. Ray  Canadian Union of Postal Workers',
            'S. Cowtan  Canadian Union of Postal Workers',
        ], (new MotionSpeakerParser($text))->parse());


    }

    /**
     * @test
     */
    public function it_works_with_numbered_lists()
    {
        $text = 'That City Council hear from the following speakers: <BR><BR> <P>6.6 Status of Provincial Support on Family Violence Prevention<BR><BR>1. J. Executive Director of Edmonton Women’s Shelters Ltd.<BR>2. P. Garrett  Executive Director of Wings of Providence</P>';

        $this->assertEquals([
            'J. Executive Director of Edmonton Women’s Shelters Ltd.',
            'P. Garrett  Executive Director of Wings of Providence',
        ], (new MotionSpeakerParser($text))->parse());
    }

    /**
     * @test
     */
    public function it_works_with_dashed_lists()
    {
        $text = 'That the Committee hear from the following speakers  in panels when appropriate:<BR><BR> <P>7.1&nbsp; Skyrattler Neighbourhood - First Place Program (M. Walters)</P> <P>-&nbsp; T. Battle  Skyrattler Neighbourhood Association</P> <P>-&nbsp; G. Redmond  Skyrattler Neighbourhood Association</P> <P>6.5&nbsp; Galleria Staging and Status Update</P> <P>8.2&nbsp; Galleria Update - Verbal Report - Private</P> <P>- C. G. Amrhein  Edmonton Downtown Academic&nbsp;&amp; Cultural Centre Foundation</P> <P>- J. Brown  Edmonton Downtown Academic&nbsp;&amp; Cultural Centre Foundation</P> <P>- I. Kipnes  Edmonton Downtown Academic&nbsp;&amp; Cultural Centre Foundation</P> <P>- D. Kipnes  Edmonton Downtown Academic&nbsp;&amp; Cultural Centre Foundation</P> <P>&nbsp;</P>';

        $this->assertEquals([
            "T. Battle  Skyrattler Neighbourhood Association",
            "G. Redmond  Skyrattler Neighbourhood Association",
            "C. G. Amrhein  Edmonton Downtown Academic & Cultural Centre Foundation",
            "J. Brown  Edmonton Downtown Academic & Cultural Centre Foundation",
            "I. Kipnes  Edmonton Downtown Academic & Cultural Centre Foundation",
            "D. Kipnes  Edmonton Downtown Academic & Cultural Centre Foundation",
        ], (new MotionSpeakerParser($text))->parse());
    }

    /**
     * @test
     */
    public function it_works_with_unordered_lists()
    {
        $text = 'That the Committee hear from the following speakers  in panels when appropriate:<BR><BR> <P><STRONG>6.3 Business Models  Stadium Options and Needs Assessment for Soccer<BR><BR>6.4 Clarke Field Artifical Turf Renewal</STRONG></P> <UL> <LI>T. Fath  FC Edmonton Soccer Club</LI> <LI>L. Rhodes  Edmonton Eskimo Football Club</LI> <LI>T. Enger  Football Alberta</LI> <LI>S. Morgan  Capital District Minor Football Association</LI> <LI>N. Smith  Metro Edmonton High School Athletic Association</LI> <LI>J. Wojcicki  Edmonton Wildcats Football Club</LI></UL> <P><STRONG>6.6 Update on the City\'s Use of Pesticides</STRONG></P> <UL> <LI>S. McCumsey</LI> <LI>R. Feroe</LI> <LI>I. Chapados</LI> <LI>G. Young</LI> <LI>K. Nelson</LI> <LI>K. Porlier  on behalf of A. Brailey</LI> <LI>L. McCumsey</LI> <LI>P. Wishart</LI> <LI>E. Beaudien  University of Alberta</LI> <LI>C. Richmond  Sierra Club Canada - Edmonton</LI></UL>';

        $this->assertEquals([
            'T. Fath  FC Edmonton Soccer Club',
            'L. Rhodes  Edmonton Eskimo Football Club',
            'T. Enger  Football Alberta',
            'S. Morgan  Capital District Minor Football Association',
            'N. Smith  Metro Edmonton High School Athletic Association',
            'J. Wojcicki  Edmonton Wildcats Football Club',
            'S. McCumsey',
            'R. Feroe',
            'I. Chapados',
            'G. Young',
            'K. Nelson',
            'K. Porlier  on behalf of A. Brailey',
            'L. McCumsey',
            'P. Wishart',
            'E. Beaudien  University of Alberta',
            'C. Richmond  Sierra Club Canada - Edmonton',
        ], (new MotionSpeakerParser($text))->parse());
    }

    /**
     * @test
     */
    public function it_can_parse_numbers_without_newlines()
    {
        $text = 'That City Council hear from the following speakers: 4.3 Blatchford Concept Plan Implementation Analysis - Project Business Case 1. M. Johnson  Royal Architectural Institute of Canada 2. G. Stoyke  Carbon&nbsp;Busters Inc.';

        $this->assertEquals([
            'M. Johnson  Royal Architectural Institute of Canada',
            'G. Stoyke  Carbon Busters Inc.'
        ], (new MotionSpeakerParser($text))->parse());

        $text = 'That the Special Executive Committee hear from the following speakers  in panels when appropriate: 3.1 West Rossdale Redevelopment 1. Lynn Parish  Rossdale Community League 2. Dwayne Good Striker  Sovereign Blackfoot Nation 3. Phillip Coutue  Metis 4. Sol Rolingher  Rossdale Canal Project 5. Terry O\'Riordan  Edmonton Heritage Council 6. Gerald Delorme  Edmonton Stragglers and Descendants 7. Michael Phair  Rossdale Regeneration Group';

        $this->assertEquals([
            'Lynn Parish  Rossdale Community League',
            'Dwayne Good Striker  Sovereign Blackfoot Nation',
            'Phillip Coutue  Metis',
            'Sol Rolingher  Rossdale Canal Project',
            "Terry O'Riordan  Edmonton Heritage Council",
            'Gerald Delorme  Edmonton Stragglers and Descendants',
            'Michael Phair  Rossdale Regeneration Group',
        ], (new MotionSpeakerParser($text))->parse());
    }

    /**
     * @test
     */
    public function it_can_match_a_single_line_without_numbers()
    {
        $text = 'That the Committee hear from the following speakers in panels when appropriate: 6.1 Age Friendly Edmonton Updates and Accomplishments S. Hallett  Edmonton Seniors Coordinating Council P. Faid  Edmonton Seniors Coordinating Council';

        $this->assertEquals([
            'S. Hallett  Edmonton Seniors Coordinating Council',
            'P. Faid  Edmonton Seniors Coordinating Council'
        ], (new MotionSpeakerParser($text))->parse());
    }

    /**
     * @test
     */
    public function it_can_match_with_font_styles_and_numbers()
    {
        $text = '<SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'>That the Committee hear from thh following speaks  in panels where appropriate:</SPAN><BR><BR> <P><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'><STRONG>6.1 City Interchange Needs</STRONG></SPAN></P> <P><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'>1.&nbsp; P. Godsmark  Cavcoe</SPAN><BR><BR><STRONG><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'>6.2<SPAN style=\'mso-tab-count: 2\'> 10</SPAN>6<SUP>th</SUP> Street Bike Route Winter/Spring Maintenance Pilot Project<?xml:namespace prefix = o ns = \'urn:schemas-microsoft-com:office:office\' /><o:p></o:p></SPAN></STRONG></P> <P></P> <P style=\'TEXT-ALIGN: justify; MARGIN: 6pt 0in\' class=sactime-head><STRONG><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'></SPAN></STRONG></P> <P style=\'TEXT-ALIGN: justify; MARGIN: 0in 0in 0pt; tab-stops: .5in\' class=saclist><STRONG><I style=\'mso-bidi-font-style: normal\'><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'>The following requests to speak were approved at the </SPAN></I></STRONG><B><I style=\'mso-bidi-font-style: normal\'><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'><BR><STRONG><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'>October 15  2014  Transportation Committee meeting. <o:p></o:p></SPAN></STRONG></SPAN></I></B></P> <P style=\'TEXT-ALIGN: justify; MARGIN: 6pt 0in\' class=sacitem-headnotbold><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'; mso-fareast-font-family: Arial\'>1.</SPAN><SPAN style=\'FONT-SIZE: 7pt; mso-fareast-font-family: Arial\'> </SPAN><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'>C. Chan  Edmonton Bicycle Commuters Society</SPAN></P> <P style=\'TEXT-ALIGN: justify; MARGIN: 6pt 0in\' class=sacitem-headnotbold><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'></SPAN></P> <P style=\'TEXT-ALIGN: justify; MARGIN: 6pt 0in\' class=sacitem-headnotbold><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'><STRONG>6.5 Update on Compressed Natural Gas for Buses</STRONG></SPAN></P> <P style=\'TEXT-ALIGN: justify; MARGIN: 6pt 0in\' class=sacitem-headnotbold><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'><STRONG>6.6 Natural Gas Buses and Westwood Garage - Westwood Transit Garage Replacement</STRONG></SPAN></P> <P style=\'TEXT-ALIGN: justify; MARGIN: 6pt 0in\' class=sacitem-headnotbold><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'>1. J. Engleder  NAIT</SPAN></P> <P style=\'TEXT-ALIGN: justify; MARGIN: 6pt 0in\' class=sacitem-headnotbold><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'>2. R. Morrow  River City Credit Union Ltd.</SPAN></P> <P style=\'TEXT-ALIGN: justify; MARGIN: 6pt 0in\' class=sacitem-headnotbold><SPAN style=\'FONT-FAMILY: \'Arial\' \'sans-serif\'\'>3. M. Tetterington  Amalgmated Transit Union</SPAN></P>';

        $this->assertEquals([
            'P. Godsmark  Cavcoe',
            'C. Chan  Edmonton Bicycle Commuters Society',
            'J. Engleder  NAIT',
            'R. Morrow  River City Credit Union Ltd.',
            'M. Tetterington  Amalgmated Transit Union'

        ], (new MotionSpeakerParser($text))->parse());
    }

    /**
     * @test
     */
    public function it_can_match_unordered_list_without_numbers()
    {
        $text = "That the Transportation Committee hear from the following speakers  in a panel where appropriate:<BR><BR> <P><STRONG>6.3&nbsp;&nbsp;&nbsp;&nbsp; 162 Avenue and 167 Avenue Rail Crossings - Whistle Cesssation Safety Review <BR></STRONG><STRONG>6.4.&nbsp;&nbsp;&nbsp; Roadway Rail Crossings - Crossing Inventory  Infrastructure Needs for&nbsp; Whistle cessation and Quitet Zones</STRONG></P> <UL> <LI>F. Jameson</LI></UL> <P><STRONG>6.9&nbsp;&nbsp; Installation of New Traffic Lights - Strategy to Inform and Engage Communities</STRONG></P> <UL> <LI>S. Sobon</LI></UL> <P><STRONG>7.2&nbsp;&nbsp; 127 Street between 118 Avenue and Yellowhead Trail Reconstrcution - Options for Related Traffiic Shortcutting (B. Esslinger)</STRONG></P> <UL> <LI>B. Rose-Drolet</LI></UL> <P style='PAGE-BREAK-AFTER: auto; MARGIN: 6pt 0in 6pt 1.75in; mso-pagination: lines-together' class=SACitem-headNotBold>&nbsp;</P> <P>&nbsp;</P>";

        $this->assertEquals([
            'F. Jameson',
            'S. Sobon',
            'B. Rose-Drolet',
        ], (new MotionSpeakerParser($text))->parse());
    }

    /**
     * @test
     */
    public function it_can_match_items_with_bullets()
    {
        $text = "That the Committee hear from the following speakers  in panels when appropriate:<BR><BR> <P>6.1&nbsp;&nbsp;Community Traffic Management Policy – Guiding Principles<BR>•&nbsp;S. Sobon  Ad hoc City Wide Group - Transportation<BR>•&nbsp;D. Densmore  Crestwood Community League<BR><BR>6.4&nbsp;&nbsp;LRT Right-of-Way Land Acquisition<BR>•&nbsp;C. Nicholas<BR>•&nbsp;J. Agrios  MLC group<BR>•&nbsp;B. Armstrong  Urban Development Institute  Edmonton Region</P> <P>6.5&nbsp;&nbsp;Warehouse Campus Neighbourhood Central Park&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <BR>•&nbsp;R. Noce  Miller Thomson LLP for Obam Properties Ltd.<BR>•&nbsp;B. Klassen  Obam Properties Ltd.<BR>•&nbsp;R. McCulloch<BR>•&nbsp;C. Richmond  Sierra Club Canada</P>";

        $this->assertEquals([
            'S. Sobon  Ad hoc City Wide Group - Transportation',
            'D. Densmore  Crestwood Community League',
            'C. Nicholas',
            'J. Agrios  MLC group',
            'B. Armstrong  Urban Development Institute  Edmonton Region',
            'R. Noce  Miller Thomson LLP for Obam Properties Ltd.',
            'B. Klassen  Obam Properties Ltd.',
            'R. McCulloch',
            'C. Richmond  Sierra Club Canada',
        ], (new MotionSpeakerParser($text))->parse());
    }

    /**
     * @test
     */
    public function it_can_match_unordered_list_with_full_name()
    {
        $text = "That the Committee hear from the following speakers  in panels when appropriate:<BR><BR> <P><STRONG>6.1&nbsp;Lewis Farms Recreation Centre – Program Statement and Recreation Facility Master Plan Updates</STRONG></P> <UL> <LI>&nbsp;Herb Flewwelling  Aquatic Council of Edmonton</LI> <LI>Chris Nelson  Aquatic Council of Edmonton</LI> <LI>Jennifer Parker  Aquatic Council of Edmonton</LI></UL> <P><STRONG>6.3&nbsp;Discussion with the Edmonton Federation of Community Leagues on Registering Community League</STRONG><BR></P> <UL> <LI>Allan Bolstad  Edmonton Federation of Community Leagues<BR></LI></UL>";

        $this->assertEquals([
            'Herb Flewwelling  Aquatic Council of Edmonton',
            'Chris Nelson  Aquatic Council of Edmonton',
            'Jennifer Parker  Aquatic Council of Edmonton',
            'Allan Bolstad  Edmonton Federation of Community Leagues'
        ], (new MotionSpeakerParser($text))->parse());
    }

    /**
     * @test
     */
    public function other_stuff()
    {
        $text = "That Community and Public Services Committee hear from the following speakers  in panels when appropriate: 6.2 Dogs in Open Spaces Pilot Program (Grand Trunk) 1. S. Fernando  Grand Trunk Dog Park Committee 2. K. Zahara  Grand Trunk Dog Park Committee 3. M. Ostrom 6.3 Lewis Farms Recreation Centre - Options and Costs for Lane Pool and Dive Towers 1. H. Flewwelling 6.4 Nuit Blanche Edmonton - Results&nbsp;1. T. Pidner  Nuit Blanche Edmonton Society 2. T. Janes  Nuit Blanche Edmonton Society 3. G. Latham  Nuit Blanche Edmonton Society 6.5. John Fry Sport Park Land Consolidation 1. E. Huculak  Alberta Tennis  <P>Action:</P> <P>Department:</P> <P></P>";

        $this->assertEquals([
            'S. Fernando  Grand Trunk Dog Park Committee',
            'K. Zahara  Grand Trunk Dog Park Committee',
            'M. Ostrom',
            'H. Flewwelling',
            'T. Pidner  Nuit Blanche Edmonton Society',
            'T. Janes  Nuit Blanche Edmonton Society',
            'G. Latham  Nuit Blanche Edmonton Society',
            'E. Huculak  Alberta Tennis',
        ], (new MotionSpeakerParser($text))->parse());
    }

}
