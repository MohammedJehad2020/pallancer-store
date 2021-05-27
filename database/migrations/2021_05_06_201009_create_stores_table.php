<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            //$table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            $table->id();

            //name VARCHAR(255) NOT NULL
            $table->string('name');
            $table->string('slug')->unique();
            $table->char('currency',3)->default('USD');
            $table->char('local',2)->default('en');
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->enum('staatus',['active', 'inactive'])->default('active');

            // created_at TIMESTAMP, updated_at TIMESTAMP
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
        Schema::dropIfExists('stores');
    }
}
