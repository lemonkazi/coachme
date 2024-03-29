<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('id')->on('levels');
            
            $table->unsignedInteger('rink_id')->nullable();
            $table->foreign('rink_id')->references('id')->on('rinks');
            
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations');
            
            $table->string('program_type_id')->nullable();
            
            $table->string('name', 50)->nullable();
            $table->string('web_site_url')->nullable();

            $table->datetime('reg_start_date')->nullable();
            $table->datetime('reg_end_date')->nullable();
            $table->string('price', 50)->nullable();
            $table->text('about')->nullable();

            $table->string('contacts', 25)->nullable();
            $table->string('whatsapp', 25)->nullable();
            $table->string('email')->nullable();

            $table->string('starting_age', 25)->nullable();

            $table->datetime('schedule_start_date')->nullable();
            $table->datetime('schedule_end_date')->nullable();
            $table->text('schedule_log')->nullable();

            $table->unsignedBigInteger('user_id')->nullable()->comment = 'This camp is created by user_id';
            $table->foreign('user_id')->references('id')->on('users');
            
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
        Schema::dropIfExists('programs');
    }
}
