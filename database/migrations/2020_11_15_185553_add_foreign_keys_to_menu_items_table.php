<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->foreign('location_id', 'menuitem_location_id_foreign')->references('id')->on('locations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('menu_category_id', 'menuitem_menu_category_id_foreign')->references('id')->on('menu_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropForeign('menuitem_location_id_foreign');
            $table->dropForeign('menuitem_menu_category_id_foreign');
        });
    }
}
