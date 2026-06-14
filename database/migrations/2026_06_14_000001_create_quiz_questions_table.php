<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->unsignedSmallInteger('order')->default(0);
            $table->text('question_text');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c')->nullable();
            $table->string('option_d')->nullable();
            $table->char('correct_option', 1);
            $table->unsignedInteger('marks')->default(1);
            $table->timestamps();
        });

        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->json('answers')->nullable()->after('submitted_at');
        });
    }

    public function down()
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->dropColumn('answers');
        });

        Schema::dropIfExists('quiz_questions');
    }
}
