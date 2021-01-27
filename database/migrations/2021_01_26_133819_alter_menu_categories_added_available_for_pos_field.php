<?php

use App\MenuCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMenuCategoriesAddedAvailableForPosField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_categories', function (Blueprint $table) {
            $table->enum('not_available_for_pos', [MenuCategory::AVAILABLE_POS, MenuCategory::NOT_AVAILABLE_POS])->after('presaleprice')->default(MenuCategory::AVAILABLE_POS);
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
            $table->dropColumn('not_available_for_pos');
        });
    }
}
