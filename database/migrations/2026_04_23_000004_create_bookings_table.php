<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->string('booking_ref')->unique();
            $table->enum('status', [
                'inquiry', 'confirmed', 'deposit_paid', 'fully_paid',
                'visa_processing', 'visa_approved', 'visa_rejected',
                'departed', 'completed', 'cancelled', 'refunded'
            ])->default('inquiry');
            $table->date('travel_date')->nullable();
            $table->date('return_date')->nullable();
            $table->integer('pax_adults')->default(1);
            $table->integer('pax_children')->default(0);
            $table->integer('pax_infants')->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->string('room_preference')->nullable();
            $table->json('special_requests')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('cancelled_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
