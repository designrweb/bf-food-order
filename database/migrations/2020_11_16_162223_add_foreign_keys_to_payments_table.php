<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('consumer_id', 'payment_consumer_id_foreign')->references('id')->on('consumers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('order_id', 'payment_order_id_foreign')->references('id')->on('orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payment_consumer_id_foreign');
            $table->dropForeign('payment_order_id_foreign');
        });
    }
}
