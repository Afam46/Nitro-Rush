<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\Car;

class RefillCarsFuel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refill-cars-fuel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Пополнение бензика';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cars = Car::all();

        foreach($cars as $car){
            if($car->fuel < $car->fuel_max){
                $car->increment('fuel');
            }
        }

        $this->info('Топливо в машинах успешно обновлено');
    }
}
