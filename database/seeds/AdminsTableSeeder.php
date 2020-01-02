<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \Illuminate\Support\Facades\DB::table('admins')->insert([
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_DEFAULT, ['cost' => 12]),
            'email' => '2677060927@qq.com',
            'tel' => '18080999999',
            'status' => 1
        ]);
    }
}
