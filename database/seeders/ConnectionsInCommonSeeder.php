<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConnectionsInCommonSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            DB::table('connections')->insert([
                'user_id' => $i,
                'connection_id' => $i % 10 + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
