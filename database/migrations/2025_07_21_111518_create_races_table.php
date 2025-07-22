<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('races', function (Blueprint $table) {
            $table->integer('id')->nullable(false);
            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->unsignedTinyInteger('price')->nullable(false)->default(1);
            $table->string('img', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('img_game', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->unsignedSmallInteger('prize')->nullable(false)->default(1);
            $table->unsignedTinyInteger('min_lvl')->nullable(false)->default(1);
            $table->tinyInteger('dirt')->nullable(false)->default(0);
        });

        // Добавляем первичный ключ
        Schema::table('races', function (Blueprint $table) {
            $table->primary('id');
        });

        // Добавляем AUTO_INCREMENT
        DB::statement("ALTER TABLE races MODIFY id int NOT NULL AUTO_INCREMENT");
        
        // Устанавливаем начальное значение AUTO_INCREMENT
        DB::statement("ALTER TABLE races AUTO_INCREMENT=1");

        // Устанавливаем движок и кодировку
        DB::statement("ALTER TABLE races ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public function down()
    {
        Schema::dropIfExists('races');
    }
};