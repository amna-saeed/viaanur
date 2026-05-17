<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained('lessons')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('total_marks')->default(100);
            $table->integer('passing_marks')->default(40);
            $table->integer('attempt_limit')->default(3);
            $table->integer('duration_minutes')->nullable(); // Quiz duration in minutes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
