<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk tabel contacts
 * 
 * Struktur sesuai ERD:
 * - id, user_id (FK), subject, message, status
 * - Foreign key ke users dengan cascade on delete
 */
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('subject', 200);
            $table->text('message');
            $table->enum('status', ['pending', 'read', 'replied'])->default('pending');
            $table->timestamps();

            // Index untuk filter status dan user
            $table->index('status');
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
