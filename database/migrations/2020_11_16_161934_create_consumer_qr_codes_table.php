<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumerQrCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumer_qr_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('qr_code_hash')->nullable();
            $table->unsignedBigInteger('consumer_id')->nullable()->index('consumer_qr_codes_consumer_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumer_qr_codes');
    }
}
