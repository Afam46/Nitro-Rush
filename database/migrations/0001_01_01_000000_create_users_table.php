<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->nullable(false);
            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('email', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->string('password', 255)->collation('utf8mb4_unicode_ci')->nullable(false);
            $table->string('remember_token', 100)->collation('utf8mb4_unicode_ci')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->integer('balance')->nullable(false)->default(100000);
        });

        // Добавляем первичный ключ и уникальный индекс
        Schema::table('users', function (Blueprint $table) {
            $table->primary('id');
            $table->unique('email', 'users_email_unique');
        });

        // Добавляем AUTO_INCREMENT
        DB::statement("ALTER TABLE users MODIFY id bigint UNSIGNED NOT NULL AUTO_INCREMENT");
        
        // Устанавливаем начальное значение AUTO_INCREMENT
        DB::statement("ALTER TABLE users AUTO_INCREMENT=1");

        // Устанавливаем движок и кодировку
        DB::statement("ALTER TABLE users ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};