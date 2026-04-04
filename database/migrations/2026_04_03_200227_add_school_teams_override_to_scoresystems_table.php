<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scoresystems', function (Blueprint $table) {
            $table->integer('school_teams_override')->nullable()->after('bonus_score');
        });
    }

    public function down(): void
    {
        Schema::table('scoresystems', function (Blueprint $table) {
            $table->dropColumn('school_teams_override');
        });
    }
};
