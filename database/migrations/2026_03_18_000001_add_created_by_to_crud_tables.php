<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk menambahkan kolom created_by ke tabel yang terkena CRUD.
 * 
 * Kolom created_by merupakan FK nullable ke tabel users.
 * Jika user dihapus, nilai created_by akan otomatis menjadi NULL (nullOnDelete).
 */
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['categories', 'products', 'banners', 'testimonials'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->foreignId('created_by')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['categories', 'products', 'banners', 'testimonials'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropForeign([$t->getTable() . '_created_by_foreign' => 'created_by']);
                $t->dropColumn('created_by');
            });
        }
    }
};
