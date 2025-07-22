<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->integer('id')->nullable(false);
            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->mediumInteger('price')->nullable(false)->default(100);
            $table->unsignedSmallInteger('speed')->nullable(false);
            $table->unsignedSmallInteger('fuel_max')->nullable(false)->default(2);
            $table->unsignedSmallInteger('fuel')->nullable(false)->default(2);
            $table->unsignedSmallInteger('power')->nullable(false);
            $table->float('lvl')->nullable(false)->default(1);
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->tinyInteger('sale')->nullable(false)->default(0);
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->default(null);
            $table->unsignedMediumInteger('wins')->nullable(false)->default(0);
            $table->unsignedMediumInteger('quantity')->nullable(false)->default(0);
            $table->string('color', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->tinyInteger('rare')->nullable(false)->default(1);
        });

        // Добавляем первичный ключ и индекс
        Schema::table('cars', function (Blueprint $table) {
            $table->primary('id');
            $table->index('user_id');
        });

        // Добавляем AUTO_INCREMENT и внешний ключ
        DB::statement("
            ALTER TABLE cars 
            MODIFY id int NOT NULL AUTO_INCREMENT,
            ADD CONSTRAINT cars_ibfk_1 
                FOREIGN KEY (user_id) REFERENCES users (id) 
                ON DELETE RESTRICT ON UPDATE RESTRICT
        ");

        // Устанавливаем движок и кодировку
        DB::statement("ALTER TABLE cars ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        // Устанавливаем начальное значение AUTO_INCREMENT
        DB::statement("ALTER TABLE cars AUTO_INCREMENT=1");
    }

    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropForeign('cars_ibfk_1');
        });
        
        Schema::dropIfExists('cars');
    }
};