<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_requests', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->unique();
            $table->string('company_admin_email')->unique();
            $table->string('company_admin_first_name');
            $table->string('company_admin_last_name');
            $table->string('company_phone_number')->nullable();
            $table->string('company_backup_email')->nullable();
            $table->boolean('status')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('registration_requests');
    }
}
