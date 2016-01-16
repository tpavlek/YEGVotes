<?php

use Depotwarehouse\YEGVotes\Model\Election\Candidate;

class WardTwelveSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        \DB::table('election_candidates')->delete();

        Candidate::create([
            'first_name' => 'Shani',
            'last_name' => "Ahmad",
            'election_id' => 'ward12',
        ]);

        Candidate::create([
            'first_name' => 'Damien',
            'last_name' => 'Austin',
            'election_id' => 'ward12',
        ]);

        Candidate::create([
            'first_name' => 'Jason',
            'last_name' => 'Bale',
            'election_id' => 'ward12',
        ]);
        Candidate::create([
            'first_name' => 'Mohinder (Moe)',
            'last_name' => 'Banga',
            'election_id' => 'ward12',
        ]);
        Candidate::create([
            'first_name' => 'Danisha',
            'last_name' => 'Bhaloo',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/dbhaloo.jpg',
            'twitter' => 'danishabhaloo',
            'facebook' => 'danishabhalooedm',
            'website' => 'http://www.bhaloo.ca/',

        ]);
        Candidate::create([
            'first_name' => 'Viorel',
            'last_name' => 'Bujor',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/vbujor.jpg',
            'facebook' => 'Viorel-BUJOR-your-choice-for-Ward-12-1551259218497654'
        ]);

        Candidate::create([
            'first_name' => 'Mike',
            'last_name' => 'Butler',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/mbutler.jpg',
            'twitter' => 'vote4mikebutler',
            'facebook' => 'MikeButlerLiberal',
            'website' => 'http://www.votebutler.com/',
            'email' => 'mikebutler888@gmail.com',


        ]);

        Candidate::create([
            'first_name' => 'Nick',
            'last_name' => 'Chamchuk',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/nchamchuk.jpg',
            'twitter' => 'NickChamchuk',
            'facebook' => 'NickChamchuk',
            'website' => 'http://www.chamchukn.ca/'
        ]);

        Candidate::create([
            'first_name' => 'Irfan',
            'last_name' => 'Chaudhry',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/ichaudhry.jpg',
            'twitter' => 'irfanward12',
            'facebook' => 'IrfanWard12',
            'website' => 'http://www.irfanward12.com/',
            'email' => 'campaign@irfanward12.com'
        ]);

        Candidate::create([
            'first_name' => 'Jagdeep Singh',
            'last_name' => 'Gill',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/jgill.png',
            'twitter' => 'JagGill12',
            'website' => 'http://www.jaggill12.com/',
            'email' => 'Jag@JagGill12.com',
            'phone' => '780-904-3240'
        ]);

        Candidate::create([
            'first_name' => 'Brian',
            'last_name' => 'Henderson',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/bhenderson.png',
            'website' => 'http://www.hendersonward12.ca/',
            'email' => 'bhendersonward12@gmail.com',
            'phone' => '587-501-7112'
        ]);

        Candidate::create([
            'first_name' => 'Lincoln',
            'last_name' => 'Ho',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/lho.jpg',
            'twitter' => 'yegventures',
            'facebook' => 'VoteLincolnHo',
            'website' => 'http://www.lincolnho.ca/',
            'email' => 'voteho@telus.net',
            'phone' => '587-710-3096'
        ]);

        Candidate::create([
            'first_name' => 'Sam',
            'last_name' => 'Jhajj',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/sjhajj.png',
            'twitter' => 'ssjhajj',
            'facebook' => 'samjhajj12',
            'website' => 'http://www.samjhajj.com/',
            'email' => 'info@samjhajj.com',
            'phone' => '780-267-0050'
        ]);

        \Depotwarehouse\YEGVotes\Model\Election\Candidate::create([
            'first_name' => 'Dan',
            'last_name' => 'Johnstone',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/djohnstone.png',
            'twitter' => 'thedanjohnstone',
            'facebook' => 'electdanjohnstone',
            'website' => 'http://danjohnstone.com/',
            'email' => "info@danjohnstone.com",
            'phone' => "780-934-4144",
        ]);

        Candidate::create([
            'first_name' => 'Nav',
            'last_name' => 'Kaur',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/nkaur.jpg',
            'twitter' => 'navkaurward12',
            'facebook' => 'navkaurward12',
            'website' => 'http://www.votenav.ca/',
        ]);

        Candidate::create([
            'first_name' => 'Balraj Singh',
            'last_name' => 'Manhas',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/bmanhas.jpg',
            'facebook' => 'profile.php?id=100008573861200',
            'twitter' => 'balrajmanhas'
        ]);

        Candidate::create([
            'first_name' => 'Ralph',
            'last_name' => 'Mclean',
            'election_id' => 'ward12',
        ]);

        Candidate::create([
            'first_name' => 'Kyle',
            'last_name' => 'Mcleod',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/kmcleod.jpeg',
            'twitter' => 'yegmcleod'
        ]);

        Candidate::create([
            'first_name' => 'Rakesh',
            'last_name' => 'Patel',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/rpatel.png',
            'website' => 'http://rakeshpatel.ca/'
        ]);

        Candidate::create([
            'first_name' => 'Field',
            'last_name' => 'Pieterse',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/fpieterse.jpg',
            'facebook' => 'Field-for-12-606032752868811/',
            'twitter' => 'Fieldfor12',
            'website' => 'http://fieldfor12.ca/',
        ]);

        Candidate::create([
            'first_name' => 'Arundeep Singh',
            'last_name' => 'Sandhu',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/asandhu.jpg',
            'facebook' => 'ArundeepWard12/',
            'twitter' => 'arundeepyeg',
            'website' => 'http://www.arundeep.ca/',
            'phone' => '780-306-4444'
        ]);

        Candidate::create([
            'first_name' => 'Nirpal',
            'last_name' => 'Sekhon',
            'election_id' => 'ward12',
        ]);

        Candidate::create([
            'first_name' => 'Yash Pal',
            'last_name' => 'Sharma',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/ysharma.jpg',
            'facebook' => 'YASH-Sharma-Candidate-for-Ward-12-1005488999508840',
            'twitter' => 'ElectYashSharma',
            'website' => 'http://www.electyashsharma.ca/'
        ]);

        Candidate::create([
            'first_name' => 'Jagat Singh',
            'last_name' => 'Sheoran',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/jsheoran.png',
            'facebook' => 'Jagat-Singh-Sheoran-Candidate-for-Ward-12-1513118192319595'
        ]);

        Candidate::create([
            'first_name' => 'Neil',
            'last_name' => 'Singh',
            'election_id' => 'ward12',

        ]);

        Candidate::create([
            'first_name' => 'Nicole',
            'last_name' => 'Szymanowka',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/nszymanowka.jpg',
            'twitter' => 'NicoleSWard12',
        ]);

        Candidate::create([
            'first_name' => 'Laura',
            'last_name' => 'Thibert',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/lthibert.jpg',
            'twitter' => 'laurathibert',
            'facebook' => 'laura.thibert.73',
            'website' => 'http://www.laurathibert.com/',
            'email' => 'laurathibert12@gmail.com',
            'phone' => '780-231-6312'
        ]);

        Candidate::create([
            'first_name' => 'Steve',
            'last_name' => 'Toor',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/stoor.jpg',
            'facebook' => 'Steve-CP-Toor-Candidate-For-Ward-12-City-Councillor-1156287314399059',
            'twitter' => 'steve_cp1',
            'website' => 'http://www.steve4ward12.com/',
            'email' => 'steve4ward12@shaw.ca',
            'phone' => '780-885-1970',

        ]);

        Candidate::create([
            'first_name' => 'Preet Pal',
            'last_name' => 'Toor',
            'election_id' => 'ward12',

            'img_url' => '/img/election/ward12/ptoor.jpg',
            'twitter' => 'PreetToor12',
            'facebook' => 'PreetWard12',
            'website' => 'http://preetward12.org/',
        ]);
    }

}
