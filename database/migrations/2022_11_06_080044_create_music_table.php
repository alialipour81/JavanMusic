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
        Schema::create('music', function (Blueprint $table) {
            $table->id();
            $table->integer('album_id')->default(0);
            $table->integer('artist_id');
            $table->integer('user_id');
            $table->string('name');
            $table->text('slug');
            $table->string('image');
            $table->text('text');
            $table->text('quality_128')->nullable();
            $table->string('format_128')->nullable();
            $table->text('quality_320')->nullable();
            $table->string('format_320')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('music');
    }
};
