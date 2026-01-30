<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\TransactionStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('account_sender_id')->constrained('accounts')->restrictOnDelete();
            $table->foreignId('account_receiver_id')->constrained('accounts')->restrictOnDelete();
            $table->decimal('amount', 16, 2);
            $table->string('currency', 5);
            $table->json('payload')->nullable();
            $table->enum('status', TransactionStatus::values())->default(TransactionStatus::pending->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
