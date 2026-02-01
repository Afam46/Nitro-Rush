<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RaceSeeder extends Seeder
{
    public function run(): void
    {
        // Отключить проверку внешних ключей
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Очистить таблицу
        DB::table('races')->truncate();
        
        // Включить проверку обратно
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $races = [
            [
                'id' => 1,
                'name' => 'Заброшенное Шоссе',
                'price' => 1,
                'img' => '/storage/img/abandoned_highway.png',
                'img_game' => '/storage/img/road_abandoned_highway.png',
                'prize' => 5,
                'min_lvl' => 1,
                'dirt' => 0,
            ],
            [
                'id' => 2,
                'name' => 'Сосновый Лес',
                'price' => 2,
                'img' => '/storage/img/pine_forest.png',
                'img_game' => '/storage/img/road_pine_forest.png',
                'prize' => 10,
                'min_lvl' => 1,
                'dirt' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Дикий Запад',
                'price' => 3,
                'img' => '/storage/img/wild_west.png',
                'img_game' => '/storage/img/road_wild_west.png',
                'prize' => 20,
                'min_lvl' => 1,
                'dirt' => 0,
            ],
        ];

        foreach ($races as $race) {
            DB::table('races')->insert($race);
        }

        $this->command->info('Таблица races заполнена тестовыми данными!');
    }
}