<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoststableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = date("Y/m/d H:i:s", time());
        DB::insert('INSERT INTO posts(user_id, post_name, comment, pass, post_time) VALUES(1, "test", "これはtestです。", "test", "2019-03-23")');
    }
}
