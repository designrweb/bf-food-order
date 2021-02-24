<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageUrlToUserInfo extends Migration
{
    public function up()
    {
        Schema::table('user_info', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('street');
            $table->date('birthday')->nullable()->after('image_url');
        });
    }

    public function down()
    {
        Schema::table('user_info', function (Blueprint $table) {
            $table->dropColumn('image_url');
            $table->dropColumn('birthday');
        });
    }
}