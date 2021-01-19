<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyHydrogenInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_hydrogen_interests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->enum('interest', ['green', 'blue', 'grey', 'mix', 'combined']);
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
        Schema::dropIfExists('company_hydrogen_interests');
    }
}
