<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSubsidizationRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subsidization_rules', function (Blueprint $table) {
            $table->foreign('subsidization_organization_id', 'subsidization_rules_subsidization_organizations_id_fk')
                ->references('id')->on('subsidization_organizations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('created_by', 'subsidization_rules_users_id_fk')->references('id')->on('users')->onUpdate
            ('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subsidization_rules', function (Blueprint $table) {
            $table->dropForeign('subsidization_rules_subsidization_organizations_id_fk');
            $table->dropForeign('subsidization_rule_users_id_fk');
        });
    }
}
