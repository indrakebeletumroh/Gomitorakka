<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToMarkersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('markers', function (Blueprint $table) {
            $table->string('image')->nullable()->after('admin_note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('markers', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}