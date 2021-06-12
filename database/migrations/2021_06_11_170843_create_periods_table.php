<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->enum('content_type', ['CAMP', 'PROGRAM'])->nullable();
            $table->unsignedInteger('content_id')->nullable();
            $table->enum('type', ['FALL', 'SUMMER','SPRING','WINTER'])->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->comment = 'This attachment is reported by user_id';
            $table->foreign('user_id')->references('id')->on('users');
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->timestamps();
            $table->datetime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periods');
    }
}
