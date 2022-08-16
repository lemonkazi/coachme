<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('certificate_name', 50)->nullable()->after('certificate_id');
            $table->unsignedBigInteger('age_id')->nullable()->after('certificate_id');
            $table->foreign('age_id')->references('id')->on('ages');
            //$table->string('level_id')->nullable()->after('certificate_id');
            $table->string('website', 100)->nullable()->after('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('certificate_name');
            $table->dropForeign(['age_id']);
            $table->dropColumn('age_id');
            //$table->dropColumn('level_id');
            $table->dropColumn('website');
        });
    }
}
