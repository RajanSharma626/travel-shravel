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
        Schema::table('leads', function (Blueprint $table) {
            if (!Schema::hasColumn('leads', 'children_2_5')) {
                $table->integer('children_2_5')->default(0)->after('children');
            }

            if (!Schema::hasColumn('leads', 'children_6_11')) {
                $table->integer('children_6_11')->default(0)->after('children_2_5');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'children_2_5')) {
                $table->dropColumn('children_2_5');
            }

            if (Schema::hasColumn('leads', 'children_6_11')) {
                $table->dropColumn('children_6_11');
            }
        });
    }
};



