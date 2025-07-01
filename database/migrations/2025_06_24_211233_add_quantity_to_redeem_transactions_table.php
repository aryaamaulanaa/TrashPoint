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
        Schema::table('redeem_transactions', function (Blueprint $table) {
            // Tambahkan kolom quantity setelah koin_used
            $table->integer('quantity')->default(1)->after('koin_used');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('redeem_transactions', function (Blueprint $table) {
            // Hapus kolom quantity jika rollback
            $table->dropColumn('quantity');
        });
    }
};