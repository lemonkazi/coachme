<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('camps', function (Blueprint $table) {
            $table->string('speciality_id')->nullable()->after('camp_type_id');
            $table->unsignedBigInteger('age_id')->nullable()->after('camp_type_id');
            $table->foreign('age_id')->references('id')->on('ages');
            $table->string('website', 100)->nullable()->after('camp_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('camps', function (Blueprint $table) {
            $table->dropColumn('speciality_id');
            $table->dropForeign(['age_id']);
            $table->dropColumn('age_id');
            $table->dropColumn('website');
        });
    }
}
