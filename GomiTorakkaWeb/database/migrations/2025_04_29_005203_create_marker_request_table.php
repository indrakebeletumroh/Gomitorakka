<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkerRequestTable extends Migration
{
    public function up(): void
    {
        Schema::create('marker_request', function (Blueprint $table) {
            $table->id('request_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_request');
    }
}
