<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('customer_name');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->nullable()->after('middle_name');

            $table->string('primary_phone', 20)->nullable()->after('phone');
            $table->string('secondary_phone', 20)->nullable()->after('primary_phone');
            $table->string('other_phone', 20)->nullable()->after('secondary_phone');
        });

        DB::table('leads')
            ->select('id', 'customer_name', 'phone')
            ->orderBy('id')
            ->chunkById(100, function ($leads) {
                foreach ($leads as $lead) {
                    $name = trim($lead->customer_name ?? '');
                    $firstName = $name ?: null;
                    $middleName = null;
                    $lastName = null;

                    if ($name !== '') {
                        $parts = preg_split('/\s+/', $name) ?: [];
                        if (!empty($parts)) {
                            $firstName = array_shift($parts);
                            if (!empty($parts)) {
                                $lastName = array_pop($parts);
                                if (!empty($parts)) {
                                    $middleName = implode(' ', $parts);
                                }
                            }
                        }
                    }

                    DB::table('leads')
                        ->where('id', $lead->id)
                        ->update([
                            'first_name' => $firstName,
                            'middle_name' => $middleName,
                            'last_name' => $lastName,
                            'primary_phone' => $lead->phone,
                        ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'middle_name',
                'last_name',
                'primary_phone',
                'secondary_phone',
                'other_phone',
            ]);
        });
    }
};
