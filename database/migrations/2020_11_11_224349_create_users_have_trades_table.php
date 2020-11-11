<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersHaveTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_have_trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('trade_id');
            // If we need the timestamps we could refer to the actual trade entries.
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_have_trades');
    }
}
