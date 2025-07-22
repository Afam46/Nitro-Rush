<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->integer('id')->nullable(false);
            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->mediumInteger('price')->nullable(false)->default(100);
            $table->string('img', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->unsignedSmallInteger('speed')->nullable(false)->default(0);
            $table->unsignedSmallInteger('power')->nullable(false)->default(0);
            $table->unsignedSmallInteger('fuel')->nullable(false)->default(0);
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->integer('car_id')->nullable()->default(null);
            $table->unsignedTinyInteger('lvl')->nullable(false)->default(1);
            $table->tinyInteger('sale')->nullable(false)->default(0);
            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->default(null);
        });

        // Добавляем первичный ключ и индексы
        Schema::table('parts', function (Blueprint $table) {
            $table->primary('id');
            $table->index('car_id');
            $table->index('user_id');
        });

        // Добавляем AUTO_INCREMENT и внешние ключи
        DB::statement("
            ALTER TABLE parts 
            MODIFY id int NOT NULL AUTO_INCREMENT,
            ADD CONSTRAINT parts_ibfk_1 
                FOREIGN KEY (car_id) REFERENCES cars (id) 
                ON DELETE RESTRICT ON UPDATE RESTRICT,
            ADD CONSTRAINT parts_ibfk_2 
                FOREIGN KEY (user_id) REFERENCES users (id) 
                ON DELETE RESTRICT ON UPDATE RESTRICT
        ");

        // Устанавливаем движок и кодировку
        DB::statement("ALTER TABLE parts ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        // Устанавливаем начальное значение AUTO_INCREMENT
        DB::statement("ALTER TABLE parts AUTO_INCREMENT=1");
    }

    public function down()
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->dropForeign('parts_ibfk_1');
            $table->dropForeign('parts_ibfk_2');
        });
        
        Schema::dropIfExists('parts');
    }
};