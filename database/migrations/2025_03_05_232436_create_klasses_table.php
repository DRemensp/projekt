<?php

use App\Models\School;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('klasses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(School::class)
            ->constrained()
            ->cascadeOnDelete();
            $table->integer('score')->default(0);
            $table->string('name');
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klasses');
    }
};
