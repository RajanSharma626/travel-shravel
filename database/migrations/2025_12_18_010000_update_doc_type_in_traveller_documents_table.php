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
        // Change doc_type from ENUM to simple VARCHAR so we can support more types easily
        DB::statement("ALTER TABLE traveller_documents MODIFY COLUMN doc_type VARCHAR(50) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original ENUM definition used at creation time
        DB::statement("ALTER TABLE traveller_documents MODIFY COLUMN doc_type ENUM('passport', 'aadhar_pan_others', 'not_required', 'required_again') NOT NULL");
    }
};


