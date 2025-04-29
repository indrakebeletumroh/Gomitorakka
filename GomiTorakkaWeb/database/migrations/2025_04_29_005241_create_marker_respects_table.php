<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkerRespectsTable extends Migration
{
    public function up(): void
    {
        Schema::create('marker_respects', function (Blueprint $table) {
            $table->id('respect_id');
            $table->unsignedBigInteger('marker_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('marker_id')->references('marker_id')->on('markers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_respects');
    }
}
