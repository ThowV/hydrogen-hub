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
            $table->foreignId('creator_id');
            $table->foreignId('responder_id')->nullable();
            $table->enum('trade_type', ['offer', 'request']);
            $table->enum('hydrogen_type', ['green', 'blue', 'grey']);
            $table->boolean('open')->default(true);
            $table->unsignedBigInteger('units_per_hour')->default(0);
            $table->unsignedBigInteger('volumes')->default(0);
            $table->unsignedBigInteger('price_per_unit')->default(0);
            $table->tinyInteger('mix_co2')->default(0);
            $table->dateTime('ends_at');
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
