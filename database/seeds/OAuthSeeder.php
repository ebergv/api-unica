<?php

use Illuminate\Database\Seeder;

class OAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::connection('mysql')->table("oauth_clients")->insert([
            'id'                    => '0263ee2c6a31fcaaeb5a061bbaef8e5c', // md5(#@pro2100pro#@)
            'secret'                => '118c3eec0235622188490b63b7d073d0', // md5(#@pro3500pro#@)
            "name"                  => 'EnrolmentPro',
            "created_at"            => $now,
            "updated_at"            => $now,
        ]);
    }
}
