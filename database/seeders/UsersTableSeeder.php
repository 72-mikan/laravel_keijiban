<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('INSERT INTO users(user_id, name, mail, pass, permit) VALUES (111111, "guest", "mail", "guest", true)');
        DB::insert('INSERT INTO users(user_id, name, mail, pass, permit) VALUES (111111, "no_guest", "mail", "no_guest", false)');
    }
}
