<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToConsumerSubsidizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumer_subsidizations', function (Blueprint $table) {
            $table->foreign('subsidization_rule_id')->references('id')->on('subsidization_rule')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
            $table->dropForeign('consumer_subsidizations_subsidization_rule_id_foreign');
        });
    }
}
