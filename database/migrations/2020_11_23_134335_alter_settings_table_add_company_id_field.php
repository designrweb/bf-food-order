<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSettingsTableAddCompanyIdField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->index()->after('value');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->foreign('company_id', 'settings_company_id_foreign')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropForeign('settings_company_id_foreign');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
}
