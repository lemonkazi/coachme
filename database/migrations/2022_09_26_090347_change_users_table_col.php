<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsersTableCol extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('level_id')->nullable()->after('age_id');
            $table->string('language_id')->nullable()->after('age_id');
            $table->string('speciality_id')->nullable()->after('age_id');
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
            $table->dropColumn('level_id');
            $table->dropColumn('language_id');
            $table->dropColumn('speciality_id');
        });
    }
}
