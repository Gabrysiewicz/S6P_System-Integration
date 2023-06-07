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
        Schema::create('steam', function (Blueprint $table) {
            $table->increments('id');   
            $table->decimal('price', 6, 2);
            $table->date('release_date');
            $table->unsignedInteger('game_id');
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('game')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steam');
    }
};
