<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk tabel products
 * 
 * Struktur sesuai ERD:
 * - id, name, category_id (FK), slug, price, description, image, stock
 * - Dengan soft deletes untuk keamanan data
 * - Foreign key ke categories dengan restrict on delete
 */
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->foreignId('category_id')
                ->constrained('categories')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->string('slug')->unique();
            $table->decimal('price', 12, 2);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Index untuk optimasi query search dan filter
            $table->index('name');
            $table->index('slug');
            $table->index('price');
            $table->index(['category_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
