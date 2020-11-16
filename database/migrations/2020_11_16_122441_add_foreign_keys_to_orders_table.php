<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('consumer_id')->references('id')->on('consumers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('menuitem_id')->references('id')->on('menu_items')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('subsidization_organization_id')->references('id')->on('subsidization_organizations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_consumer_id_foreign');
            $table->dropForeign('orders_menuitem_id_foreign');
            $table->dropForeign('orders_subsidization_organization_id_foreign');
        });
    }
}
