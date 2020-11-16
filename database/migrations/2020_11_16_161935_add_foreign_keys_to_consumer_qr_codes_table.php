<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToConsumerQrCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumer_qr_codes', function (Blueprint $table) {
            $table->foreign('consumer_id')->references('id')->on('consumers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consumer_qr_codes', function (Blueprint $table) {
            $table->dropForeign('consumer_qr_codes_consumer_id_foreign');
        });
    }
}
