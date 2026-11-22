<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->foreignId('project_id')
                  ->after('id')
                  ->constrained('projects')
                  ->cascadeOnDelete();

            $table->foreignId('developer_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->unsignedBigInteger('harga');
            $table->unsignedInteger('durasi');
            $table->text('proposal');

            $table->boolean('is_winner')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['developer_id']);

            $table->dropColumn([
                'project_id',
                'developer_id',
                'harga',
                'durasi',
                'proposal',
                'is_winner',
            ]);
        });
    }
};
