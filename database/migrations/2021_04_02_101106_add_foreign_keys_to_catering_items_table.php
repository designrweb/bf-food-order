<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCateringItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catering_items', function (Blueprint $table) {
            $table->foreign('catering_category_id')->references('id')->on('catering_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catering_items', function (Blueprint $table) {
            $table->dropForeign('catering_items_catering_category_id_foreign');
        });
    }
}
