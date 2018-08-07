<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::connection('mysql')->table("users")->insert([
            'name'              => 'Prominas',
            'email'             => 'prominas@prominas.com.br',
            'password'          => bcrypt('pro2100pro'),
            "remember_token"    => str_random(10),
            "created_at" => $now,
            "updated_at" => $now,
        ]);
    }
}
