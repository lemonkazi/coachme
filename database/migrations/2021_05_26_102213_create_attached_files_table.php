<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attached_files', function (Blueprint $table) {
            $table->id();
            $table->enum('content_type', ['CAMP', 'PROGRAM'])->nullable();
            $table->unsignedInteger('content_id')->nullable();
            $table->enum('type', ['SCHEDULE', 'PHOTO'])->nullable();
            $table->unsignedInteger('user_id')->nullable()->comment = 'This attachment is reported by user_id';
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name', 50);
            $table->text('path')->nullable();
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
        Schema::dropIfExists('attached_files');
    }
}
