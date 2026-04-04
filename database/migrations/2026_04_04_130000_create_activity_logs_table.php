<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name');
            $table->enum('action', ['score_added', 'score_updated', 'score_cleared', 'login']);
            $table->unsignedBigInteger('discipline_id')->nullable()->index();
            $table->string('discipline_name')->nullable();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->string('team_name')->nullable();
            $table->string('klasse_name')->nullable();
            $table->enum('field', ['score_1', 'score_2'])->nullable();
            $table->decimal('old_value', 10, 3)->nullable();
            $table->decimal('new_value', 10, 3)->nullable();
            $table->enum('severity', ['normal', 'warning', 'danger'])->default('normal');
            $table->unsignedInteger('seconds_since_last')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
