<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new columns first
        Schema::table('payments', function (Blueprint $table) {
            $table->string('reference')->nullable()->after('method');
            $table->foreignId('created_by')->nullable()->after('status')->constrained('users')->onDelete('set null');
        });
        
        // Migrate data: map old status to new status
        // pending -> pending, partial -> pending, paid -> received, overdue -> pending
        DB::statement("UPDATE payments SET status = CASE 
            WHEN status = 'paid' THEN 'received'
            ELSE 'pending'
        END");
        
        // Update status enum values
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending', 'received', 'refunded') DEFAULT 'pending'");
        
        // Rename paid_on to payment_date (using raw SQL as Laravel doesn't support renameColumn well)
        DB::statement("ALTER TABLE payments CHANGE paid_on payment_date DATE");
        
        // Set created_by for existing records if possible
        DB::statement("UPDATE payments SET created_by = 1 WHERE created_by IS NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert status enum
        DB::statement("UPDATE payments SET status = CASE 
            WHEN status = 'received' THEN 'paid'
            ELSE 'pending'
        END");
        
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending', 'partial', 'paid', 'overdue') DEFAULT 'pending'");
        
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['reference', 'created_by']);
        });
        
        DB::statement("ALTER TABLE payments CHANGE payment_date paid_on DATE");
    }
};
