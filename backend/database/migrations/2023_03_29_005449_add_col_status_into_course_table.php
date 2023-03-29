<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColStatusIntoCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->tinyInteger('status')->after('type')->default(0)->nullable();
        });

        Schema::table('book_users', function (Blueprint $table) {
            $table->bigInteger('sum_price')->after('type_money')->default(0)->nullable();
        });

        Schema::table('course_users', function (Blueprint $table) {
            $table->bigInteger('sum_price')->after('type_money')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('book_users', function (Blueprint $table) {
            $table->dropColumn('sum_price');
        });

        Schema::table('course_users', function (Blueprint $table) {
            $table->dropColumn('sum_price');
        });
    }
}
