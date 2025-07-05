<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $cars = Car::all()->where('sale',0);
    }
}
