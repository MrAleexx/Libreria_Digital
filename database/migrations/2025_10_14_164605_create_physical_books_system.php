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
        Schema::create('physical_copies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->string('barcode')->unique();
            $table->integer('copy_number')->default(1);
            $table->enum('status', ['available', 'reserved', 'loaned', 'maintenance'])->default('available');
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['status']);
            $table->index(['book_id', 'status']);
        });

        // Reservas de libros físicos
        Schema::create('book_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('physical_copy_id')->nullable()->constrained('physical_copies')->onDelete('set null');
            $table->dateTime('reservation_date');
            $table->dateTime('pickup_deadline');
            $table->enum('status', ['pending', 'ready_for_pickup', 'picked_up', 'cancelled', 'expired'])->default('pending');
            $table->timestamps();

            $table->index(['status']);
            $table->index(['pickup_deadline']);
            $table->index(['user_id', 'status']);
        });

        // Préstamos de libros físicos
        Schema::create('book_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('physical_copy_id')->constrained('physical_copies')->onDelete('cascade');
            $table->foreignId('reservation_id')->nullable()->constrained('book_reservations')->onDelete('set null');
            $table->dateTime('loan_date');
            $table->dateTime('due_date');
            $table->dateTime('actual_return_date')->nullable();
            $table->integer('renewal_count')->default(0);
            $table->enum('status', ['active', 'returned', 'overdue'])->default('active');
            $table->timestamps();

            $table->index(['status']);
            $table->index(['due_date']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_loans');
        Schema::dropIfExists('book_reservations');
        Schema::dropIfExists('physical_copies');
    }
};
