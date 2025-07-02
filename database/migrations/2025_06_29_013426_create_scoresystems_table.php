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
        Schema::create('scoresystems', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')
                ->default(true)
                ->unique();
            $table->integer('first_place');
            $table->integer('second_place');
            $table->integer('third_place');
            $table->integer('max_score');
            $table->integer('score_step');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scoresystems');
    }
};
