<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('rink_id')->nullable();
            $table->foreign('rink_id')->references('id')->on('rinks');
            $table->unsignedInteger('speciality_id')->nullable();
            $table->foreign('speciality_id')->references('id')->on('speciality');
            $table->unsignedInteger('experience_id')->nullable();
            $table->foreign('experience_id')->references('id')->on('experiences');
            $table->unsignedInteger('certificate_id')->nullable();
            $table->foreign('certificate_id')->references('id')->on('certificates');
            $table->unsignedInteger('price_id')->nullable();
            $table->foreign('price_id')->references('id')->on('prices');
            $table->unsignedInteger('language_id')->nullable();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->string('family_name', 50)->nullable();
            $table->string('name', 50);
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->text('about')->nullable();
            $table->string('province', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('phone_number', 25)->nullable();
            $table->string('whatsapp', 25)->nullable();
            $table->text('avatar_image_path')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHER'])->nullable();
            $table->enum('authority', ['SUPER_ADMIN','COACH_USER', 'RINK_USER'])->nullable();
            $table->boolean('is_verified');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
