<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->integer("id")->autoIncrement();
            $table->string("last_name",60)->nullable();
            $table->string("first_name",60)->nullable();
            $table->string("middle_name",60)->nullable();
            $table->string("address",120)->nullable();
            $table->integer("department_id");
            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('cascade')->onDelete('cascade');;
            $table->integer("city_id");
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');;
            $table->integer("state_id");
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade')->onDelete('cascade');;
            $table->integer("country_id");
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');;
            $table->char("zip",10)->nullable();
            $table->date("birth_date")->nullable();
            $table->date("date_hired")->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('employees');
    }
}
