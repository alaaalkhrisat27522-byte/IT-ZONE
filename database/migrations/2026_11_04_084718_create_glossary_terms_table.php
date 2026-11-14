<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('glossary_terms', function (Blueprint $table) {
            $table->id();
            $table->string('term', 150);
            $table->string('slug', 190)->unique();
            $table->string('short_definition', 500);
            $table->text('detailed_definition')->nullable();
            $table->string('major', 150)->nullable();
            $table->json('related_majors')->nullable();
            $table->text('example')->nullable();
            $table->string('difficulty', 20)->default('مبتدئ');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('glossary_terms');
    }
};
