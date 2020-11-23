<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationLocationGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation_location_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vacation_id')->index('vacation_location_group_vacation_id_foreign');
            $table->unsignedBigInteger('location_group_id')->index('vacation_location_group_location_group_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacation_location_group');
    }
}
