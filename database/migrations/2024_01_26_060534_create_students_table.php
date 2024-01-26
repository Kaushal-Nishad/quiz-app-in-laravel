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
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->integer('register_no');
            $table->string('student_name');
            $table->string('stu_image')->nullable();
            $table->string('father_name');
            $table->string('date_of_birth');
            $table->string('gender');
            $table->string('phone');
            $table->string('address');
            $table->string('subjects');
            $table->string('email');
            $table->text('password');
            $table->tinyInteger('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
