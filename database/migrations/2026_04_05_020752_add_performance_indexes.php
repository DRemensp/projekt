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
        Schema::table('teams', function (Blueprint $table) {
            $table->index('klasse_id');
            $table->index('score');
        });

        Schema::table('klasses', function (Blueprint $table) {
            $table->index('school_id');
            $table->index('score');
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->index('score');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index('created_at');
            $table->index(['created_at', 'klasse_name']);
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropIndex(['klasse_id']);
            $table->dropIndex(['score']);
        });

        Schema::table('klasses', function (Blueprint $table) {
            $table->dropIndex(['school_id']);
            $table->dropIndex(['score']);
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->dropIndex(['score']);
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['created_at', 'klasse_name']);
        });
    }
};
