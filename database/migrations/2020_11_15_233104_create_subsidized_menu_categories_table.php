<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubsidizedMenuCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsidized_menu_categories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('subsidization_rule_id')->index();
            $table->unsignedBigInteger('menu_category_id')->index();
            $table->integer('percent')->nullable();
            $table->timestamps();

            $table->foreign('menu_category_id')
                ->references('id')
                ->on('menu_categories')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table->foreign('subsidization_rule_id')
                ->references('id')
                ->on('subsidization_rules')
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
        Schema::dropIfExists('subsidized_menu_categories');
    }
}
