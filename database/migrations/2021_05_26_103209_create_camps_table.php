<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('id')->on('levels');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations');
            
            $table->unsignedInteger('rink_id')->nullable();
            $table->foreign('rink_id')->references('id')->on('rinks');
            
            $table->unsignedBigInteger('camp_type_id')->nullable();
            $table->foreign('camp_type_id')->references('id')->on('camp_types');
            
            $table->string('name', 50)->nullable();
            $table->string('web_site_url')->nullable();

            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('price', 50)->nullable();
            $table->text('about')->nullable();

            $table->string('contacts', 25)->nullable();
            $table->string('whatsapp', 25)->nullable();
            
            
            
            $table->text('coaches')->nullable();

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
        Schema::dropIfExists('camps');
    }
}
