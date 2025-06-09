<?php
// database/migrations/2023_01_01_000000_create_comments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('message');                    // Kommentartext
            $table->string('author_name', 50)->nullable(); // Autor Name (optional)
            $table->string('ip_address', 45);           // Für IPv4/IPv6 (privat)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
