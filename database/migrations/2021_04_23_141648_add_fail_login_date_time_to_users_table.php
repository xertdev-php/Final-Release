<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFailLoginDateTimeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime("fail_login_date_time")->after("password")->nullable();
            $table->enum("is_fail_login",["yes","no"])->default("no")->after("fail_login_date_time");
            $table->integer("total_fail_attempt")->default(0)->after("is_fail_login");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("fail_login_date_time");
            $table->dropColumn("is_fail_login");
            $table->dropColumn("total_fail_attempt");
        });
    }
}
