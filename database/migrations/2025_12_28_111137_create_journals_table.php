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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('pair'); // e.g., BTC/USDT
            $table->enum('direction', ['long', 'short']);
            $table->integer('leverage');
            $table->decimal('margin', 15, 2);
            $table->decimal('entry_price', 20, 8);
            $table->decimal('exit_price', 20, 8);
            $table->decimal('pnl_value', 15, 2); // Profit/Loss in USDT
            $table->decimal('pnl_percentage', 8, 2); // ROI %
            $table->enum('status', ['win', 'loss', 'be']); // Win, Loss, Break Even
            $table->text('notes')->nullable();
            $table->string('image_path')->nullable();
            $table->date('trade_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
