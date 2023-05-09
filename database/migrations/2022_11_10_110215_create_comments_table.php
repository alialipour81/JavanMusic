<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->enum('type',['music','blog','proposal'])->default('music');
            $table->integer('type_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('text');
            $table->integer('child')->default(0);
            $table->integer('star')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('comments');
    }
};
