<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Car;
use App\Models\Part;
use App\Models\Check_item;
use Illuminate\Support\Facades\Cache;

class UpdateShop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-shop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновление магаза';

    /**
     * Execute the console command.
     */
   
public function handle(){
    $this->clearPreviousData();
    $this->generateShopCars();
    $this->generateShopParts();

    $this->info('Магазин успешно обновлен на');
}

protected function clearPreviousData(){
    Cache::forget('shop:cars');
    Cache::forget('shop:parts');
    Check_item::truncate();
    Car::where('sale', 2)->delete();
    Part::where('sale', 2)->delete();
}

protected function generateShopCars(){
    $colors = [
        //Фиолетовый
        'filter: brightness(0) saturate(100%) invert(11%) sepia(85%) saturate(7452%) hue-rotate(263deg) brightness(69%) contrast(123%);',
        //Коричневый
        'filter: brightness(0) saturate(100%) invert(18%) sepia(85%) saturate(454%) hue-rotate(346deg) brightness(96%) contrast(86%);',
        //Зеленый
        'filter: brightness(0) saturate(100%) invert(30%) sepia(16%) saturate(2713%) hue-rotate(47deg) brightness(96%) contrast(97%);',
        //Желтый
        'filter: brightness(0) saturate(100%) invert(69%) sepia(84%) saturate(2581%) hue-rotate(19deg) brightness(101%) contrast(97%);',
        //Оранджевый
        'filter: brightness(0) saturate(100%) invert(44%) sepia(99%) saturate(562%) hue-rotate(358deg) brightness(98%) contrast(94%);',
        //Красный
        'filter: brightness(0) saturate(100%) invert(20%) sepia(100%) saturate(6760%) hue-rotate(348deg) brightness(66%) contrast(105%);',
        //Синий
        'filter: brightness(0) saturate(100%) invert(11%) sepia(86%) saturate(4231%) hue-rotate(241deg) brightness(82%) contrast(130%);',
        //Голубой
        'filter: brightness(0) saturate(100%) invert(30%) sepia(51%) saturate(5285%) hue-rotate(191deg) brightness(98%) contrast(101%);',
        //Океанический
        'filter: brightness(0) saturate(100%) invert(62%) sepia(14%) saturate(5201%) hue-rotate(109deg) brightness(95%) contrast(101%);',
        //Розовый
        'filter: brightness(0) saturate(100%) invert(24%) sepia(95%) saturate(2389%) hue-rotate(290deg) brightness(78%) contrast(137%);',
        //Красно-оранджевый
        'filter: brightness(0) saturate(100%) invert(22%) sepia(48%) saturate(3956%) hue-rotate(360deg) brightness(97%) contrast(107%);',
        //Малиновый
        'filter: brightness(0) saturate(100%) invert(11%) sepia(96%) saturate(4775%) hue-rotate(342deg) brightness(92%) contrast(97%);',
        //Желто-зеленый
        'filter: brightness(0) saturate(100%) invert(76%) sepia(17%) saturate(6736%) hue-rotate(31deg) brightness(101%) contrast(101%);',
        //Бежевый
        'filter: brightness(0) saturate(100%) invert(82%) sepia(2%) saturate(5005%) hue-rotate(307deg) brightness(87%) contrast(82%);',
        //Белый
        'filter: brightness(0) saturate(100%) invert(93%) sepia(98%) saturate(316%) hue-rotate(201deg) brightness(116%) contrast(84%);',
        //Серый
        'filter: brightness(0) saturate(100%) invert(47%) sepia(8%) saturate(8%) hue-rotate(344deg) brightness(97%) contrast(86%);',
    ];

    $names = ['Aurora','Desert Hawk','Neon Flash','Phantom Racer','Prism',
        'Stormrider','Thunderbolt','Vortex','Wildfire','Cyclop','Eclipse X',
        'Phoenix','Quantum','Shadow','Storm','Titanium','Nightshade',
        'Night Stalker', 'Lightning Strike', 'Avant Guard', 'Phantom Drive','Atlant'
    ];
    
    for ($i = 0; $i < 2; $i++) {
        $rare = rand(1, 3);
        $speed = rand(20, 80);
        $power = rand(20, 80);
        
        Car::create([
            'name' => $names[array_rand($names)],
            'speed' => $speed*1.4**($rare-1),
            'power' => $power*1.4**($rare-1),
            'color' => $colors[array_rand($colors)],
            'sale' => 2,
            'rare' => $rare,
            'fuel' => 2 * $rare,
            'fuel_max' => 2 * $rare,
            'price' => ($speed + $power) * $rare * 4,
            'lvl' => rand(2, 5),
        ]);
    }
}

protected function generateShopParts(){
    $partsData = [
        [
            'name' => 'Медная Пластина',
            'img' => '/storage/img/mod_copper_plate.png',
            'speed' => rand(0, 5),
            'power' => rand(10, 30),
            'fuel' => rand(0, 1),
            'price_multiplier' => 10
        ],
        [
            'name' => 'Намотка Меди',
            'img' => '/storage/img/mod_copper_winding.png',
            'speed' => rand(10, 30),
            'power' => rand(0, 5),
            'fuel' => rand(0, 1),
            'price_multiplier' => 10
        ],
        [
            'name' => 'Запасной Бак',
            'img' => '/storage/img/mod_fuel.png',
            'speed' => rand(0, 5),
            'power' => rand(0, 5),
            'fuel' => rand(2, 5),
            'price_multiplier' => 25
        ]
    ];

    foreach ($partsData as $part) {
        $totalStats = $part['speed'] + $part['power'] + $part['fuel'];
        
        Part::create([
            'name' => $part['name'],
            'img' => $part['img'],
            'speed' => $part['speed'],
            'power' => $part['power'],
            'fuel' => $part['fuel'],
            'sale' => 2,
            'lvl' => rand(2, 3),
            'price' => $totalStats * $part['price_multiplier'],
        ]);
    }
}
}
