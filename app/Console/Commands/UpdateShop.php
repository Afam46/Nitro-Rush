<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Car;
use App\Models\Part;
use App\Models\Check_item;

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
    public function handle()
    {
        Check_item::truncate();

        Car::where('sale', 2)->delete();

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

        $speedCar1 = rand(15, 70);
        $powerCar1 = rand(15, 70);
        $rareCar1 = rand(1,3);

        $speedCar2 = rand(15, 70);
        $powerCar2 = rand(15, 70);
        $rareCar2 = rand(1,3);

        $names = ['Aurora','Desert Hawk','Neon Flash','Phantom Racer','Prism',
        'Stormrider','Thunderbolt','Vortex','Wildfire','Cyclop','Eclipse X',
        'Phoenix','Quantum','Shadow','Storm',
        ];

        Car::create([
            'name' => $names[rand(0,count($names)-1)],
            'img' => '.',
            'speed' => $speedCar1,
            'power' => $powerCar1,
            'color' => $colors[rand(0,count($colors)-1)],
            'sale' => 2,
            'rare' => $rareCar1,
            'fuel' => 2*$rareCar1,
            'fuel_max' => 2*$rareCar1,
            'price' => array_sum(
            [$speedCar1*($rareCar1/2),$powerCar1*($rareCar1/2)])*8,

            'lvl' => rand(2,5),
        ]);
        Car::create([
            'name' => $names[rand(0,count($names)-1)],
            'img' => '.',
            'speed' => $speedCar2,
            'power' => $powerCar2,
            'color' => $colors[rand(0,count($colors)-1)],
            'sale' => 2,
            'rare' => $rareCar2,
            'fuel' => 2*$rareCar2,
            'fuel_max' => 2*$rareCar2,
            'price' => array_sum(
            [$speedCar2*($rareCar2/2),$powerCar2*($rareCar2/2)])*8,
            'lvl' => rand(2,5),
        ]);

        Part::where('sale', 2)->delete();

        $partsAtributes = [
            'Усилитель' =>
            [
                'speed' => rand(0,5),
                'power' => rand(10, 30),
                'fuel' => rand(0,1),
                'img' => '/storage/img/mod_copper_plate.png',
            ],
            'Ускоритель' =>
            [
                'speed' => rand(10,30),
                'power' => rand(0,5),
                'fuel' => rand(0,1),
                'img' => '/storage/img/mod_copper_winding.png',
            ],
            'Увелечитель бака' =>
            [
                'speed' => rand(0,5),
                'power' => rand(0,5),
                'fuel' => rand(2,5),
                'img' => '/storage/img/mod_fuel.png',
            ]
        ];

        $sum1 = array_sum([
            $partsAtributes['Усилитель']['speed'],
            $partsAtributes['Усилитель']['power'],
            $partsAtributes['Усилитель']['fuel'],
        ]);
        $sum2 = array_sum([
            $partsAtributes['Ускоритель']['speed'],
            $partsAtributes['Ускоритель']['power'],
            $partsAtributes['Ускоритель']['fuel'],
        ]);
        $sum3 = array_sum([
            $partsAtributes['Увелечитель бака']['speed'],
            $partsAtributes['Увелечитель бака']['power'],
            $partsAtributes['Увелечитель бака']['fuel'],
        ]);

        Part::create([
            'name' => 'Медная пластина',
            'img' => $partsAtributes['Усилитель']['img'],
            'speed' => $partsAtributes['Усилитель']['speed'],
            'power' => $partsAtributes['Усилитель']['power'],
            'fuel' => $partsAtributes['Усилитель']['fuel'],
            'sale' => 2,
            'lvl' => rand(1,3),
            'price' => $sum1*10
        ]);
        Part::create([
            'name' => 'Намотка меди',
            'img' => $partsAtributes['Ускоритель']['img'],
            'speed' => $partsAtributes['Ускоритель']['speed'],
            'power' => $partsAtributes['Ускоритель']['power'],
            'fuel' => $partsAtributes['Ускоритель']['fuel'],
            'sale' => 2,
            'lvl' => rand(1,3),
            'price' => $sum2*10
        ]);
        Part::create([
            'name' => 'Запасной бак',
            'img' => $partsAtributes['Увелечитель бака']['img'],
            'speed' => $partsAtributes['Увелечитель бака']['speed'],
            'power' => $partsAtributes['Увелечитель бака']['power'],
            'fuel' => $partsAtributes['Увелечитель бака']['fuel'],
            'sale' => 2,
            'lvl' => rand(1,3),
            'price' => $sum3*25
        ]);

        $this->info('Магазин обновлен на');
    }
}
