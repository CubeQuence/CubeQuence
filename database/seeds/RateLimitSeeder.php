<?php

use CQ\DB\Seeder;

class RatelimitSeeder extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Seeder::faker();
        $data = [];

        for ($i = 0; $i < 5; ++$i) {
            $data[] = [
                'fingerprint' => $faker->sha1,
                'counter' => $faker->numberBetween(0, 100),
                'reset_time' => time(),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->table('cq_ratelimit')->insert($data)->saveData();
    }
}
