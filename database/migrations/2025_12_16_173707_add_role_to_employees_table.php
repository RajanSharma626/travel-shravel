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
        Schema::table('employees', function (Blueprint $table) {
            $table->enum('role', [
                'Admin',
                'Sales Manager',
                'Sales',
                'Operation Manager',
                'Operation',
                'Accounts Manager',
                'Accounts',
                'Post Sales Manager',
                'Post Sales',
                'Delivery Manager',
                'Delivery',
                'HR',
                'Developer'
            ])->nullable()->after('login_access_rights');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
