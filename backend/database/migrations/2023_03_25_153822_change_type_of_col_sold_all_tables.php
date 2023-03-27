<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeOfColSoldAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table){
            $table->integer('sold')->nullable()->default(0)->change();
            $table->integer('view')->nullable()->default(0)->change();
        });

        Schema::table('books', function (Blueprint $table){
            $table->integer('sold')->nullable()->default(0)->change();
        });

        Schema::table('users', function (Blueprint $table){
            $table->integer('coin')->nullable()->default(0)->change();
            $table->integer('price')->nullable()->default(0)->change();
            $table->integer('check')->nullable()->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
