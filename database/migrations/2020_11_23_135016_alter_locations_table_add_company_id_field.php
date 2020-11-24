<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLocationsTableAddCompanyIdField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->index()->after('street');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->foreign('company_id', 'locations_company_id_foreign')->references('id')->on('companies')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign('locations_company_id_foreign');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
}
