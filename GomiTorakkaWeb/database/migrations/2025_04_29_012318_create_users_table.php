<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateUsersTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel users.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('uid');
            $table->string('username', 50);
            $table->string('password', 255);
            $table->string('email', 100);
            $table->integer('age')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->integer('report_count')->default(0);
            $table->timestamps(0);  // created_at, updated_at
            $table->timestamp('deleted_at')->nullable();
            $table->enum('role', ['user', 'admin'])->default('user'); // untuk membedakan admin & user
        });
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 100000');
    }

    /**
     * Balikkan perubahan jika migrasi dibatalkan.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
