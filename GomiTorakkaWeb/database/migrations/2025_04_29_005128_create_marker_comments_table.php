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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('comment');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('marker_id')->references('marker_id')->on('markers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_comments');
    }
}
