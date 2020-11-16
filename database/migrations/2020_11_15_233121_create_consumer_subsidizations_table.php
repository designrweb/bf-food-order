<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumerSubsidizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumer_subsidizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subsidization_rule_id')->nullable()->index('consumer_subsidizations_subsidization_rule_id_foreign');
            $table->date('subsidization_start')->nullable();
            $table->date('subsidization_end')->nullable();
            $table->string('subsidization_document')->nullable();
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
        Schema::dropIfExists('consumer_subsidizations');
    }
}
