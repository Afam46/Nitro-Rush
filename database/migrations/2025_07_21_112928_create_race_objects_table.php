<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('race_objects', function (Blueprint $table) {
            $table->integer('id')->nullable(false);
            $table->string('img', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->tinyInteger('img_size')->nullable(false)->default(100);
            $table->tinyInteger('size')->nullable(false);
            $table->tinyInteger('z_index')->nullable(false);
            $table->tinyInteger('sliding')->nullable(false)->default(0);
            $table->integer('race_id')->nullable(false);
        });

        Schema::table('race_objects', function (Blueprint $table) {
            $table->primary('id');
            $table->index('race_id');
        });

        DB::statement("
            ALTER TABLE race_objects 
            MODIFY id int NOT NULL AUTO_INCREMENT,
            ADD CONSTRAINT race_objects_ibfk_1 
                FOREIGN KEY (race_id) REFERENCES races (id) 
                ON DELETE RESTRICT ON UPDATE RESTRICT
        ");

        DB::statement("ALTER TABLE race_objects ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public function down()
    {
        Schema::table('race_objects', function (Blueprint $table) {
            $table->dropForeign('race_objects_ibfk_1');
        });
        
        Schema::dropIfExists('race_objects');
    }
};