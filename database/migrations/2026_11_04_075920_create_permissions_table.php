<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->enum('module', [
                'users',
                'ai_assistant',
                'academic_plans',
                'tutorials',
                'achievements',
                'tools',
                'study_rooms',
                'system'
            ]);
            $table->enum('action', ['create', 'read', 'update', 'delete', 'manage']);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
