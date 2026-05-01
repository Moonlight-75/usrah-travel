<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('payment_ref')->unique();
            $table->enum('type', ['deposit', 'installment', 'full', 'refund'])->default('deposit');
            $table->decimal('amount', 12, 2);
            $table->enum('method', ['bank_transfer', 'cash', 'online', 'credit_card'])->default('bank_transfer');
            $table->enum('status', ['pending', 'verified', 'failed', 'refunded'])->default('pending');
            $table->date('due_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->string('receipt_path')->nullable();
            $table->text('notes')->nullable();
            $table->string('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
