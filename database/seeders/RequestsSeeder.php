<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RequestsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $userIds = range(1, 50); 
        for ($i = 0; $i < 5; $i++) {
            $userId = $faker->randomElement($userIds);
            $receiverId = $faker->randomElement(array_diff($userIds, [$userId]));

            DB::table('requests')->insert([
                'user_id' => $userId,
                'receiver_id' => $receiverId,
                'request_type' => 'connect',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
