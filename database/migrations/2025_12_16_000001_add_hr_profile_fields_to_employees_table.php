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
            // Official profile
            $table->string('salutation')->nullable()->after('employee_id');
            $table->date('date_of_birth')->nullable()->after('name'); // keep legacy dob for compatibility
            $table->string('marital_status')->nullable()->after('date_of_birth');
            $table->string('blood_group')->nullable()->after('marital_status');
            $table->string('date_of_joining')->nullable()->after('branch_location'); // string for flexibility
            $table->string('date_of_leaving')->nullable()->after('date_of_joining');
            $table->string('employment_type')->nullable()->after('designation');
            $table->string('employment_status')->nullable()->after('employment_type');
            $table->decimal('starting_salary', 12, 2)->nullable()->after('employment_status');
            $table->decimal('last_withdrawn_salary', 12, 2)->nullable()->after('starting_salary');

            // Login details
            $table->string('user_id')->nullable()->after('crm_access_user_id');
            $table->string('login_work_email')->nullable()->after('user_id');
            $table->string('password')->nullable()->after('login_work_email');
            $table->string('login_access_rights')->nullable()->after('password');

            // Basic information
            $table->string('previous_employer')->nullable()->after('emergency_contact');
            $table->string('previous_employer_contact_person')->nullable()->after('previous_employer');
            $table->string('previous_employer_contact_number')->nullable()->after('previous_employer_contact_person');
            $table->string('reason_for_leaving')->nullable()->after('previous_employer_contact_number');
            $table->string('highest_qualification')->nullable()->after('reason_for_leaving');
            $table->string('specialization')->nullable()->after('highest_qualification');
            $table->string('year_of_passing')->nullable()->after('specialization');
            $table->string('work_experience')->nullable()->after('year_of_passing');
            $table->string('father_mother_name')->nullable()->after('work_experience');
            $table->string('father_mother_contact_number')->nullable()->after('father_mother_name');
            $table->string('nominee_name')->nullable()->after('father_mother_contact_number');
            $table->string('nominee_contact_number')->nullable()->after('nominee_name');
            $table->string('aadhar_number')->nullable()->after('nominee_contact_number');
            $table->string('pan_number')->nullable()->after('aadhar_number');
            $table->string('passport_number')->nullable()->after('pan_number');

            // Addresses
            $table->text('present_address')->nullable()->after('passport_number');
            $table->text('permanent_address')->nullable()->after('present_address');
            $table->boolean('permanent_same_as_present')->default(false)->after('permanent_address');

            // Incentive & performance
            $table->boolean('incentive_eligibility')->default(false)->after('permanent_same_as_present');
            $table->string('incentive_type')->nullable()->after('incentive_eligibility');
            $table->string('monthly_target')->nullable()->after('incentive_type');
            $table->string('incentive_payout_date')->nullable()->after('monthly_target');

            // Statutory & payroll
            $table->string('bank_name')->nullable()->after('incentive_payout_date');
            $table->string('account_number')->nullable()->after('bank_name');
            $table->string('ifsc_code')->nullable()->after('account_number');
            $table->string('salary_structure')->nullable()->after('ifsc_code');
            $table->string('pf_number')->nullable()->after('salary_structure');
            $table->string('esic_number')->nullable()->after('pf_number');
            $table->string('uan_number')->nullable()->after('esic_number');

            // Exit & clearance
            $table->string('exit_initiated_by')->nullable()->after('uan_number');
            $table->string('resignation_date')->nullable()->after('exit_initiated_by');
            $table->string('notice_period')->nullable()->after('resignation_date');
            $table->string('last_working_day')->nullable()->after('notice_period');
            $table->string('exit_interview_notes')->nullable()->after('last_working_day');
            $table->boolean('service_certificate_issued')->default(false)->after('exit_interview_notes');
            $table->string('service_certificate_issue_date')->nullable()->after('service_certificate_issued');
            $table->boolean('handed_over_laptop')->default(false)->after('service_certificate_issue_date');
            $table->boolean('handed_over_mobile')->default(false)->after('handed_over_laptop');
            $table->boolean('handed_over_id_card')->default(false)->after('handed_over_mobile');
            $table->boolean('all_dues_cleared')->default(false)->after('handed_over_id_card');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'salutation',
                'date_of_birth',
                'marital_status',
                'blood_group',
                'date_of_joining',
                'date_of_leaving',
                'employment_type',
                'employment_status',
                'starting_salary',
                'last_withdrawn_salary',
                'user_id',
                'login_work_email',
                'password',
                'login_access_rights',
                'previous_employer',
                'previous_employer_contact_person',
                'previous_employer_contact_number',
                'reason_for_leaving',
                'highest_qualification',
                'specialization',
                'year_of_passing',
                'work_experience',
                'father_mother_name',
                'father_mother_contact_number',
                'nominee_name',
                'nominee_contact_number',
                'aadhar_number',
                'pan_number',
                'passport_number',
                'present_address',
                'permanent_address',
                'permanent_same_as_present',
                'incentive_eligibility',
                'incentive_type',
                'monthly_target',
                'incentive_payout_date',
                'bank_name',
                'account_number',
                'ifsc_code',
                'salary_structure',
                'pf_number',
                'esic_number',
                'uan_number',
                'exit_initiated_by',
                'resignation_date',
                'notice_period',
                'last_working_day',
                'exit_interview_notes',
                'service_certificate_issued',
                'service_certificate_issue_date',
                'handed_over_laptop',
                'handed_over_mobile',
                'handed_over_id_card',
                'all_dues_cleared',
            ]);
        });
    }
};

