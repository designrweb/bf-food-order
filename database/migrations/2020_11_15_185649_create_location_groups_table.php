<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id')->nullable()->index();
            $table->string('name');

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_groups');
    }
}
