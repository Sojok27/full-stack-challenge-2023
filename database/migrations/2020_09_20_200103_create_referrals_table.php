<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_no');
            $table->string('organisation')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->text('street_address')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('country');
            $table->string('gps_location')->nullable();
            $table->string('facility_name')->nullable();
            $table->string('facility_type')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('position')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('pills_available')->nullable();
            $table->string('code_to_use')->nullable();
            $table->string('type_of_service')->nullable();
            $table->text('note')->nullable();
            $table->text('womens_evaluation')->nullable();
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
        Schema::dropIfExists('referrals');
    }
}
