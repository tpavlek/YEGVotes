<?php


class ElectionSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        \DB::table('elections')->delete();

        \Depotwarehouse\YEGVotes\Model\Election\Election::create([ 'id' => 'ward12', 'name' => 'Ward 12 By-Election' ]);
    }

}
