<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersUserinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_userinfo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->integer('lrn_user')->nullable();
            $table->integer('is_editable')->default('1');
            $table->string('fiscal_code')->nullable();
            $table->string('gender')->default('M');
            $table->date('birth_date')->nullable();
            $table->unsignedInteger('birth_place');
            $table->unsignedInteger('nationality');
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->unsignedInteger('country');
            $table->unsignedInteger('region');
            $table->unsignedInteger('prov');
            $table->unsignedInteger('town');
            $table->string('address')->nullable();
            $table->string('zipcode')->nullable();
            $table->unsignedInteger('education')->nullable();
            $table->integer('employment')->nullable();
            $table->integer('school_region')->nullable();
            $table->string('school_name')->nullable();
            $table->string('school_codice_meccanografico')->nullable();
            $table->integer('english_level')->nullable();
            $table->integer('english_level_declaration')->nullable();
            $table->string('cv')->nullable();
            $table->integer('document_type')->nullable();
            $table->string('document')->nullable();
            $table->string('document_number')->nullable();
            $table->date('document_expire_date')->nullable();
            $table->string('high_school_diploma_name')->nullable();
            $table->date('high_school_diploma_date')->nullable();
            $table->string('high_school_diploma_institute')->nullable();
            $table->string('university_degree_faculty')->nullable();
            $table->string('university_degree_name')->nullable();
            $table->date('university_degree_date')->nullable();
            $table->string('university_degree_institute')->nullable();
            $table->unsignedInteger('structure_id')->nullable();
            $table->string('token');
            $table->integer('state');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_userinfo');
    }
}
