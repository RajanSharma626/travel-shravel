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
            
            // Add new columns first
            $table->foreignId('operation_id')->nullable()->after('lead_id')->constrained('operations')->nullOnDelete();
            $table->foreignId('assigned_to_delivery_user_id')->nullable()->after('operation_id')->constrained('users')->nullOnDelete();
            
            // Handle status/delivery_status column using raw SQL for MySQL compatibility
            if (Schema::hasColumn('deliveries', 'status') && !Schema::hasColumn('deliveries', 'delivery_status')) {
                // Rename status to delivery_status and update enum values
                DB::statement("ALTER TABLE `deliveries` CHANGE COLUMN `status` `delivery_status` ENUM('Pending', 'In_Process', 'Delivered') NOT NULL DEFAULT 'Pending'");
            } elseif (Schema::hasColumn('deliveries', 'delivery_status')) {
                // Update existing delivery_status enum
                DB::statement("ALTER TABLE `deliveries` MODIFY COLUMN `delivery_status` ENUM('Pending', 'In_Process', 'Delivered') NOT NULL DEFAULT 'Pending'");
            } else {
                // Create new delivery_status column
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
