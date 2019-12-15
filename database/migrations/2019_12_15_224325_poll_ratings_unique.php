<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PollRatingsUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poll_ratings', function (Blueprint $table) {
            $table->unique(["poll_id", "user_id", "item_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poll_ratings', function (Blueprint $table) {
            $table->dropUnique("poll_ratings_poll_id_user_id_item_id");
        });
    }
}
