<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSubsidizedMenuCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subsidized_menu_categories', function (Blueprint $table) {
            $table->foreign('menu_category_id')->references('id')->on('menu_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('subsidization_rules_id')->references('id')->on('subsidization_rules')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subsidized_menu_categories', function (Blueprint $table) {
            $table->dropForeign('subsidized_menu_categories_menu_category_id_foreign');
            $table->dropForeign('subsidized_menu_categories_subsidization_rules_id_foreign');
        });
    }
}
