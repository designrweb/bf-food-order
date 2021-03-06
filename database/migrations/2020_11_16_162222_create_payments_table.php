<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount', 12)->nullable();
            $table->tinyInteger('type')->nullable();
            $table->string('comment', 250)->nullable();
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->unsignedBigInteger('consumer_id')->nullable()->index();
            $table->unsignedBigInteger('payment_dump_id')->nullable()->index();
            $table->timestamps();
            $table->date('transacted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
