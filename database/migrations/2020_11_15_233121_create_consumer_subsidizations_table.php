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
            $table->unsignedBigInteger('subsidization_rule_id')->nullable()->index();
            $table->unsignedBigInteger('consumer_id')->index();
            $table->date('subsidization_start')->nullable();
            $table->date('subsidization_end')->nullable();
            $table->string('subsidization_document')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('consumer_id')
                ->references('id')
                ->on('consumers')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table->foreign('subsidization_rule_id')
                ->references('id')
                ->on('subsidization_rules')
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
        Schema::dropIfExists('consumer_subsidizations');
    }
}
