<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_text_en');
            $table->string('question_text_ar');
            $table->enum('question_type', ['text', 'number', 'date', 'select', 'radio', 'checkbox', 'textarea'])->default('text');
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->string('validation_rules')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_questions');
    }
};
