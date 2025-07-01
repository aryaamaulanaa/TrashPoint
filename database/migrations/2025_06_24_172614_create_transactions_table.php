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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->decimal('estimated_weight_kg', 8, 2);
            $table->decimal('actual_weight_kg', 8, 2)->nullable();
            $table->decimal('koin_earned', 10, 2)->nullable();
            $table->text('pickup_address');
            $table->string('pickup_phone_number');
            $table->enum('status', ['pending', 'dijemput', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};