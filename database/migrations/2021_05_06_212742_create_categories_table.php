<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive']);

            // لتطبيق مبدا الشجرة
            //created foreign Key
            // $table->unsignedBigInteger('parent_id')->nullable();
            // $table->foreign('parent_id')->references("id")->on('categories')->onDelete('set null');
            // سطر مختصر عن انشاء مفتاح ثانوي ووضع قيود ويقوم بنفس ما يقوم به السطرين السابقين
            $table->foreignId('parent_id')->nullable()->constrained('categories', 'id')->nullOnDelete();

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
        Schema::dropIfExists('categories');
    }
}
