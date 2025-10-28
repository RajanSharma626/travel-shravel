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
        Schema::create('leads', function (Blueprint $table) {
        $table->id();
        $table->integer('tsq_number')->nullable();      // for TSQ counter
        $table->string('tsq')->nullable();              // TSQ1600 etc.
        $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
        $table->foreignId('destination_id')->nullable()->constrained('destinations')->nullOnDelete();
        $table->string('customer_name');
        $table->string('phone', 20);
        $table->string('email')->nullable();
        $table->string('address')->nullable();
        $table->date('travel_date')->nullable();
        $table->integer('adults')->default(1);
        $table->integer('children')->default(0);
        $table->integer('infants')->default(0);
        $table->foreignId('assigned_user_id')->nullable()->constrained('users')->nullOnDelete();
        $table->decimal('selling_price', 12, 2)->nullable();
        $table->decimal('booked_value', 12, 2)->nullable();
        $table->string('status')->default('new');       // new/contacted/follow_up/booked/closed
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
