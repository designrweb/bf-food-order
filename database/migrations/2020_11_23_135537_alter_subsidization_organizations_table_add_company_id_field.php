<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSubsidizationOrganizationsTableAddCompanyIdField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subsidization_organizations', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->index()->after('street');
        });

        Schema::table('subsidization_organizations', function (Blueprint $table) {
            $table->foreign('company_id', 'subsidization_organizations_company_id_foreign')->references('id')->on('companies')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subsidization_organizations', function (Blueprint $table) {
            $table->dropForeign('subsidization_organizations_company_id_foreign');
        });

        Schema::table('subsidization_organizations', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
}
