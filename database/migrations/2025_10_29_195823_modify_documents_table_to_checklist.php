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
        Schema::table('documents', function (Blueprint $table) {
            // Remove file-related columns
            $table->dropColumn(['file_path', 'file_name', 'file_size']);
            
            // Change uploaded_by to received_by (optional, or keep as is)
            // $table->renameColumn('uploaded_by', 'received_by');
            
            // Update status enum to include 'not_received'
            $table->dropColumn('status');
        });
        
        Schema::table('documents', function (Blueprint $table) {
            // Add new status enum
            $table->enum('status', ['not_received', 'received', 'verified', 'rejected'])->default('not_received')->after('type');
            
            // Add received_by and verified_by fields
            $table->foreignId('received_by')->nullable()->after('uploaded_by')->constrained('users')->onDelete('set null');
            $table->foreignId('verified_by')->nullable()->after('received_by')->constrained('users')->onDelete('set null');
            $table->timestamp('received_at')->nullable()->after('verified_by');
            $table->timestamp('verified_at')->nullable()->after('received_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['received_by', 'verified_by', 'received_at', 'verified_at']);
            $table->dropColumn('status');
        });
        
        Schema::table('documents', function (Blueprint $table) {
            $table->string('file_path');
            $table->string('file_name')->nullable();
            $table->integer('file_size')->nullable();
            $table->enum('status', ['pending', 'received', 'verified', 'rejected'])->default('pending');
        });
    }
};
