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
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_id')->unique()->nullable()->after('id');
            $table->enum('salutation', ['Mr', 'Mrs', 'Miss', 'Ms', 'Dr', 'Prof'])->nullable()->after('user_id');
            $table->string('first_name')->nullable()->after('salutation');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->nullable()->after('middle_name');
            $table->date('dob')->nullable()->after('last_name');
            $table->string('phone')->nullable()->after('dob');
            $table->string('address_line')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address_line');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
            $table->string('pin_code', 20)->nullable()->after('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'user_id',
                'salutation',
                'first_name',
                'middle_name',
                'last_name',
                'dob',
                'phone',
                'address_line',
                'city',
                'state',
                'country',
                'pin_code',
            ]);
        });
    }
};
