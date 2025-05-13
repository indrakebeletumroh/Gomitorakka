<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkerCommentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('marker_comments', function (Blueprint $table) {
            $table->id('comment_id');
            $table->unsignedBigInteger('marker_id')->nullable();
            $table->unsignedBigInteger('uid')->nullable();
            $table->text('comment');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_comments');
    }
}
