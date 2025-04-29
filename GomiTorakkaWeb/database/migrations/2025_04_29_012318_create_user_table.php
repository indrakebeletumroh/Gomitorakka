<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
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
            $table->string('gmail', 100);
            $table->integer('age')->nullable();
            $table->string('profile_photo', 255)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('role', 20)->default('user');
            $table->integer('report_count')->default(0);
            $table->timestamps(0);  // created_at, updated_at
            $table->timestamp('deleted_at')->nullable();
        });
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
