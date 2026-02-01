<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RaceObjectsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('race_objects')->truncate();

        $objects = [
            [
                'img' => '/storage/img/pine1.png',
                'img_size' => 100,
                'size' => 50,
                'z_index' => 100,
                'sliding' => 0,
                'race_id' => 2,
            ],
            [
                'img' => '/storage/img/pine2.png',
                'img_size' => 100,
                'size' => 50,
                'z_index' => 100,
                'sliding' => 0,
                'race_id' => 2,
            ],
            [
                'img' => '/storage/img/bones.png',
                'img_size' => 25,
                'size' => 50,
                'z_index' => 5,
                'sliding' => 1,
                'race_id' => 3,
            ],
            [
                'img' => '/storage/img/cactus.png',
                'img_size' => 50,
                'size' => 50,
                'z_index' => 5,
                'sliding' => 1,
                'race_id' => 3,
            ],
            [
                'img' => '/storage/img/van.png',
                'img_size' => 100,
                'size' => 100,
                'z_index' => 100,
                'sliding' => 0,
                'race_id' => 3,
            ],
        ];

        foreach ($objects as $object) {
            DB::table('race_objects')->insert($object);
        }

        $this->command->info('Таблица race_objects заполнена тестовыми данными!');
    }
}