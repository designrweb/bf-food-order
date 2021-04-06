<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCateringOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catering_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('catering_order_id')->index();
            $table->unsignedBigInteger('catering_item_id')->index();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('catering_order_id')
                ->references('id')
                ->on('catering_orders')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table->foreign('catering_item_id')
                ->references('id')
                ->on('catering_items')
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
        Schema::dropIfExists('catering_order_items');
    }
}
