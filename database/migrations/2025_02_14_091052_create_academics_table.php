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
        Schema::create('academics', function (Blueprint $table) {
            $table->id('academic_id');
            $table->string('student_id', 20);
            $table->string('student_number', 20);
            $table->enum('enrollment_status', ['Enrolled', 'Dropped', 'Graduated']);
            $table->integer('year_level');
            $table->string('college', 100);
            $table->string('program', 100);
            $table->string('section', 20);
            $table->decimal('gwa', 3, 2);
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academics');
    }
};
