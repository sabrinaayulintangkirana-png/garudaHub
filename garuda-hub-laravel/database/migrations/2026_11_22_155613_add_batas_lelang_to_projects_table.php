<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('client_id')
                  ->after('id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('judul', 255);
            $table->text('deskripsi');
            $table->string('kategori', 100);

            $table->unsignedBigInteger('budget_min');
            $table->unsignedBigInteger('budget_max');

            $table->date('batas_lelang');

            $table->enum('status', ['terbuka', 'ditutup'])
                  ->default('terbuka');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['client_id']);

            $table->dropColumn([
                'client_id',
                'judul',
                'deskripsi',
                'kategori',
                'budget_min',
                'budget_max',
                'batas_lelang',
                'status',
            ]);
        });
    }
};
