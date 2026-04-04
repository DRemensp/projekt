<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Discipline;
use App\Models\Team;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discipline_team', function (Blueprint $table) {
            $table->id();

            // FK auf disciplines
            $table
                ->foreignIdFor(Discipline::class)
                ->constrained()
                ->cascadeOnDelete();

            // FK auf teams
            $table
                ->foreignIdFor(Team::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('score_1', 6)->nullable();
            $table->decimal('score_2', 6)->nullable();

            $table->timestamps();

            $table->unique(['discipline_id', 'team_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discipline_team');
    }
};
