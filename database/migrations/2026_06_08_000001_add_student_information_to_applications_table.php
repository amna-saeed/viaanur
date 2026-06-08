<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('student_id_number')->nullable()->after('phone');
            $table->date('date_of_birth')->nullable()->after('student_id_number');
            $table->string('gender', 30)->nullable()->after('date_of_birth');
            $table->string('school_name')->nullable()->after('gender');
            $table->text('home_address')->nullable()->after('school_name');
            $table->string('guardian_name')->nullable()->after('home_address');
            $table->string('guardian_contact_number', 50)->nullable()->after('guardian_name');
            $table->string('emergency_contact_number', 50)->nullable()->after('guardian_contact_number');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'student_id_number',
                'date_of_birth',
                'gender',
                'school_name',
                'home_address',
                'guardian_name',
                'guardian_contact_number',
                'emergency_contact_number',
            ]);
        });
    }
};
