<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lms_enrollments', function (Blueprint $table) {
            $table->string('status', 20)->default('approved')->after('course_id');
            $table->timestamp('approved_at')->nullable()->after('status');
        });

        DB::table('lms_enrollments')->update([
            'status' => 'approved',
            'approved_at' => DB::raw('created_at'),
        ]);
    }

    public function down(): void
    {
        Schema::table('lms_enrollments', function (Blueprint $table) {
            $table->dropColumn(['status', 'approved_at']);
        });
    }
};
