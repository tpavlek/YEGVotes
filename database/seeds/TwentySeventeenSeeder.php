<?php

use Depotwarehouse\YEGVotes\Model\Election\Candidate;

class TwentySeventeenSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        Candidate::query()->where('election_id', '=', '2017')->delete();

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Robert',
            'last_name' => 'Agostinis',
            'twitter' => 'ragostinis',
            'facebook' => 'RobAgostinis',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '9',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Jesse',
            'last_name' => 'Allen',
            'twitter' => 'jdallen76',
            'facebook' => 'jesseallenforward9',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '9',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Felix',
            'last_name' => 'Amenaghawon',
            'twitter' => '',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Kris',
            'last_name' => 'Andreychuk',
            'twitter' => 'KrisAndreychuk',
            'facebook' => '',
            'website' => 'https://voteandreychuk.ca/',
            'email' => 'info@voteandreychuk.com',
            'phone' => '780-249-6119',
            'ward' => '7',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Moe',
            'last_name' => 'Banga',
            'twitter' => 'MoeBangaWard12',
            'facebook' => 'moebangaforward12',
            'website' => 'http://www.moebanga.ca/',
            'email' => '',
            'phone' => '',
            'ward' => '12',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Rob',
            'last_name' => 'Bernshaw',
            'twitter' => 'robbernshaw',
            'facebook' => '',
            'website' => '',
            'email' => 'Info@robbernshaw.com',
            'phone' => '',
            'ward' => '3',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Taz',
            'last_name' => 'Bouchier',
            'twitter' => 'tazbouchier',
            'facebook' => '',
            'website' => 'http://tazbouchier.yolasite.com/',
            'email' => 'windspirit@live.ca',
            'phone' => '',
            'ward' => '6',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Nafisa',
            'last_name' => 'Bowen',
            'twitter' => 'nafisabowen',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Brandy',
            'last_name' => 'Burdeniuk',
            'twitter' => 'votebrandy',
            'facebook' => 'votebrandy',
            'website' => 'www.votebrandy.ca',
            'email' => 'team@votebrandy.ca',
            'phone' => '780-719-1629',
            'ward' => '11',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Timothy',
            'last_name' => 'Cartmell',
            'twitter' => '',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '9',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Rocco',
            'last_name' => 'Caterina',
            'twitter' => '',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '4',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Tony',
            'last_name' => 'Caterina',
            'twitter' => 'tony_caterina',
            'facebook' => 'tony.caterina.5',
            'website' => 'http://www.tonycaterina.ca/',
            'email' => '',
            'phone' => '',
            'ward' => '7',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Justin',
            'last_name' => 'Draper',
            'twitter' => 'JustinDraperYEG',
            'facebook' => 'Justin-Draper-Candidate-for-City-Council-Ward-4-304497176598170',
            'website' => 'https://www.electjustindraper.com/',
            'email' => 'Contact@ElectJustinDraper.com',
            'phone' => '780-270-7276',
            'ward' => '4',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Shafi Unsar',
            'last_name' => 'Chaudhary',
            'twitter' => '',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Jon',
            'last_name' => 'Dziadyk',
            'twitter' => 'JonDziadyk',
            'facebook' => 'EdmontonElection',
            'website' => 'http://www.jondziadyk.com',
            'email' => 'Jon@JonDziadyk.com',
            'phone' => '',
            'ward' => '3',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Bev',
            'last_name' => 'Esslinger',
            'twitter' => 'bevesslinger',
            'facebook' => 'esslinger.bev',
            'website' => 'http://bevesslinger.ca/',
            'email' => '',
            'phone' => '',
            'ward' => '2',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Michael',
            'last_name' => 'Ganly',
            'twitter' => '',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Vinu',
            'last_name' => 'George',
            'twitter' => '',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Beatrice',
            'last_name' => 'Ghettuba',
            'twitter' => '',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '4',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Sam',
            'last_name' => 'Hachem',
            'twitter' => 'samHhachem',
            'facebook' => '',
            'website' => 'http://votesamhachem.com/',
            'email' => '',
            'phone' => '',
            'ward' => '4',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Sarah',
            'last_name' => 'Hamilton',
            'twitter' => 'sjlhamilton',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Ali',
            'last_name' => 'Haymour',
            'twitter' => 'alihaymour',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Sam',
            'last_name' => 'Haymour',
            'twitter' => 'hassan_haymour',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '3',
        ]);



        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Ben',
            'last_name' => 'Henderson',
            'twitter' => 'ben_hen',
            'facebook' => 'BenHenderson8/',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '8',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Hakin',
            'last_name' => 'Isse',
            'twitter' => 'hakinisse',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '3',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Don',
            'last_name' => 'Iveson',
            'twitter' => 'doniveson',
            'facebook' => 'doniveson/',
            'website' => 'http://doniveson.ca/',
            'email' => '',
            'phone' => '',
            'ward' => 'mayor',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Miranda',
            'last_name' => 'Jimmy',
            'twitter' => 'ElectMirandaYEG',
            'facebook' => 'MirandaJimmyWard5',
            'website' => 'http://mirandajimmy.com/',
            'email' => '',
            'phone' => '',
            'ward' => '5',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Matthew',
            'last_name' => 'Kleywegt',
            'twitter' => '',
            'facebook' => '',
            'website' => 'https://mattkleywegt.ca/',
            'email' => '',
            'phone' => '',
            'ward' => '7',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Andrew',
            'last_name' => 'Knack',
            'twitter' => 'AndrewKnack',
            'facebook' => 'andrew.knack.3',
            'website' => 'http://www.andrewknack.com/',
            'email' => '',
            'phone' => '',
            'ward' => '1',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'James',
            'last_name' => 'Kosowan',
            'twitter' => '',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Charles',
            'last_name' => 'Laing',
            'twitter' => '',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => 'mayor',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Dave',
            'last_name' => 'Loken',
            'twitter' => 'daveloken',
            'facebook' => 'DaveLokenYEG',
            'website' => 'http://daveloken.com/',
            'email' => '',
            'phone' => '',
            'ward' => '3',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Scott',
            'last_name' => 'McKeen',
            'twitter' => 'Scott_McKeen',
            'facebook' => 'Scott-McKeen-142292965967186/',
            'website' => 'http://www.scottmckeen.ca/',
            'email' => '',
            'phone' => '',
            'ward' => '6',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Fahad',
            'last_name' => 'Mughal',
            'twitter' => '',
            'facebook' => '',
            'website' => 'http://fahadmughal.ca/',
            'email' => '',
            'phone' => '',
            'ward' => '10',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Dawn',
            'last_name' => 'Newton',
            'twitter' => 'dawn_d_newton',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Mike',
            'last_name' => 'Nickel',
            'twitter' => 'Clr_MikeNickel',
            'facebook' => 'mikenickelyeg',
            'website' => 'http://www.mikenickel.ca/',
            'email' => '',
            'phone' => '',
            'ward' => '11',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Michael',
            'last_name' => 'Oshry',
            'twitter' => 'michaeloshry',
            'facebook' => 'OshryEdmonton',
            'website' => 'http://michaeloshry.com/',
            'email' => '',
            'phone' => '',
            'ward' => '5',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Payman',
            'last_name' => 'Parseyan',
            'twitter' => 'pparseyan',
            'facebook' => 'pparseyan',
            'website' => 'http://www.parseyan.ca/',
            'email' => 'paymanparseyan@hotmail.com',
            'phone' => '',
            'ward' => '9',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Troy',
            'last_name' => 'Pavlek',
            'twitter' => 'troypavlek',
            'facebook' => 'TroyPavlekWard11/',
            'website' => 'https://tpavlek.me/',
            'email' => 'troy@tpavlek.me',
            'phone' => '780-200-3304',
            'ward' => '11',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Svetlana',
            'last_name' => 'Pavlenko',
            'twitter' => '',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Tish',
            'last_name' => 'Prouse',
            'twitter' => '',
            'facebook' => 'Tish-Prouse-Ward-6-Edmonton-City-Council-Candidate-239676779839005',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '6',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Sarmad',
            'last_name' => 'Rasheed',
            'twitter' => 'sarmadyeg',
            'facebook' => 'SarmadRasheedYEG',
            'website' => 'http://www.sarmadrasheed.ca/',
            'email' => 'sarmad@sarmadrasheed.ca',
            'phone' => '780-707-6878',
            'ward' => '3',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Keren',
            'last_name' => 'Tang',
            'twitter' => 'kerentangyeg',
            'facebook' => 'kerentangyeg',
            'website' => 'http://www.kerentang.ca/',
            'email' => '',
            'phone' => '',
            'ward' => '11',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Shelley',
            'last_name' => 'Tupper',
            'twitter' => 'tupper4ward2',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '2',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Tricia',
            'last_name' => 'Velthuizen',
            'twitter' => 'vote_tricia',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Michael',
            'last_name' => 'Walters',
            'twitter' => 'waltersyeg',
            'facebook' => 'michaelwaltersedmonton',
            'website' => 'http://www.michaelwalters.ca/',
            'email' => '',
            'phone' => '',
            'ward' => '10',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Mimi',
            'last_name' => 'Williams',
            'twitter' => 'ElectMimiWard7',
            'facebook' => 'ElectMimiWard7',
            'website' => 'http://www.mimiwilliams.ca/',
            'email' => 'mimi@mimiwilliams.ca',
            'phone' => '780-479-8868',
            'ward' => '7',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Heather',
            'last_name' => 'Workman',
            'twitter' => 'HeatherWorkman_',
            'facebook' => 'heatherworkman4council',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '8',
        ]);

        Candidate::create([
            'election_id' => '2017',
            'first_name' => 'Matty Tyler',
            'last_name' => 'Wray',
            'twitter' => '',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);

        /*
        Candidate::create([
            'election_id' => '2017',
            'first_name' => '',
            'last_name' => '',
            'twitter' => '',
            'facebook' => '',
            'website' => '',
            'email' => '',
            'phone' => '',
            'ward' => '',
        ]);*/
    }


}
