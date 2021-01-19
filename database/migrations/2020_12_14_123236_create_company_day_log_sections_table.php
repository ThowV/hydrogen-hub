<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDayLogSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_day_log_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_day_log_id');
            $table->enum('hydrogen_type', ['green', 'blue', 'grey', 'mix']);
            $table->unsignedBigInteger('produce')->default(0);
            $table->BigInteger('demand')->default(0);
            $table->BigInteger('store')->default(0);
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
        Schema::dropIfExists('company_day_log_sections');
    }
}
