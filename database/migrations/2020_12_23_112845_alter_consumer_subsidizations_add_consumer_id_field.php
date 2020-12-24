<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterConsumerSubsidizationsAddConsumerIdField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumer_subsidizations', function (Blueprint $table) {
            $table->unsignedBigInteger('consumer_id')->after('subsidization_rules_id')->index('consumer_subsidizations_consumer_id_foreign');
        });

        Schema::table('consumer_subsidizations', function (Blueprint $table) {
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
        Schema::table('consumer_subsidizations', function (Blueprint $table) {
            $table->dropForeign('consumer_subsidizations_consumer_id_foreign');
            $table->dropColumn('consumer_id');
        });
    }
}
