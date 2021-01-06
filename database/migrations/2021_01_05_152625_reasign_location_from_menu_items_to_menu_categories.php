<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReasignLocationFromMenuItemsToMenuCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropForeign('menuitem_location_id_foreign');
            $table->dropColumn('location_id');
        });

        Schema::table('menu_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->after('presaleprice')->index('menu_categories_location_id_foreign');
        });

        Schema::table('menu_categories', function (Blueprint $table) {
            $table->foreign('location_id')->references('id')->on('locations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_categories', function (Blueprint $table) {
            $table->dropForeign('menu_categories_location_id_foreign');
            $table->dropColumn('location_id');
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->index('menuitem_location_id_foreign');
        });
    }
}
