<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inboxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // tanpa foreign key
            $table->unsignedBigInteger('marker_id')->nullable(); // juga tanpa foreign key
            $table->string('title');
            $table->text('message');
            $table->enum('status', ['unread', 'read'])->default('unread');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inboxes');
    }
};
