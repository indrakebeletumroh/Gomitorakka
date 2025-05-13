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
            $table->unsignedBigInteger('uid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_respects');
    }
}
