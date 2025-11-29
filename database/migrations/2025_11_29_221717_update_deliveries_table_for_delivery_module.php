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
        Schema::table('deliveries', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('deliveries', 'assigned_to')) {
                $table->dropForeign(['assigned_to']);
                $table->dropColumn('assigned_to');
            }
            if (Schema::hasColumn('deliveries', 'attachments')) {
                $table->dropColumn('attachments');
            }
            if (Schema::hasColumn('deliveries', 'tracking_info')) {
                $table->dropColumn('tracking_info');
            }
            if (Schema::hasColumn('deliveries', 'expected_delivery_date')) {
                $table->dropColumn('expected_delivery_date');
            }
            if (Schema::hasColumn('deliveries', 'actual_delivery_date')) {
                $table->dropColumn('actual_delivery_date');
            }
            if (Schema::hasColumn('deliveries', 'delivery_notes')) {
                $table->dropColumn('delivery_notes');
            }
            
            // Rename status column if it exists
            if (Schema::hasColumn('deliveries', 'status')) {
                $table->renameColumn('status', 'delivery_status');
            }
            
            // Add new columns
            $table->foreignId('operation_id')->nullable()->after('lead_id')->constrained('operations')->nullOnDelete();
            $table->foreignId('assigned_to_delivery_user_id')->nullable()->after('operation_id')->constrained('users')->nullOnDelete();
            
            // Update delivery_status enum if column exists, otherwise create it
            if (Schema::hasColumn('deliveries', 'delivery_status')) {
                // For MySQL, we need to drop and recreate the enum
                $table->enum('delivery_status', ['Pending', 'In_Process', 'Delivered'])->default('Pending')->change();
            } else {
                $table->enum('delivery_status', ['Pending', 'In_Process', 'Delivered'])->default('Pending');
            }
            
            $table->enum('delivery_method', ['soft_copy', 'courier', 'hand_delivery'])->nullable()->after('delivery_status');
            $table->text('remarks')->nullable()->after('delivery_method');
            $table->timestamp('delivered_at')->nullable()->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            // Restore old columns
            $table->dropForeign(['operation_id']);
            $table->dropColumn('operation_id');
            $table->dropForeign(['assigned_to_delivery_user_id']);
            $table->dropColumn('assigned_to_delivery_user_id');
            $table->dropColumn('delivery_method');
            $table->dropColumn('remarks');
            $table->dropColumn('delivered_at');
            
            // Restore old structure
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->text('attachments')->nullable();
            $table->text('tracking_info')->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->date('actual_delivery_date')->nullable();
            $table->text('delivery_notes')->nullable();
        });
    }
};
