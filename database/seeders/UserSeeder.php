<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ['nama' => 'admin', 'email' => 'atmin@gmail.com', 'password' => bcrypt('123456')]
        ];
        DB::table('petugas')->upsert($data, ['email'], ['nama', 'password']);
    }
}
