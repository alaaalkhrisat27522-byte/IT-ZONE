<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutorial_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->text('description')->nullable();
            $table->string('color', 20)->nullable();
            $table->string('icon', 50)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tutorials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('tutorial_categories')->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['summary', 'mindmap', 'video'])->default('summary');
            $table->string('course_name')->nullable();
            $table->string('major')->nullable();
            $table->text('excerpt')->nullable();
            $table->string('file_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('source_code_url')->nullable();
            $table->string('author')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('downloads_count')->default(0);
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutorials');
        Schema::dropIfExists('tutorial_categories');
    }
};
