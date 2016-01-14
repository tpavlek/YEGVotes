<?php


class AdministratorSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        \DB::table('administrators')->delete();

        \DB::table('administrators')->insert([
            'id' => 1,
            'username' => 'admin'
        ]);
    }

}
