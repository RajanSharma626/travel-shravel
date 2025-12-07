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
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['country', 'state', 'city', 'description', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('country')->nullable()->after('name');
            $table->string('state')->nullable()->after('country');
            $table->string('city')->nullable()->after('state');
            $table->text('description')->nullable()->after('city');
            $table->boolean('is_active')->default(true)->after('description');
        });
    }
};
