<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('code')->nullable();
            $table->string('content_type');
            $table->boolean('is_url');
            $table->boolean('state');
            $table->string('file_path');
            $table->longText('description')->nullable();
            $table->unsignedInteger('module_id');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('locked_by')->nullable();
            $table->unsignedInteger('updated_by');
            $table->timestamp('locked')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('locked_by')->references('id')->on('users');
            $table->foreign('module_id')->references('id')->on('courses_course_modules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_contents');
    }
}
