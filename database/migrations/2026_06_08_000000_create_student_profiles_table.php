<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('student_id_number')->unique();
            $table->date('date_of_birth');
            $table->string('gender', 30);
            $table->string('school_name')->nullable();
            $table->text('home_address');
            $table->string('guardian_name');
            $table->string('guardian_contact_number', 50);
            $table->string('emergency_contact_number', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
