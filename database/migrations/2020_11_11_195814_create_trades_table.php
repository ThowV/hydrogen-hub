<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id');
            $table->foreignId('responder_id')->nullable();
            $table->dateTime('deal_made_at')->nullable();
            $table->enum('trade_type', ['offer', 'request']);
            $table->enum('hydrogen_type', ['green', 'blue', 'grey', 'mix']);
            $table->unsignedBigInteger('units_per_hour')->default(0);
            $table->unsignedBigInteger('duration')->default(0);
            $table->unsignedBigInteger('price_per_unit')->default(0);
            $table->tinyInteger('mix_co2')->default(0);
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trades');
    }
}
