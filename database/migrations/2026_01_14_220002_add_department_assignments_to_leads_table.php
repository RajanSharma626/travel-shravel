<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->foreignId('post_sales_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('operations_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('ticketing_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('visa_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('insurance_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('accountant_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('delivery_user_id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropConstrainedForeignId('post_sales_user_id');
            $table->dropConstrainedForeignId('operations_user_id');
            $table->dropConstrainedForeignId('ticketing_user_id');
            $table->dropConstrainedForeignId('visa_user_id');
            $table->dropConstrainedForeignId('insurance_user_id');
            $table->dropConstrainedForeignId('accountant_user_id');
            $table->dropConstrainedForeignId('delivery_user_id');
        });
    }
};
