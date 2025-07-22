<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('check_items', function (Blueprint $table) {
            $table->integer('id')->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->integer('car_id')->nullable()->default(null);
            $table->integer('part_id')->nullable()->default(null);
        });

        Schema::table('check_items', function (Blueprint $table) {
            $table->primary('id');
            $table->index('car_id');
            $table->index('part_id');
            $table->index('user_id');
        });

        DB::statement("
            ALTER TABLE check_items 
            MODIFY id int NOT NULL AUTO_INCREMENT,
            ADD CONSTRAINT check_items_ibfk_1 
                FOREIGN KEY (car_id) REFERENCES cars (id) 
                ON DELETE RESTRICT ON UPDATE RESTRICT,
            ADD CONSTRAINT check_items_ibfk_2 
                FOREIGN KEY (part_id) REFERENCES parts (id) 
                ON DELETE RESTRICT ON UPDATE RESTRICT,
            ADD CONSTRAINT check_items_ibfk_3 
                FOREIGN KEY (user_id) REFERENCES users (id) 
                ON DELETE RESTRICT ON UPDATE RESTRICT
        ");

        DB::statement("ALTER TABLE check_items ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public function down()
    {
        Schema::table('check_items', function (Blueprint $table) {
            $table->dropForeign('check_items_ibfk_1');
            $table->dropForeign('check_items_ibfk_2');
            $table->dropForeign('check_items_ibfk_3');
        });
        
        Schema::dropIfExists('check_items');
    }
};