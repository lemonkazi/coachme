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
            $table->unsignedInteger('experience_id')->nullable();
            $table->foreign('experience_id')->references('id')->on('experiences');
            $table->unsignedInteger('certificate_id')->nullable();
            $table->foreign('certificate_id')->references('id')->on('certificates');
            $table->unsignedInteger('price_id')->nullable();
            $table->foreign('price_id')->references('id')->on('prices');
            $table->string('family_name', 50)->nullable();
            $table->string('name', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->text('about')->nullable();
            $table->string('web_site_url')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            
            $table->foreign('province_id')
                ->references('id')
                ->on('provinces');

            $table->unsignedBigInteger('city_id')->nullable();
            
            $table->foreign('city_id')
                ->references('id')
                ->on('locations');
            $table->string('phone_number', 25)->nullable();
            $table->string('whatsapp', 25)->nullable();
            $table->text('avatar_image_path')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHER'])->nullable();
            $table->enum('authority', ['SUPER_ADMIN','COACH_USER', 'RINK_USER'])->nullable();
            $table->boolean('is_verified')->nullable();
            $table->boolean('is_published')->nullable();
            $table->string('token')->nullable();
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
