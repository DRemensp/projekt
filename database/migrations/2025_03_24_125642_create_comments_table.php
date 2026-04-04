<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->string('author_name', 50)->nullable();
            $table->string('ip_address', 45);           // nur in datenbank sichtbar
            $table->enum('moderation_status', ['pending', 'approved', 'blocked'])->default('pending');
            $table->json('moderation_scores')->nullable();
            $table->text('moderation_reason')->nullable();
            $table->timestamp('moderated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
