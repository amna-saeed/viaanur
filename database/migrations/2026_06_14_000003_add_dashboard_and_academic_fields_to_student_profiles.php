<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->unsignedInteger('total_sessions_booked')->default(0)->after('emergency_contact_number');
            $table->unsignedInteger('total_sessions_attended')->default(0)->after('total_sessions_booked');
            $table->date('last_session_date')->nullable()->after('total_sessions_attended');
            $table->date('next_session_date')->nullable()->after('last_session_date');
            $table->decimal('homework_completion_rate', 5, 2)->nullable()->after('next_session_date');
            $table->decimal('assessment_average', 5, 2)->nullable()->after('homework_completion_rate');
            $table->decimal('progress_score', 5, 2)->nullable()->after('assessment_average');

            $table->text('subjects_enrolled')->nullable()->after('progress_score');
            $table->string('academic_level')->nullable()->after('subjects_enrolled');
            $table->string('current_working_grade')->nullable()->after('academic_level');
            $table->string('target_grade')->nullable()->after('current_working_grade');
            $table->text('learning_goals')->nullable()->after('target_grade');
            $table->text('areas_for_improvement')->nullable()->after('learning_goals');
            $table->text('send_learning_needs')->nullable()->after('areas_for_improvement');
            $table->text('eal_notes')->nullable()->after('send_learning_needs');
        });
    }

    public function down(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'total_sessions_booked',
                'total_sessions_attended',
                'last_session_date',
                'next_session_date',
                'homework_completion_rate',
                'assessment_average',
                'progress_score',
                'subjects_enrolled',
                'academic_level',
                'current_working_grade',
                'target_grade',
                'learning_goals',
                'areas_for_improvement',
                'send_learning_needs',
                'eal_notes',
            ]);
        });
    }
};
