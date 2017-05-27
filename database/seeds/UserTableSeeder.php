<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time_now = time();
        DB::table('users')->insert([
            'username' => 'root',
            'nickname' => '超级管理员大爷',
            'img' => '',
            'email' => 'root@enkay.com',
            'password' => bcrypt('admin'),
            'role_id' => 1,
            'status' => 1,
            'created_at' => $time_now,
            'updated_at' => $time_now
        ]);
    }
}
