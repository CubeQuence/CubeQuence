<?php

declare(strict_types=1);

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
    public function run(): void
    {
        $faker = self::faker();
        $data = [];

        for ($i = 0; $i < 5; ++$i) {
            $data[] = [
                'key' => $faker->sha256() . ':60:26971784',
                'current' => $faker->numberBetween(0, 100),
                'reset_at' => time(),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->table('cq_ratelimit')->insert($data)->saveData();
    }
}
