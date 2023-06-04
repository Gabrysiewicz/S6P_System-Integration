<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->unsignedInteger('developer_id');
            $table->unsignedInteger('publisher_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('developer_id')->references('id')->on('developer')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('publisher_id')->references('id')->on('publisher')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('user')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game');
    }
};
