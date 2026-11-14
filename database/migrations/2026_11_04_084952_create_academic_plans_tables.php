<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_ref', 100)->unique();
            $table->string('major', 150);
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('total_hours')->default(0);
            $table->integer('total_courses')->default(0);
            $table->string('source')->nullable();
            $table->timestamps();
        });

        Schema::create('curriculum_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('academic_plans')->onDelete('cascade');
            $table->string('plan_ref', 100);
            $table->string('name');
            $table->string('code', 30)->unique();
            $table->integer('hours')->default(3);
            $table->string('prerequisite_code', 30)->nullable();
            $table->string('prerequisite_name')->nullable();
            $table->string('prerequisite_note')->nullable();
            $table->string('category', 50)->default('major');
            $table->boolean('is_required')->default(true);
            $table->string('major')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_courses');
        Schema::dropIfExists('academic_plans');
    }
};
