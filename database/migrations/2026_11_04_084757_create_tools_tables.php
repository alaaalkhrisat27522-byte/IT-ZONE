<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tool_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->text('description')->nullable();
            $table->string('color', 20)->nullable();
            $table->string('icon', 50)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('tool_categories')->onDelete('set null');
            $table->string('name', 150);
            $table->string('slug', 190)->unique();
            $table->text('description')->nullable();
            $table->string('url', 500)->nullable();
            $table->string('icon', 50)->nullable();
            $table->boolean('is_free')->default(true);
            $table->boolean('is_approved')->default(true);
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tools');
        Schema::dropIfExists('tool_categories');
    }
};
