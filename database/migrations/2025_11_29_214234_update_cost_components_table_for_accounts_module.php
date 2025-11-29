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
        // Add name column first
        Schema::table('cost_components', function (Blueprint $table) {
            $table->string('name')->after('lead_id');
        });
        
        // Migrate data: combine type and description into name
        DB::statement("UPDATE cost_components SET name = CONCAT(COALESCE(type, ''), ' - ', COALESCE(description, ''))");
        
        // Drop old columns
        Schema::table('cost_components', function (Blueprint $table) {
            $table->dropColumn(['type', 'description']);
        });
        
        // Rename entered_by to entered_by_user_id
        DB::statement("ALTER TABLE cost_components CHANGE entered_by entered_by_user_id BIGINT UNSIGNED");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back old columns
        Schema::table('cost_components', function (Blueprint $table) {
            $table->enum('type', ['hotel', 'transport', 'visa', 'insurance', 'meal', 'guide', 'other'])->default('other')->after('lead_id');
            $table->string('description')->after('type');
        });
        
        // Try to extract type and description from name (basic attempt)
        DB::statement("UPDATE cost_components SET type = 'other', description = name");
        
        // Drop name column
        Schema::table('cost_components', function (Blueprint $table) {
            $table->dropColumn('name');
        });
        
        // Rename back
        DB::statement("ALTER TABLE cost_components CHANGE entered_by_user_id entered_by BIGINT UNSIGNED");
    }
};
