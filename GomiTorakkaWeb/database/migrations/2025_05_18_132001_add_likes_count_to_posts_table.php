<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// Add this DB facade import
use Illuminate\Support\Facades\DB;

class AddLikesCountToPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedInteger('likes_count')->default(0)->after('comment_count');
        });
        
        // Update existing posts with current like counts
        DB::table('posts')->update([
            'likes_count' => DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.post_id)')
        ]);
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('likes_count');
        });
    }
}