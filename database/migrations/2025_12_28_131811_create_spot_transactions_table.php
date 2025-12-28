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
        Schema::create('spot_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['deposit', 'withdraw', 'buy', 'sell']);
            $table->string('pair')->nullable(); // e.g., BTC/USDT (Nullable for Deposit/Withdraw)
            $table->decimal('price', 18, 8)->nullable(); // Price per coin
            $table->decimal('amount', 18, 8); // Quantity of coin (or amount of USDT for Dep/WD)
            $table->decimal('value', 18, 2); // Total value in USDT/IDR
            $table->string('txid')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spot_transactions');
    }
};
