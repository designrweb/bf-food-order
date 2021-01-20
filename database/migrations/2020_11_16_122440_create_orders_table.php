<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type')->nullable();
            $table->unsignedBigInteger('menuitem_id')->index();
            $table->unsignedBigInteger('consumer_id')->index();
            $table->date('day')->nullable();
            $table->boolean('pickedup')->nullable()->default(0);
            $table->dateTime('pickedup_at')->nullable();
            $table->tinyInteger('quantity')->default(0);
            $table->boolean('is_subsidized')->nullable()->default(0);
            $table->unsignedBigInteger('subsidization_organization_id')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
