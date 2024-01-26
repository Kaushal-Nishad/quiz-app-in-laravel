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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id('teacher_id');
            $table->integer('register_no');
            $table->string('teacher_name');
            $table->string('designation');
            $table->string('date_of_birth');
            $table->string('gender');
            $table->string('phone');
            $table->string('address');
            $table->string('join_date');
            $table->string('last_day')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('teachers');
    }
};
