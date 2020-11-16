<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVacationLocationGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacation_location_groups', function (Blueprint $table) {
            $table->foreign('location_group_id')->references('id')->on('location_groups')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('vacation_id')->references('id')->on('vacations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacation_location_groups', function (Blueprint $table) {
            $table->dropForeign('vacation_location_group_location_group_id_foreign');
            $table->dropForeign('vacation_location_group_vacation_id_foreign');
        });
    }
}
