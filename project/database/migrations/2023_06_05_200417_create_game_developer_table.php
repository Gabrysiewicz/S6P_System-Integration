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
        Schema::create('game_developer', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('developer_id');
            $table->unsignedInteger('game_id');

            $table->foreign('developer_id')->references('id')->on('developer')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('game_id')->references('id')->on('game')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_developer');
    }
};
