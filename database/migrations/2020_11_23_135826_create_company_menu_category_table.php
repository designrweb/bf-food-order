<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMenuCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_menu_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('menu_category_id')->index();
            $table->unsignedBigInteger('company_id')->index();
        });

        Schema::table('company_menu_category', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('menu_category_id')->references('id')->on('menu_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_menu_category');
    }
}
